<?php

namespace Fyre\Core;

class Application {
    
    private $tokens;
    private $parameters;
    private $handler_instance;
    private $request_method;
    private $hooks;
    private $db;
    public  $curent_url;
    public  $curent_route;
    public  $auth;
    public  $translations;
    public  $select_language;
    
    public function __construct() {
        
        // Require do model com funções para o sistema de traduções e linguas
        require_once APP . 'models/translation.php';

        // Require do model com funções para o sistema de traduções e linguas
        require_once APP . 'models/config.php';
        
        // Require do model com funções para o sistema de traduções e linguas
        require_once APP . 'models/translation_words.php';

        $this->tokens = array(
            ':string'   => '([a-zA-Z]+)',
            ':language' => '([a-zA-Z]+)',
            ':number'   => '([0-9]+)',
            ':alpha'    => '([^\/]+)',
        );
        
        $this->handler_instance     = null;
        $this->request_method       = strtolower($_SERVER['REQUEST_METHOD']); 
        
        // Handle curent URL
        $this->HandleURL();
        
        // Init database connection
        $this->initDatabaseConnection();
        
        // Languages
        $translations           = new \Fyre\Model\translation($this->db);
        $translations_words     = new \Fyre\Model\translation_words($this->db);
        
        $this->languages        = $translations->multiple();
        $this->translations     = array();
        
        $this->selected_language      = 1;

        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $_SERVER['HTTP_ACCEPT_LANGUAGE']  = "PT";
          }

        // Get language from session or browser
        $this->select_language  = (isset($_COOKIE["lang"])) ? $_COOKIE["lang"] : substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        $translations_pt        = $translations_words->multiple(1);
        
        foreach ($this->languages as $language) {

            if ($language->default) {

                $this->default_language = $language;
            }
            
            if ($language->code == $this->select_language && ($language->active == 1)) {
                
                $this->selected_language        = $language;
                $translations                   = $translations_words->multiple($this->selected_language->id);
                
                foreach ($translations as $word) {
            
                    $this->translations[$word->category][$word->word_key] = $word->word;
                }
            }
        }
        
        if (empty($this->translations)) {
            
            // Nenhuma lingua foi selecionada, vamos meter a primeira que encontramos

            foreach ($this->languages as $language) {
                
                if ($language->active == 1)  {
                    
                    $this->selected_language = $language;
                    
                    $translations           = $translations_words->multiple($this->selected_language->id);
                    
                    foreach ($translations as $word) {
                
                        $this->translations[$word->category][$word->word_key] = $word->word;
                    }
                    
                    continue;
                }
            }
        }

        if (empty($this->translations)) {
        
            exit("ERROR 500, Language not available");
        }
        foreach ($translations_pt as $lang_pt) {
            $this->translations['backoffice'][$lang_pt->word_key] = $lang_pt->word;
        }
        
        // Auth
        $config             = new \Fyre\Model\config($this->db);
        $this->config       = $config->multiple();
        $this->auth         = new \Fyre\Library\Authentication($this->db, $this->config);
        
        // GOOGLE ANALYTICS
        //define("GOOGLE_ANALYTICS_VIEW_ID", $this->config->google_analytics_view_id);
        //define("GOOGLE_ANALYTICS_CREDENTIALS", $this->config->google_analytics_service_account);
    }
    
    public function serve($routes) {

        $discovered_route_controller = null;
        
        if ($this->curent_url === NULL) {
            
            $this->curent_url = "/";
        }
        
        if (isset($routes[$this->curent_url])) {

                $discovered_route_controller = $routes[$this->curent_url][0];
                $this->curent_route = $routes[$this->curent_url];

        } elseif ($routes) {

            foreach ($routes as $pattern => $route_info) {

                $pattern =  strtr($pattern, $this->tokens);

                if (preg_match('#^/?' . $pattern . '/?$#', $this->request_method  . $this->curent_url, $matches)) {

                    $discovered_route_controller = $route_info[0];

                    if (!isset($matches[1])) {

                        $matches[1] = null;
                    }

                    $this->parameters = $matches[1];
                    $this->curent_route = $route_info;
                }
            }
        }

        if ($discovered_route_controller) {

            if (is_string($discovered_route_controller)) {

                $discovered_route_controller = strtolower($discovered_route_controller);

                if (strpos($discovered_route_controller, ".") !== false) {

                    $discovered_route_controller = explode(".", $discovered_route_controller);
                    $discovered_route_controller = implode("/", $discovered_route_controller);
                }

                $file = APP . "/controllers/" . $discovered_route_controller . ".controller.php";



                if (file_exists($file)) {
                    require_once($file);

                    if (strpos($discovered_route_controller, "/") !== false) {

                        $discovered_route_controller = explode("/", $discovered_route_controller);
                        $discovered_route_controller =  $discovered_route_controller[1];
                    }

                    $c = "\\Fyre\\Controller\\" . $discovered_route_controller;
                    $this->handler_instance = new $c();
                }

            } elseif (is_callable($discovered_route_controller)) {

                $c = "\\Fyre\\Controller\\" . $discovered_route_controller;
                $this->handler_instance = $c();
            }
        }

        $this->handle();
    }

    public function handle() {

        if ($this->handler_instance) {

            if (method_exists($this->handler_instance, $this->curent_route[1])) {

                if ($this->request_method == strtolower($this->curent_route[2])) {

                    call_user_func_array(array($this->handler_instance, $this->curent_route[1]), array($this->parameters));
                } else {

                    $this->fire('404');
                }

            } else {

                $this->fire('404');
            }
        } else {

            $this->fire('404');
        }
    }

    private function HandleURL() {

        if (isset($_GET['url'])) {

            $url = trim($_GET['url'], '/');
            unset($_GET['url']);
            $url = "/" . filter_var($url, FILTER_SANITIZE_URL);
            $this->curent_url = $url;
        }
    }

    public function addHook($hook_name, $fn) {

        $this->hooks[$hook_name][] = $fn;
    }

    public function fire($hook_name, $params = null) {

        if (isset($this->hooks[$hook_name])) {

            foreach ($this->hooks[$hook_name] as $fn) {

                call_user_func_array($fn, array($params));
            }
        }
    }

    private function initDatabaseConnection() {
        
        $options = array(\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        
        $this->db = new \PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);
    }
    
    public function redirect($location) {
        
        header("Location: " . $location);
        echo $this->translations["common"]["redirected"] . $location;
        exit();
    }
    
    public function getSqlCredentials() {
        
        return array(
        	'user' => DB_USER,
        	'pass' => DB_PASS,
        	'db'   => DB_NAME,
        	'host' => DB_HOST
        );
    }
    
    public function databaseConnection() {
        
        return $this->db;
    }
}
