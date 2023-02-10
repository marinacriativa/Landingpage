<?php

/** 
* Library Auth 
*
* Login class that has Google oAuth support and Recaptcha and database saved sessions
* Author: Vlad
* 
**/
namespace Fyre\Library;

use PDO;

class Authentication {

    const HASH_LENGTH = 40;
    const TOKEN_LENGTH = 20;

    public $isAuthenticated = false;
    public $db              = NULL;

    public function __construct(PDO $db, $config) {

        $this->db       = $db;
        $this->config   = $config;

        //$this->recaptcha_config = $this->config->recaptcha;
        $this->isAuthenticated  = $this->isLogged();
    }

    public function translation($word_key) {

        $sql = "SELECT word FROM translation_words WHERE word_key = '". $word_key ."'";

        $query = $this->db->prepare($sql);        
        $query->execute();
        $res = $query->fetch();
        if (empty($res) == true || $res == null) {

            return $word_key;
        }
    
        return $res->word;
    }

    function login(string $email, string $password, $captcha_response = null) {

        $state              = array();
        $state["success"]   = false;

        /*
        *   Check if the ip is blocked
        */

        if (!$this->isBlocked()) {

            $state["message"] = $this->translation("blocked");
            return $state;
        }

        /*
        *   User input verefication
        */

        $validate_email = $this->validateEmail($email);

        if (!$validate_email["success"]) {
            
            // After $config->max_attemps limit, the ip gets banned
            $this->addAttempt();

            $state["message"] = $validate_email["message"];
            return $state;
        }

        $validate_password = $this->validatePassword($password);

        if (!$validate_password["success"]) {

            // After $config->max_attemps limit, the ip gets banned
            $this->addAttempt();

            $state["message"] = $validate_password["message"];
            return $state;
        }

        /*
        *   Get user info
        */

        $user_id = $this->getUID($email);

        if (!$user_id) {

            // After $config->max_attemps limit, the ip gets banned
            $this->addAttempt();

            $state['message'] = $this->translation("account_not_found");

            return $state;
        }

        $user = $this->getBaseUser($user_id);

        if (!$this->password_verify_with_rehash($password, $user['password'], $user_id)) {

            // After $config->max_attemps limit, the ip gets banned
            $this->addAttempt();

            $state['message'] = $this->translation("email_password_incorrect");

            return $state;
        }

        if ($user['isactive'] != 1) {

            // After $config->max_attemps limit, the ip gets banned
            $this->addAttempt();

            $state['message'] = $this->translation("account_inactive");

            return $state;
        }

        $session = $this->addSession($user['id']);

        if ($session == false) {

            $state['message'] = $this->translation("system_error") . " #01";

            return $state;
        }

        $state['success']      = true;
        $state['message']      = $this->translation("logged_in");

        $state['hash']         = $session['hash'];
        $state['expire']       = $session['expire'];

        $state['cookie_name']  = $this->config->cookie_name;

        return $state;
    } 

    function register(string $email, string $password, string $repeat_password, array $params = [], $captcha_response = null, bool $use_email_activation = false) : array {

        $state              = array();
        $state['success']   = false;

        /*
        *   Check if the ip is blocked
        */

        if (!$this->isBlocked()) {

            $state["message"] = $this->translation("blocked");
            return $state;
        }

        /*
        *   User input verefication
        */

        $validate_email = $this->validateEmail($email);

        if (!$validate_email["success"]) {
            
            // After $config->max_attemps limit, the ip gets banned
            $this->addAttempt();

            $state["message"] = $validate_email["message"];
            return $state;
        }

        $validate_password = $this->validatePassword($password);

        if (!$validate_password["success"]) {

            // After $config->max_attemps limit, the ip gets banned
            $this->addAttempt();

            $state["message"] = $validate_password["message"];
            return $state;
        }

        if ($password !== $repeat_password) {

            // After $config->max_attemps limit, the ip gets banned
            $this->addAttempt();

            $state['message'] = $this->translation("password_nomatch");

            return $state;
        }

        if ($this->isEmailTaken($email)) {

            // After $config->max_attemps limit, the ip gets banned
            $this->addAttempt();

            $state['message'] = $this->translation("email_taken");

            return $state;
        }

        $new_user = $this->addUser($email, $password, $params, $use_email_activation);

        if ($new_user['success'] == false) {

            $state['message'] = $new_user['message'];

            return $state;
        }

        $state['message']  = $new_user['message'];

        $state['success']  = true;
        $state['message']  = $this->translation("register_success");
        $state['id']       = $new_user['id'];
        $state['token']    = $new_user['token'];

        return $state;
    }

    protected function addAttempt() {

        $ip                 = $this->getIp();
        $attempt_expiredate = date("Y-m-d H:i:s", strtotime("+30 minutes"));

        $sql    = "INSERT INTO attempts (ip, expiredate) VALUES (:ip, :expiredate)";
        $query  = $this->db->prepare($sql); 

        return $query->execute([':ip' => $ip, ':expiredate' => $attempt_expiredate]);
    }

    public function isEmailTaken(string $email) {

        $sql = "SELECT count(*) FROM users WHERE email = :email";

        $query = $this->db->prepare($sql);
        $query->execute(['email' => $email]);

        if ($query->fetchColumn() == 0) {

            return false;
        }

        return true;
    }

    public function isBlocked() {

        $ip = $this->getIp();
        $this->deleteAttempts($ip, false);

        $sql    = "SELECT count(*) FROM attempts WHERE ip = :ip";
        $query  = $this->db->prepare($sql);

        $query->execute(['ip' => $ip]);
        $attempts = $query->fetchColumn();

        if ($attempts < (int) $this->config->attempts_before_ban) {

            return true;
        }

        return false;
    }

    protected function getBaseUser(int $user_id) {

        $sql = "SELECT id, email, password, isactive FROM users WHERE id = :id";

        $query = $this->db->prepare($sql);
        $query->execute(['id' => $user_id]);

        $data = $query->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {

            return false;
        }

        return $data;
    }

    protected function addUser(string $email, string $password, array $params = [], bool $use_email_activation = false) : array {
        
        $state['success'] = false;

        $sql    = "INSERT INTO users (isactive) VALUES (0)";
        $query  = $this->db->prepare($sql);

        if (!$query->execute()) {

            $state['message'] = $this->translation("system_error") . " #03";
            return $state;
        }

        $user_id    = $this->db->lastInsertId("users_id_seq");
        $email      = htmlentities(strtolower($email));
        $token      = '';

        if ($use_email_activation) {

            $addRequest = $this->addRequest($user_id, $email, "activation", $use_email_activation);
            $token      = $addRequest['token'];

            if ($addRequest['success'] == false) {

                $sql = "DELETE FROM users WHERE id = :id";
                $query = $this->db->prepare($sql);

                $query->execute([
                    'id' => $user_id
                ]);

                $state['message'] = $this->translation("system_error") . " #06";
                return $state;
            }

            $isactive = 0;

        } else {

            $isactive = 1;
        }

        $password = $this->getHash($password);

        if (is_array($params) && count($params) > 0) {

            $customParamsQueryArray = [];

            foreach ($params as $paramKey => $paramValue) {

                $customParamsQueryArray[] = ['value' => $paramKey . ' = ?'];
            }

            $setParams = ', ' . implode(', ', array_map(function ($entry) { return $entry['value']; }, $customParamsQueryArray));
        
        } else {
            
            $setParams = '';
        }

        $sql = "UPDATE users SET email = ?, password = ?, isactive = ? {$setParams} WHERE id = ?";
        $query = $this->db->prepare($sql);

        $bindParams = array_values(array_merge([$email, $password, $isactive], $params, [$user_id]));

        if (!$query->execute($bindParams)) {

            $sql = "DELETE FROM users WHERE id = ?";
            $query = $this->db->prepare($sql);

            $query->execute([$user_id]);
            $state['message'] = $this->translation("system_error") . " #04";

            return $state;
        }

        $state['id']        = $user_id;
        $state['success']   = true;
        $state['token']     = $token;
        $state["message"]   = $this->translation("register_success_confirm");
        
        return $state;
    }

    public function getUID(string $email) : int {

        $sql = "SELECT id FROM users WHERE email = :email";

        $query = $this->db->prepare($sql);
        $query->execute(['email' => strtolower($email)]);

        return $query->fetchColumn();
    }

    protected function addSession(int $user_id) {

        $ip     = $this->getIp();
        $user   = $this->getBaseUser($user_id);

        if (!$user) {

            return false;
        }

        $data['hash']   = sha1($this->config->site_key . microtime());
        $data['expire'] = strtotime($this->config->cookie_remember);
        $agent          = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        

        $data['cookie_crc'] = sha1($data['hash'] . $this->config->site_key);

        $sql = "
            INSERT INTO sessions
            (uid, hash, expiredate, ip, agent, cookie_crc, agent_os_name, agent_os_type)
            VALUES (:uid, :hash, :expiredate, :ip, :agent, :cookie_crc, :agent_os_name, :agent_os_type)
            ";
            
        $query = $this->db->prepare($sql);
        $query_params = [
            ':uid'              => $user_id,
            ':hash'             => $data['hash'],
            ':expiredate'       => date("Y-m-d H:i:s", $data['expire']),
            ':ip'               => $ip,
            ':agent'            => $agent,
            ':cookie_crc'       => $data['cookie_crc'],
            ':agent_os_name'    => $this->getOS($agent),
            ':agent_os_type'    => $this->getBrowser($agent),
        ];

        if (!$query->execute($query_params)) {

            return false;
        }

        setcookie($this->config->cookie_name, $data['hash'], $data['expire'], "/");
        $_COOKIE[$this->config->cookie_name] = $data['hash'];

        return $data;
    }

    public function getUser(int $user_id, bool $withpassword = false) {

        $sql = "SELECT * FROM users WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(['id' => $user_id]);

        $data = $query->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {

            return NULL;
        }

        $data['uid'] = $user_id;

        if ($withpassword !== true) {

            unset($data['password']);
        }

        return $data;
    }

    public function logout(string $hash) {

        if (strlen($hash) != self::HASH_LENGTH) {

            return false;
        }

        $this->isAuthenticated  = false;
        $this->currentuser      = null;

        return $this->deleteSession($hash);
    }

    public function getCurrentSessionHash() {

        return $_COOKIE[$this->config->cookie_name] ?? "";
    }

    public function isLogged() {

        if ($this->isAuthenticated === false) {

            $this->isAuthenticated = $this->checkSession($this->getCurrentSessionHash());
        }

        return $this->isAuthenticated;
    }

    public function checkSession($hash) {

        $ip = $this->getIp();

        if (strlen($hash) != self::HASH_LENGTH) {

            return false;
        }

        $sql = "SELECT id, uid, expiredate, ip, agent, cookie_crc FROM sessions WHERE hash = :hash";

        $query = $this->db->prepare($sql);
        $query->execute(array('hash' => $hash));

        if ($query->rowCount() == 0) {

            return false;
        }

        $row = $query->fetch(\PDO::FETCH_ASSOC);

        $uid            = $row['uid'];
        $expiredate     = strtotime($row['expiredate']);
        $currentdate    = strtotime(date("Y-m-d H:i:s"));

        $db_ip          = $row['ip'];
        $db_cookie      = $row['cookie_crc'];

        if ($currentdate > $expiredate) {

            $this->deleteSession($hash);
            return false;
        }


        if ($db_cookie == sha1($hash . $this->config->site_key)) {

            return true;
        }

        return false;
    }

    protected function addRequest(int $uid, string $email, string $type) {

        $return = [];
        $return['success'] = false;

        if ($type == 'activation') {

            $dictionary_key__request_exists = 'activation_exists';

        } elseif ($type == 'reset') {

            $dictionary_key__request_exists = 'reset_exists';

        } else {

            $return['message'] = $this->translation("system_error") . " #08";

            return $return;
        }

        $send_email = true;


        $sql = "SELECT id, expire FROM requests WHERE uid = :uid AND type = :type";
        $query = $this->db->prepare($sql);
        $query->execute(['uid' => $uid, 'type' => $type]);

        $row_count = $query->rowCount();

        if ($row_count > 0) {

            $row = $query->fetch(PDO::FETCH_ASSOC);

            $expiredate     = strtotime($row['expire']);
            $currentdate    = strtotime(date("Y-m-d H:i:s"));

            if ($currentdate < $expiredate) {

                $return['message'] = $this->translation("request_expired");
                return $return;
            }

            $this->deleteRequest($row['id']);
        }

        $token = $this->getRandomKey(self::TOKEN_LENGTH); // use GUID for tokens?
        $expire = date("Y-m-d H:i:s", strtotime('+1 day'));

        $sql    = "INSERT INTO requests (uid, token, expire, type) VALUES (:uid, :token, :expire, :type)";
        $query  = $this->db->prepare($sql);

        $query_params = [
            'uid'       => $uid,
            'token'     => $token,
            'expire'    => $expire,
            'type'      => $type
        ];

        if (!$query->execute($query_params)) {

            $return['message'] = $this->translation("system_error") . " #09";

            return $return;
        }

        $request_id = $this->db->lastInsertId();

        $return['success']  = true;
        $return['token']    = $token;
        $return['expire']   = $expire;

        return $return;
    }

    public function changePassword($uid, $currpass, $newpass, $repeatnewpass) {
        
        $state             = [];
        $state['success']  = false;

        if (!$this->isBlocked()) {

            $state["message"] = $this->translation("blocked");
            return $state;
        }

        $validate_password = $this->validatePassword($currpass);

        if (!$validate_password["success"]) {

            // After $config->max_attemps limit, the ip gets banned
            $this->addAttempt();

            $state["message"] = $validate_password["message"];
            return $state;
        }

        $validate_password = $this->validatePassword($newpass);

        if (!$validate_password["success"]) {

            // After $config->max_attemps limit, the ip gets banned
            $this->addAttempt();

            $state["message"] = $validate_password["message"];
            return $state;
        }

        if ($newpass !== $repeatnewpass) {

            $state["message"] = $this->translation("password_nomatch");
        }

        $user = $this->getBaseUser($uid);

        if (!$user) {

            $this->addAttempt();
            $state['message'] = $this->translation("system_error") . " #13";

            return $state;
        }

        if (!password_verify($currpass, $user['password'])) {

            $this->addAttempt();
            $state['message'] = $this->translation("password_incorrect");

            return $state;
        }

        $newpass = $this->getHash($newpass);

        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$newpass, $uid]);

        $state['success']  = true;
        $state['message']  = $this->translation("password_changed");

        return $state;
    }

    function deleteRequest(int $id) {

        $sql    = "DELETE FROM requests WHERE id = :id";
        $query  = $this->db->prepare($sql);
        return $query->execute(['id' => $id]);
    }

    public function getRandomKey($length = self::TOKEN_LENGTH) {

        $dictionary = "A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6Q7R8S9T0U1V2W3X4Y5Z6a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z6";
        $dictionary_length = strlen($dictionary);
        $key = "";

        for ($i = 0; $i < $length; $i++) {
            $key .= $dictionary[mt_rand(0, $dictionary_length - 1)];
        }

        return $key;
    }

    public function resetPass(string $key, string $password) {
        
        $state['success']   = false;
        $block_status       = $this->isBlocked();

        if (!$this->isBlocked()) {

            $state["message"] = $this->translation("blocked");
            return $state;
        }

        $validate_password = $this->validatePassword($password);

        if (!$validate_password["success"]) {

            // After $config->max_attemps limit, the ip gets banned
            $this->addAttempt();

            $state["message"] = $validate_password["message"];
            return $state;
        }

        $data = $this->getRequest($key, "reset");

        if (!$data['success']) {

            $state['message'] = $data['message'];

            return $state;
        }

        $user = $this->getBaseUser($data['uid']);

        if (!$user) {
             
            $this->addAttempt();
            $this->deleteRequest($data['id']);

            $state['message'] = $this->translation("system_error") . " #11";

            return $state;
        }

        $password = $this->getHash($password);

        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query_params = [
            'password' => $password,
            'id' => $data['uid']
        ];

        $query->execute($query_params);

        if ($query->rowCount() == 0) {

            $state['message'] = $this->translation("system_error") . " #12";

            return $state;
        }

        $this->deleteRequest($data['id']);
        $state['success'] = true;
        $state['message'] = $this->translation("password_reset_success");

        return $state;
    }

    public function getRequest(string $key, string $type) {

        $state             = [];
        $state['success']  = false;

        $sql = "SELECT id, uid, expire FROM requests WHERE token = ? AND type = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$key, $type]);

        if ($query->rowCount() === 0) {

            $this->addAttempt();
            $state['message'] = $this->translation($type . "key_incorrect");

            return $state;
        }

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $expiredate = strtotime($row['expire']);
        $currentdate = strtotime(date("Y-m-d H:i:s"));

        if ($currentdate > $expiredate) {

            $this->addAttempt();
            $this->deleteRequest($row['id']);
            $return['message'] = $this->translation($type . "key_expired");

            return $state;
        }

        $state['success']  = true;
        $state['id']       = $row['id'];
        $state['uid']      = $row['uid'];

        return $state;
    }

    public function requestReset($email) {

        $state              = array();
        $state['success']   = false;
        
        $block_status = $this->isBlocked();

        if (!$this->isBlocked()) {

            $state["message"] = $this->translation("blocked");
            return $state;
        }

        $validate_email = $this->validateEmail($email);

        if (!$validate_email["success"]) {
            
            // After $config->max_attemps limit, the ip gets banned
            $this->addAttempt();

            $state["message"] = $validate_email["message"];
            return $state;
        }

        $sql    = "SELECT id, email FROM users WHERE email = :email";
        $query  = $this->db->prepare($sql);
        $query->execute(['email' => $email]);

        $row = $query->fetch(PDO::FETCH_ASSOC);

        if (!$row) {

            $this->addAttempt();

            $state['message'] = $this->translation("email_incorrect");

            return $state;
        }

        $addRequest = $this->addRequest($row['id'], $email, "reset");

        if ($addRequest['success'] == false) {

            $this->addAttempt();
            $state['message'] = $addRequest['message'];

            return $state;
        }

        $state['id']        = $row['id'];
        $state['success']   = true;
        $state['message']   = $this->translation("reset_requested");
        $state['token']     = $addRequest['token'];
        $state['expire']    = $addRequest["expire"];

        return $state;
    }

    public function activate(string $activate_token) {

        $state              = array();
        $state['success']   = false;

        $block_status = $this->isBlocked();

        if (!$this->isBlocked()) {

            $state["message"] = $this->translation("blocked");
            return $state;
        }

        if (strlen($activate_token) !== self::TOKEN_LENGTH) {

            $this->addAttempt();
            $state['message'] = $this->translation('activationkey_invalid');

            return $state;
        }

        $activationRequest = $this->getRequest($activate_token, 'activation');

        if (!$activationRequest['success']) {

            $state['message'] = $activationRequest['message'];

            return $state;
        }

        $sql = "UPDATE users SET isactive = 1 WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array('id' => $activationRequest['uid']));

        $this->deleteRequest($activationRequest['id']);

        $state['success'] = true;
        $state['message'] = $this->translation('account_activated');

        return $state;
    }

    protected function deleteSession(string $hash) {

        $sql = "DELETE FROM sessions WHERE hash = :hash";

        $query = $this->db->prepare($sql);
        $query->execute(['hash' => $hash]);

        return $query->rowCount() == 1;
    }

    public function getSessionUID(string $hash) {

        $sql = "SELECT uid FROM sessions WHERE hash = :hash";
        $query = $this->db->prepare($sql);

        $query->execute(array('hash' => $hash));

        if ($query->rowCount() == 0) {

            return 0;
        }

        return (int) $query->fetch(PDO::FETCH_ASSOC)["uid"];
    }

    function getOS($user_agent) {

        $os_platform  = "Unknown OS Platform";
    
        $os_array     = array(
                              '/windows nt 10/i'      =>  'Windows 10',
                              '/windows nt 6.3/i'     =>  'Windows 8.1',
                              '/windows nt 6.2/i'     =>  'Windows 8',
                              '/windows nt 6.1/i'     =>  'Windows 7',
                              '/windows nt 6.0/i'     =>  'Windows Vista',
                              '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                              '/windows nt 5.1/i'     =>  'Windows XP',
                              '/windows xp/i'         =>  'Windows XP',
                              '/windows nt 5.0/i'     =>  'Windows 2000',
                              '/windows me/i'         =>  'Windows ME',
                              '/win98/i'              =>  'Windows 98',
                              '/win95/i'              =>  'Windows 95',
                              '/win16/i'              =>  'Windows 3.11',
                              '/macintosh|mac os x/i' =>  'Mac OS X',
                              '/mac_powerpc/i'        =>  'Mac OS 9',
                              '/linux/i'              =>  'Linux',
                              '/ubuntu/i'             =>  'Ubuntu',
                              '/iphone/i'             =>  'iPhone',
                              '/ipod/i'               =>  'iPod',
                              '/ipad/i'               =>  'iPad',
                              '/android/i'            =>  'Android',
                              '/blackberry/i'         =>  'BlackBerry',
                              '/webos/i'              =>  'Mobile'
                        );
    
        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;
    
        return $os_platform;
    }
    
    function getBrowser($user_agent) {
    
        $browser        = "Unknown Browser";
    
        $browser_array = array(
                                '/msie/i'      => 'Internet Explorer',
                                '/firefox/i'   => 'Firefox',
                                '/safari/i'    => 'Safari',
                                '/chrome/i'    => 'Chrome',
                                '/edge/i'      => 'Edge',
                                '/opera/i'     => 'Opera',
                                '/netscape/i'  => 'Netscape',
                                '/maxthon/i'   => 'Maxthon',
                                '/konqueror/i' => 'Konqueror',
                                '/mobile/i'    => 'Handheld Browser'
                         );
    
        foreach ($browser_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $browser = $value;
    
        return $browser;
    }

    public function password_verify_with_rehash(string $password, string $hash, int $user_id) {

        if (password_verify($password, $hash) !== true) {

            return false;
        }

        if (password_needs_rehash($hash, PASSWORD_DEFAULT, ['cost' => 10])) {

            $hash   = $this->getHash($password);
            $sql    = "UPDATE users SET password = ? WHERE id = ?";

            $query = $this->db->prepare($sql);
            $query->execute([$hash, $user_id]);
        }

        return true;
    }

    protected function deleteAttempts(string $ip, bool $all = false) {

        $sql = ($all)
            ? "DELETE FROM attempts WHERE ip = :ip"
            : "DELETE FROM attempts WHERE ip = :ip AND NOW() > expiredate ";

        $query = $this->db->prepare($sql);
        return $query->execute([
            'ip' => $ip
        ]);
    }

    public function getHash(string $password) {

        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
    }

    protected function getIp() : string {

        if (getenv('HTTP_CLIENT_IP')) {

            $ipAddress = getenv('HTTP_CLIENT_IP');

        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {

            $ipAddress = getenv('HTTP_X_FORWARDED_FOR');

        } elseif (getenv('HTTP_X_FORWARDED')) {

            $ipAddress = getenv('HTTP_X_FORWARDED');

        } elseif (getenv('HTTP_FORWARDED_FOR')) {

            $ipAddress = getenv('HTTP_FORWARDED_FOR');

        } elseif (getenv('HTTP_FORWARDED')) {

            $ipAddress = getenv('HTTP_FORWARDED');

        } elseif (getenv('REMOTE_ADDR')) {

            $ipAddress = getenv('REMOTE_ADDR');
        } else {

            $ipAddress = '127.0.0.1';
        }

        return $ipAddress;
    }

    protected function validateEmail(string $email) : array {

        $state              = array();
        $state['success']   = false;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $state['message'] = $this->translation("email_invalid");
            return $state;
        }

        $state['success'] = true;
        return $state;
    }

    protected function validatePassword(string $password) : array {

        $state              = array();
        $state['success']   = false;

        if (strlen($password) < 3) {

            $state['message'] = $this->translation("password_too_small");
            return $state;
        }

        if (strlen($password) > 64) {

            $state['message'] = $this->translation("password_too_big");
            return $state;
        }

        $state['success'] = true;
        return $state;
    }
}