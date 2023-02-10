<?php 

/** 
* Controller cheque 
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class login extends \Fyre\Core\Controller {
    
    function authenticate() {
        
        global $app;
        
        if ($app->auth->isLogged()) {
            
            if ($this->user["type"] == 2) {

                $app->redirect("/adm");

            } else {

                $app->redirect("/");
            }

            $this->raw_response(array("error" => true, "message" => "Já tens sessão iniciada"));
            exit();
        }
        
        $status = $app->auth->login($_POST["email"], $_POST["password"], true);

        if ($status["success"]) {

            $this->user = $app->auth->getUser($app->auth->getSessionUID($app->auth->getCurrentSessionHash()));

            if ($this->user["type"] == 2) {

                $app->redirect("/adm");

            } else {

                $app->redirect("/");
            }

        } else {

            $app->redirect($_SERVER['HTTP_REFERER']);
        }
        
        $this->raw_response($status);
    }
    
    function logout() {
        
        global $app;

        // Limpar carrinho
        setcookie("cart", json_encode(array()), time() + 1, "/"); // 1 segundo
        
        $auth   = $app->auth; 
        $logout = $auth->logOut($auth->getCurrentSessionHash());
        $app->redirect("/");
    }
}