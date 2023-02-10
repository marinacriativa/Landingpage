<?php 

/** 
* Controller main ( Backoffice ) 
*
*   Extends: core/Controller.php
*   Author: Vlad

**/

namespace Fyre\Controller;

class auth extends \Fyre\Core\Controller {

    function login() {

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
        
        if (!isset($_POST["email"]) || !isset($_POST["password"])) {

            $app->redirect("/auth");
        }

        $status = $app->auth->login($_POST["email"], $_POST["password"]);

        if ($status["success"]) {

            $this->user = $app->auth->getUser($app->auth->getSessionUID($app->auth->getCurrentSessionHash()));

            if ($this->user["type"] == 2) {

                $app->redirect("/adm");

            } else {

                $app->redirect("/");
            }

        } else {

            $app->redirect($_SERVER['HTTP_REFERER'] . "&loginMessage=" . $status["message"]);
        }
        
        $this->raw_response($status);
    }

    function register() {

        global $app;

        // Dependencies
        $this->dependencies(array("users", "notifications"), array("email"));

        $use_email_activation = true;

        if ($app->auth->isLogged()) {
            
            if ($this->user["type"] == 2) {

                $app->redirect("/adm");

            } else {

                $app->redirect("/");
            }

            $this->raw_response(array("error" => true, "message" => "Já tens sessão iniciada"));
            exit();
        }

        if (!isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["repeat-password"])) {

            $app->redirect("/auth");
        }

        $status = $app->auth->register($_POST["email"], $_POST["password"], $_POST["repeat-password"], array(), null, $use_email_activation);
        
        if ($status["success"]) {

            // Dados extra
            $extra = array("id" => $status["id"]);

            if (isset($_POST["address"])) {

                $extra["address"] = strip_tags($_POST["address"]);
            }

            if (isset($_POST["nif"])) {

                $extra["nif"] = strip_tags($_POST["nif"]);
            }

            if (isset($_POST["phone"])) {

                $extra["phone"] = strip_tags($_POST["phone"]);
            }

            if (isset($_POST["name"])) {

                $extra["name"] = strip_tags($_POST["name"]);
            }

            if (isset($_POST["zipCode"])) {

                $extra["zipCode"] = strip_tags($_POST["zipCode"]);
            }

            if (isset($_POST["city"])) {

                $extra["city"] = strip_tags($_POST["city"]);
            }

            if (isset($_POST["country"])) {

                $extra["country"] = strip_tags($_POST["country"]);
            }

            if (count($extra) > 1) {

                $this->dependencies->users->edit($extra);
            }

            //Criar notificação de nova Mensagen
            $admins = $this->dependencies->users->getAdmins();

            foreach ($admins as $idAdmin) {

                $data_notification = array(
                    "id_user" => $idAdmin,
                    "type" => "client",
                    "identifier" => $_POST["email"],
                    "link" => URL ."adm/clients/" . $extra["id"],
                );

                $this->dependencies->notifications->insert($data_notification);
            }

            if ($use_email_activation) {

                //EMAIL
                $email = $_POST["email"];

                $data_email = array(
                    "store_name" => json_decode($app->config->title, true)[$app->selected_language->code],
                    "name" => $extra["name"],
                    "link" => URL . "/confirm/" . $status["token"],
                    "linkContact" => URL . $app->selected_language->code . "/contact",
                    "other" => $app->config,
                );

                // Enviar os email
                $this->dependencies->library->email->send($email, "Confirmação de Registo", "emailAccount", $data_email);

                $app->redirect($_SERVER['HTTP_REFERER'] . "&success&message=" . $status["message"]);

            } else {

                $status = $app->auth->login($_POST["email"], $_POST["password"]);

                // Login automatico
                if ($status["success"]) {
    
                    $this->user = $app->auth->getUser($app->auth->getSessionUID($app->auth->getCurrentSessionHash()));
    
                    if ($this->user["type"] == 2) {
    
                        $app->redirect("/adm");
    
                    } else {
    
                        $app->redirect("/");
                    }
    
                } else {
    
                    $app->redirect($_SERVER['HTTP_REFERER'] . "&message=" . $status["message"]);
                }
            }

        } else {

            $app->redirect($_SERVER['HTTP_REFERER'] . "&message=" . $status["message"]);
        }
    }

    function confirm($token) {

        global $app;

        // Ativar a conta com o id do url
        $status = $app->auth->activate($token);

        $app->redirect("/" . $app->selected_language->code . "/&loginMessage=" . $status["message"]);
    }

    function login_page() {

        global $app;

        $this->dependencies(array("countries"), array());
        
        if ($app->auth->isLogged()) {
            
            if ($this->user["type"] == 2) {

                $app->redirect("/adm");

            } else {
                $app->redirect("/" . $app->selected_language->code . "/&loginMessage=" . "Você deve estar logado para prosseguir.");                
            }

            $this->raw_response(array("error" => true, "message" => "Já tens sessão iniciada"));
            exit();
        }

        $countries = $this->dependencies->countries->multiple();

        echo $this->template("pages/auth/forms", compact("countries"));
    }

    function register_page() {

        global $app;

        $this->dependencies(array("countries"), array());
        
        if ($app->auth->isLogged()) {
            
            if ($this->user["type"] == 2) {

                $app->redirect("/adm");

            } else {

                $app->redirect("/");
            }

            $this->raw_response(array("error" => true, "message" => "Já tens sessão iniciada"));
            exit();
        }

        $countries = $this->dependencies->countries->multiple();

        echo $this->template("pages/auth/forms", compact("countries"));
    }

    function reset() {

        global $app;

        if (!isset($_POST["password"])) {

            $app->redirect("/auth");
        }

        if (!isset($_POST["password-repeat"])) {

            $app->redirect("/auth");
        }

        if (!isset($_POST["key"])) {

            $app->redirect("/auth");
        }

        if ($app->auth->isLogged()) {
            
            if ($this->user["type"] == 2) {

                $app->redirect("/adm");

            } else {

                $app->redirect("/");
            }

            $this->raw_response(array("error" => true, "message" => "Já tens sessão iniciada"));
            exit();
        }

        if ($_POST["password"] !== $_POST["password-repeat"]) {

            $app->redirect($_SERVER['HTTP_REFERER'] . "&message=" . "Palavras-passes não coincidem");
        }

        $status = $app->auth->resetPass($_POST["key"], $_POST["password"]);

        if ($status["success"]) {

            $app->redirect("/auth" . "?success=true&message=" . $status["message"]);

        } else {

            // Deu erro
            $app->redirect($_SERVER['HTTP_REFERER'] ."&message=" . $status["message"]);
        }
    }

    function forgot() {

        global $app;

        // Dependencies
        $this->dependencies(array(), array("email"));

        if (!isset($_POST["email"])) {

            $app->redirect("/auth");
        }
        
        if ($app->auth->isLogged()) {
            
            if ($this->user["type"] == 2) {

                $app->redirect("/adm");

            } else {

                $app->redirect("/");
            }

            $this->raw_response(array("error" => true, "message" => "Já tens sessão iniciada"));
            exit();
        }

        $email  = $_POST["email"];
        $status = $app->auth->requestReset($email);

        if ($status["success"]) {

            $this->dependencies->library->email->send($email, "Pedido de recuperação da conta", "emailNewPassword", $status);

            $app->redirect("adm/reset?success=true&message=" . $status["message"]);

        } else {

            // Deu erro
            $app->redirect("adm/reset?message=" . $status["message"]);
        }

    }

    function reset_page($token) {

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

        echo $this->template("pages/auth/reset", array("token" => $token));
    }
}