<?php

/**
*   Controller obituaries ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class obituaries extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("obituaries"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 10;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $lang       = (isset($_GET["lang"]) && !empty($_GET["lang"])) ? $_GET["lang"] : $app->default_language->code;
        $start      = ($page - 1) * $limit;
        
        $obituaries = $this->dependencies->obituaries->multiple($lang, $start, $limit, $search, $order);
        $total = $this->dependencies->obituaries->total($lang, $search);

        $pagination = array (
            "page" => (int) $page,
            "limit" => (int) $limit,
            "total" => (int) $total,
            "start" => (int) $start,
        );

        if (empty($obituaries)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $obituaries, $pagination);
    }

    function index_featured() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("obituaries"), array());

        $obituaries = $this->dependencies->obituaries->getFeatured($app->default_language->code);

        if (empty($obituaries)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $obituaries);
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("obituaries"));
        
        // Data handling
        $ids       = $_POST['ids'];                
        $status = $this->dependencies->obituaries->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function single($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("obituaries"), array());

        // obituary array
        $obituary = $this->dependencies->obituaries->single($id);

        if (empty($obituary)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $obituary);
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("obituaries"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->obituaries->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->obituaries->single($id));
    }

    function changeStatus() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("obituaries"));

        // Data handling
        $data       = $_POST;
        $id         = $data["id"];

        // Edit the data
        $status = $this->dependencies->obituaries->changeStatus($data);

        if($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->obituaries->single($id));
        }
        
        // Send json response
        $this->response(false, "API REQUEST FALSE");
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("obituaries"));

        // Verifica se está a inserir o obituary rascunho
        if (isset($_POST["draft"]) && $_POST["draft"] == "1") {

            $draft = $this->dependencies->obituaries->getDraft();

            if (!empty($draft)) {

                $this->response(true, "API REQUEST SUCCESS", $draft);
            }
        }

        // Defenir a linguagem principal
        if (!isset($_POST["lang"])) {
            
            $_POST["lang"] = $app->default_language->code;
        }

        // Se o $_POST tiver um ID copia as informações todas desse obituary para outro
        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->obituaries->single($_POST["id"]);           
            if($clone->photo == null) {
                $clone->photo   = '/static/images/login-background.jpg';
            }

            if (!empty($clone)) {

                //Neste foreach estamos a introduzir os valores que nao temos no novo obituary
                foreach ($clone as $key => $value) {

                    if (!isset($_POST[$key])) {

                        $_POST[$key] = $value;
                    }
                }
            }

            //Retirar o id do post
            unset($_POST["id"]);
        }   

        // Insert the data
        $status = $this->dependencies->obituaries->insert($_POST);
       
        if ($status["success"]) {

            $obituary = $this->dependencies->obituaries->single($status["data"]);         

            $this->response(true, "API REQUEST SUCCESS", $obituary);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function clone() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("obituaries"));

        // Se o $_POST tiver um ID copia as informações todas desse produto para outro
        if (isset($_POST["id"])) {            
            $clone          = $this->dependencies->obituaries->single($_POST["id"]);          
            if($clone->photo == null) {
                $clone->photo   = '/static/images/login-background.jpg';
            }

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
        }   

        // Insert the data
        $status = $this->dependencies->obituaries->insert($_POST);
       
        if ($status["success"]) {

            $obituary = $this->dependencies->obituaries->single($status["data"]);                       

            $this->response(true, "API REQUEST SUCCESS", $obituary);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("obituaries"));

        // Delete the data
        $status = $this->dependencies->obituaries->remove($id);

        if ($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->obituaries->single($id));
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("obituaries"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->obituaries->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
    
}