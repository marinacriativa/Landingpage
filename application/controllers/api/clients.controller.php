<?php

/**
 *   Controller clients ( Backoffice )
 *
 *   Extends: core/Controller.php
 *   Author: Vlad
 **/

namespace Fyre\Controller;

class clients extends \Fyre\Core\Controller
{

    function index()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("users"), array());

        $page = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit = (isset($_GET["length"])) ? intval($_GET["length"]) : 10;
        $search = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start = ($page - 1) * $limit;

        $clients = $this->dependencies->users->multipleClient(null, $start, $limit, $search, $order);
        $total = $this->dependencies->users->totalClients();


        $pagination = array(
            "page" => (int)$page,
            "limit" => (int)$limit,
            "total" => (int)$total,
            "start" => (int)$start,
        );

        if (empty($clients)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $clients, $pagination);

    }

    function single($id)
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("users", "countries"), array());

        $client = $this->dependencies->users->single($id);

        $countries = $this->dependencies->countries->multiple();

        if (empty($client)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        $infoClient = [
            "client_data" => $client->client_data,
            "sessions_data" => $client->sessions_data,
            "countries" => $countries,
        ];


        $this->response(true, "API REQUEST SUCCESS", $infoClient);
    }

    function edit($id)
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("users"));

        // Data handling
        $data = $_POST;
        $data["id"] = $id;

        if (isset($data['password'])) {
            $data['password'] = $app->auth->getHash($data['password']);
        }

        if (empty($data['password'])) {
            unset($data['password']);
        }

        if (filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {

            // Edit the data
            $status = $this->dependencies->users->edit($data);

            // Send json response
            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->users->single($id));

        }else{
            $this->response(false, "API REQUEST ERROR", "Email não é válido");
        }

    }

    function insert()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("users"));

        // Verifica se está a inserir o produto rascunho
        if (isset($_POST["draft"]) && $_POST["draft"] == "1") {

            $draft = $this->dependencies->users->getDraft();

            if (!empty($draft)) {

                $this->response(true, "API REQUEST SUCCESS", $draft);
            }
        }

        // Definir a linguagem principal
        if (!isset($_POST["lang"])) {
            
            $_POST["lang"] = $app->default_language->code;
        }

        // Se o $_POST tiver um ID copia as informações todas desse produto para outro

        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->users->single($_POST["id"]);

            if (!empty($clone)) {

                //Neste foreach estamos a introduzir os valores que nao temos no novo produto
                foreach ($clone as $key => $value) {

                    if (!isset($_POST[$key])) {

                        $_POST[$key] = $value;
                    }
                }
            }

            //Retirar o id do post
            unset($_POST["id"]);
            
            if (!isset($_POST["keep_language_group"])) {
                
                // Retirar o language group se tiver
                unset($_POST['language_group']);
            }
        } 

        // Insert the data
        $status = $this->dependencies->users->insert($_POST);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->users->single($status["data"]));
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function delete($id)
    {

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