<?php

namespace Fyre\Core;
use Jenssegers\Blade\Blade;

class Controller {
    
    public $template_engine;
    public $dependencies = NULL;
    public $app;
    public $user = null;
    

    function __construct() {

        global $app;

        if ($app->auth->isLogged()) {

            $this->user = $app->auth->getUser($app->auth->getSessionUID($app->auth->getCurrentSessionHash()));
        }
    }
    
    function template($page, $variables = array()) {
        
        global $app, $langg;

        // Dependencies
        $this->dependencies(array("news", "views", "categories", "menus"), array());

        $is_logged = $app->auth->isLogged();

        // Vereficar se a loja esta em manutenção
        if ($app->config->is_maintain == "true") {
            
            if ($this->user !== null && $this->user["type"] == 2) {

                // O website esta em modo de manutenção, só visivel para administradores

            } else {

                $blade = new Blade(APP . "templates/frontoffice", APP . "templates/cache/");
                echo $blade->render("pages.maintenance", array("message" => json_decode($app->config->maintain_text, true)[$app->selected_language->code]));
                exit();
            }
        }

        // Obter as categorias
        $categories = $this->dependencies->categories->listing(null, $app->select_language);

        // Obter os menus
        $menus = $this->dependencies->menus->listing(null, $app->select_language);        
      
        // Adicionar a view
        $this->dependencies->views->insert(array("date_visited" => date("Y-m-d"), "hashed_ip" => md5($this->get_client_ip() . "SUPER_SECRET_KEY")), "IGNORE");

        $variables["latest_news"]           = $this->dependencies->news->listing($app->selected_language->code, 0, 2);
        $variables["settings"]              = $app->config;
        $variables["languages"]             = $app->languages;
        $variables["is_loggged"]            = $is_logged;
        $variables["langg"]                 = $langg;
        $variables['categories']            = $categories;
        $variables['menus']                 = $menus;
        $variables["query"]                 = http_build_query($_GET);
        $variables["user"]                  = $this->user;
        $variables["selected_language"]     = $app->selected_language;

        $variables["translations"]          = $app->translations;
        
        $blade                              = new Blade(APP . "templates/frontoffice", APP . "templates/cache/");
        
        echo $blade->render($page, $variables);
    }
    
    function middleware($type) {

        global $app;

        if (1 == $type && !$app->auth->isLogged()) {
            header("Location: /adm/login");
            return true;
        }
        
        if (!$app->auth->isLogged()) {
            
            if ($type == 1) {
                
                $app->fire('404');
            }
            
            $app->fire('404');
        }

        if ($type == 1) {

            if (!($this->user["type"] == 2)) {
                
                header('Location: /adm/login');
            }
        }
    }
    
    function backoffice($page, $variables = array(), $block_login_redirect = false) {
        
        global $app;
        
        $user_data = $this->user;

        // Desativar o middleware na pagina de login
        
        if (!$block_login_redirect) {

            // Middleware
            $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        }
        
        $variables["user"]              = $user_data;
        $variables["translations"]      = $app->translations;
        $variables["languages"]         = $app->languages;
        $variables["url"]               = URL;
        $variables["selected_language"] = $app->selected_language;
        $variables["website_config"]    = $app->config;
        $blade                          = new Blade(APP . "templates/backoffice", APP . "templates/cache/");
        
        
        echo $blade->render($page, $variables);
    }
    
    function denyRequest($message) {
        
        header('HTTP/1.0 403 Forbidden');
        header("Refresh:2; url=/");

        exit($message);
    }
    
    function dependencies($models, $libs = array()) {
        
        $this->dependencies             = new \stdClass();
        $this->dependencies->library    = new \stdClass();
        
        // Models
        if (!empty($models)) {
            
            foreach ($models as $model) {
                
                require_once(APP . 'models/' . $model . ".php");
                
                $model_name = "\\Fyre\\Model\\" . $model;
                $this->dependencies->$model = new $model_name(); 
            }
        }
        
        // Libraries
        if (!empty($libs)) {
            
            foreach ($libs as $library) {
                
                require_once(APP . 'library/' . $library . ".php");
                
                $lib_name = "\\Fyre\\Library\\" . $library;
                $this->dependencies->library->$library = new $lib_name(); 
            }
        }
    }
    
    function get_client_ip() {
        
        foreach (array(
                'HTTP_CLIENT_IP',
                'HTTP_X_FORWARDED_FOR',
                'HTTP_X_FORWARDED',
                'HTTP_X_CLUSTER_CLIENT_IP',
                'HTTP_FORWARDED_FOR',
                'HTTP_FORWARDED',
                'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER)) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if ((bool) filter_var($ip, FILTER_VALIDATE_IP,
                                    FILTER_FLAG_IPV4 |
                                    FILTER_FLAG_NO_PRIV_RANGE |
                                    FILTER_FLAG_NO_RES_RANGE)) {
                        return $ip;
                    }
                }
            }
        }
        
        return null;
    }
    
    function raw_response($json) {
        
        echo json_encode($json);
        exit();
    }

    function response($success, $message , $data = array(), $pagination = array()) {
        
        header('Content-Type: application/json');
        
        // Output json with data key
        if (!empty($data)) {
            
            if ($pagination != null) {
                
                echo json_encode(array(
                    
                    "success" => $success, "message" => $message, "data" => $data, "pagination" => $pagination, 
                ));
                
            } else {
                
                echo json_encode(array("success" => $success, "message" => $message, "data" => $data)); 
            }
            
            exit();
        }
        
        // Output json message
        echo json_encode(array("success" => $success, "message" => $message));
        exit();
    }
}
