<?php

namespace Fyre\Library;

use Jenssegers\Blade\Blade;
use PHPMailer\PHPMailer\PHPMailer;

class email {
    
    private $config;
    private $db;
    
    function __construct() {
        
        global $app;
        $this->app = $app;
        
        // Store database connection
        $this->db       = $app->databaseConnection();
        
        // Load config
        $this->config   = $this->app->config;
    }
    
    public function send($email, $subject, $type, $variables = "", $debug = 0, $files = null) {

        global $app;
        
        $mail = new PHPMailer();
        
        if (!isset($GLOBALS['debug'])) {
            
            $GLOBALS['debug'] = "";
        }

        // Check configuration for custom SMTP parameters
        try {
            // Server settings
            if ($this->config->smtp) {

                $mail->SMTPDebug = $debug;

                $mail->isSMTP();

                $mail->Host     = $this->config->smtp_host;
                $mail->SMTPAuth = $this->config->smtp_auth;

                // set SMTP auth username/password
                if (!is_null($this->config->smtp_auth)) {
                    
                    $mail->Username = $this->config->smtp_username;
                    $mail->Password = $this->config->smtp_password;
                }

                // set SMTPSecure (tls|ssl)
                if (!is_null($this->config->smtp_security)) {
                    
                    $mail->SMTPSecure = $this->config->smtp_security;
                }

                if ($files !== null) {
                    foreach ($files as $file) {
                        $mail->addAttachment($file["path"], $file["name"]);
                    }
                }

                $mail->Port = $this->config->smtp_port;
                
            } else {
                
                return false;
            }
            
            $GLOBALS['debug'] .= "SMTP HOST: " . $this->config->smtp_host . "<br>";
            $GLOBALS['debug'] .= "SMTP AUTH: " . $this->config->smtp_auth . "<br>";
            $GLOBALS['debug'] .= "SMTP PORT: " . $this->config->smtp_port . "<br>";
            $GLOBALS['debug'] .= "SMTP USERNAME: " . $this->config->smtp_username . "<br>";
            $GLOBALS['debug'] .= "SMTP PASSWORD: " . $this->config->smtp_password . "<br>";
            $GLOBALS['debug'] .= "SMTP SECURITY: " . $this->config->smtp_security . "<br>";
            
            // DEBUG
            $mail->Debugoutput = function($str, $level) {
                
                $GLOBALS['debug'] .= "$level: $str<br>";
            };

            //Recipients
            $mail->setFrom($this->config->smtp_username, json_decode($this->config->title, true)[$app->selected_language->code]);
            
            if (is_array($email)) {
                
                foreach ($email as $recipient) {
                    
                    $mail->addAddress($recipient);
                }
                
            } else {
                
                $mail->addAddress($email);
            }

            $mail->CharSet = $this->config->mail_charset;

            //Content
            $mail->isHTML(true);
            $template = $this->template($type, $variables);
            $mail->Subject  = json_decode($app->config->title, true)[$app->selected_language->code] . " - " . $subject;
            $mail->Body     = $template;
            $mail->AltBody  = $template;
        
            if (!$mail->send()) {
                
                throw new \Exception($mail->ErrorInfo);
            }

            return true;

        } catch (\Exception $e) {
            file_put_contents("error", $e->getMessage() . PHP_EOL);
            return false;
        }

        return false;
    }
    
    private function template($type, $variables) {

        global $app;

        $variables["config"]        = $app->config;
        $variables["translations"]  = $app->translations;
        $variables["logoImage"]     = $app->config->mail_logo;
        $variables["url"]           = URL;
        $variables["store_name"]    = json_decode($app->config->title, true)[$app->selected_language->code];
        $variables["linkContact"]   =  URL . "/pt/contact";

        $blade = new Blade(APP . "templates/email", APP . "templates/cache/");
        return $blade->render($type, $variables);
        

    }
}

?>