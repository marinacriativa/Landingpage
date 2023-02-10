<?php

/**
 *   Controller alerts ( Backoffice )
 *
 *   Extends: core/Controller.php
 *   Author: Vlad
 **/

namespace Fyre\Controller;

class alerts extends \Fyre\Core\Controller
{

    function index()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("alerts"), array());

        $page = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit = (isset($_GET["length"])) ? intval($_GET["length"]) : 10;
        $search = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start = ($page - 1) * $limit;
        
        $alerts = $this->dependencies->alerts->multiple(null, $start, $limit, $search, $order);
        $total = $this->dependencies->alerts->listing();

        $pagination = array(
            "page" => (int)$page,
            "limit" => (int)$limit,
            "total" => (int)$total,
            "start" => (int)$start,
        );

               

        if (empty($alerts)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $alerts, $pagination);

    }

    function single($id)
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("alerts"), array());

        $alert = $this->dependencies->alerts->single($id);

        if (empty($alert)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $alert);
    }

    function edit($id) {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("alerts"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->alerts->edit($data);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS", $status);
    }

    function changeStatus() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("alerts"));

        // Data handling
        $data       = $_POST;
        $id         = $data["id"];

        // Edit the data
        $status = $this->dependencies->alerts->changeStatus($data);

        if($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->alerts->single($id));
        }
        
        // Send json response
        $this->response(false, "API REQUEST FALSE");
    }

    function insert()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("alerts"));

        // Verifica se está a inserir o produto rascunho
        if (isset($_POST["draft"]) && $_POST["draft"] == "1") {

            $draft = $this->dependencies->alerts->getDraft();

            if (!empty($draft)) {

                $this->response(true, "API REQUEST SUCCESS", $draft);
            }
        }

        // Defenir a linguagem principal
        if (!isset($_POST["lang"])) {
            
            $_POST["lang"] = $app->default_language->code;
        }

        // Se o $_POST tiver um ID copia as informações todas desse produto para outro

        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->alerts->single($_POST["id"]);

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
        $status = $this->dependencies->alerts->insert($_POST);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->alerts->single($status["data"]));
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function clone() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("alerts"));

        // Se o $_POST tiver um ID copia as informações todas desse produto para outro
        
        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->alerts->single($_POST["id"]);

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
        $status = $this->dependencies->alerts->insert($_POST);
        
        if ($status["success"]) {
            
            $alert = $this->dependencies->alerts->single($status["data"]);

            //Copiar os atributos
            if (!empty($attributes)) {

                foreach($attributes as $key => $value) {
                    
                    // Remover id do atributo
                    unset($value->id);

                    // Adicionar id do produto novo
                    $value->id_alert = $alerts->id;

                    $this->dependencies->attributes->insert($value);
                }
            }

            $this->response(true, "API REQUEST SUCCESS", $alert);
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
        $this->dependencies(array("alerts"));
        
        $status = $this->dependencies->alerts->remove($id);

        if ($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->alerts->single($id));
        }
        
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("alerts"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->alerts->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}