<?php 

/** 
* Controller cheque 
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class auth extends \Fyre\Core\Controller {
 
    function login() {
        
        global $app;
        
        if ($app->auth->isLogged()) {
            
            $app->redirect("/");
        }
        
        echo $this->template("login");
    } 
    
    function register() {
        
        global $app;
        
        if ($app->auth->isLogged()) {
            
            $app->redirect("/");
        }
        
        echo $this->template("register");   
    } 
    
    function register_student() {
        
        global $app;
        
        if ($app->auth->isLogged()) {
            
            $app->redirect("/");
        }
        
        echo $this->template("register-client");   
    } 
    
    function register_client() {
        
        global $app;
        
        if ($app->auth->isLogged()) {
            
            $app->redirect("/");
        }
        
        echo $this->template("register-student");   
    } 
    
    function authenticate() {
        
        global $app;
        
        if ($app->auth->isLogged()) {
            
            $this->response(array("error" => true, "message" => "Vous êtes déjà connecté, rechargez la page"));
            exit();
        }
        
        setcookie("cart", json_encode(array()), time() + (86400 * 30 * 7), "/"); // 7 dias
        $status = $app->auth->login($_POST["email"], $_POST["password"], true);
        
        $this->response($status);
    }
    
    function create_account() {
        
        global $app;
        
        if ($app->auth->isLogged()) {
            
            $this->response(array("error" => true, "message" => "Vous êtes déjà connecté, rechargez la page"));
            exit();
        }
        
        $email              = $_POST["email"];
        $password           = $_POST["password"];
        $repeat_password    = $_POST["password_repeat"];
        
        // Prevenir que alguem seja admin
        if (isset($_POST["type"])) {
            
            if ($_POST["type"] == 0) {
                
                $_POST["type"] = 0;
            } else {
                
                $_POST["type"] = 1;
            }
        } else {
            
            $_POST["type"] == 1;
        }
        
        unset($_POST["email"]);
        unset($_POST["password"]);
        unset($_POST["password_repeat"]);
        unset($_POST["slim"]);
        
        foreach ($_POST as $key => $value) {
            
            $_POST[$key] = strip_tags($value);
        }
        
        $status = $app->auth->register($email, $password, $repeat_password, $_POST, null, false);
        
        
        if (!$status["error"]) {
            
            // Require email engine
            require_once( APP . "libs/email.php");
            
            $email_sender   = new \Fyre\Library\email();
            $_POST["email"] = $email;
            
            $email_sender->send($email, "Votre compte a été créé, mais doit être vérifié", "user/new_account_need_verefication", $_POST);
            
            if ($_POST["type"] == 0) {
                
                $email_sender->send(ADMIN_EMAIL, "Un compte a été créé et reste à activer!", "admin/new_student", $_POST);
                
            } else {
                
                $email_sender->send(ADMIN_EMAIL, "Un compte a été créé et reste à activer!", "admin/new_client", $_POST);
            }
        }
        
        $this->response($status);
    }
    
    function logout() {
        
        global $app;
        
        $auth   = $app->auth; 
        $logout = $auth->logOut($auth->getCurrentSessionHash());
        $app->redirect("/");
    }
}