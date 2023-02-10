<?php 

/** 
*   Controller services ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class users extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("users"), array());

        $page   = (isset($_GET["page"]))    ? intval($_GET["page"]) : 1;
        $limit  = (isset($_GET["length"]))  ? intval($_GET["length"]) : 5;
        $search = (isset($_GET["search"]))  ? $_GET["search"] : null;
        $order  = (isset($_GET["order"]))   ? $_GET["order"] : "id";
        $type   = (isset($_GET["type"]))    ? $_GET["type"] : null;

        $start  = ($page - 1) * $limit;

        $users  = $this->dependencies->users->multiple(null, $start, $limit, $search, $order, $type);
        $total  = $this->dependencies->users->total(null, $search);

        $pagination = array (
            "page"      => (int) $page, 
            "limit"     => (int) $limit, 
            "total"     => (int) $total, 
            "start"     => (int) $start, 
        );

        if (empty($users)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $users, $pagination);
    }
    
    function single($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("users"), array());

        // User array
        $user = $this->dependencies->users->single($id);

        if (empty($user)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        unset($user->password);

        $this->response(true, "API REQUEST SUCCESS", $user);
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("users"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            // Encriptar a palavra-passe
            if (isset($data["password"]) && !empty($data["password"])) {

                $data["password"] = $app->auth->getHash($data["password"]);
            } else {

                unset($data["password"]);
            }

            // Edit the data
            $status = $this->dependencies->users->edit($data);

            // Send json response
            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->users->single($id));
        }else{
            $this->response(false, "Email invalido");
        }

    }

    function insert() {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("users"));

        // Vereficar se temos password e email
        if (!isset($_POST["email"]) || !isset($_POST["password"])) {

            $this->response(false, "API REQUEST ERROR");
        }

        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

            // Register o utilizador
            $status = $app->auth->register($_POST["email"], $_POST["password"], $_POST["password"]);

            if ($status["success"]) {

                // Introduzir o id do utilizador
                $data = $_POST;
                $data["type"] = 2;
                $data["id"] = $status["id"];

                // Remover o email e password
                unset($data["email"]);
                unset($data["password"]);

                // Inserir o resto das informações do utilizador
                $this->dependencies->users->edit($data);

                $this->response(true, "API REQUEST SUCCESS", $this->dependencies->users->single($status["id"]));

            } else {

                // Mandar mensagem de erro do registro do utilizador
                $this->response(false, "API REQUEST ERROR", $status["message"]);
            }
        }else{
            $this->response(false, "Email invalido (abc@email.com)");

        }
        
        // Send json response 
        $this->response(false, "API REQUEST ERROR");
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("users"));

        // Delete the data
        $status = $this->dependencies->users->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->users->single($id));
        }

        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("users"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->users->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}



