<?php

/**
*   Controller filters ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class filters extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("filters"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 10;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $filters = $this->dependencies->filters->multiple($start, $limit, $search, $order);
        $total = $this->dependencies->filters->total($app->default_language->code, $search);

        $pagination = array (
            "page" => (int) $page,
            "limit" => (int) $limit,
            "total" => (int) $total,
            "start" => (int) $start,
        );

        if (empty($filters)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $filters, $pagination);
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("filters"));
        
        // Data handling
        $ids       = $_POST['ids'];   
        $status = $this->dependencies->filters->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function index_featured() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("filters"), array());

        $filters = $this->dependencies->filters->getFeatured($app->default_language->code);

        if (empty($filters)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $filters);
    }

    function single($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("filters", "filter_items"), array());

        // Gallery array
        $filters = $this->dependencies->filters->single($id);

        if (empty($filters)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        //Obter filter_items
        $filters->filter_items[] = $this->dependencies->filter_items->multiple($id);

        $this->response(true, "API REQUEST SUCCESS", $filters);
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("filters"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->filters->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->filters->single($id));   
    }

    function changeStatus() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("filters"));

        // Data handling
        $data       = $_POST;
        $id         = $data["id"];

        // Edit the data
        $status = $this->dependencies->filters->changeStatus($data);

        if($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->filters->single($id));
        }
        
        // Send json response
        $this->response(false, "API REQUEST FALSE");
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("filters"));        
        
        //Definir a linguagem principal
        if(!isset($_POST["lang"])){
            $_POST["lang"] = $app->default_language->code;
        }        
        //Se o $_POST tiver um id copia as informações todas dessa noticua para a noticia nova
        if(isset($_POST["id"])){
            
            $clone = $this->dependencies->filters->single($_POST["id"]);
            
            if(!empty($clone)){
                //Neste forEach estamos a introduzir os valores que nao temos na nova noticia
                foreach($clone as $key => $value){
                    if(!isset($_POST[$key])){
                        $_POST[$key] = $value;
                    }
                }
            }
            //Retirar o id do post
            unset($_POST["id"]);
            

        }
        
        // Insert the data
        $status = $this->dependencies->filters->insert($_POST);

        if ($status["success"]) {

            //Define o campo que vai agrupar as linguas todas do produto, é basicamente um MD5 do ID do produto na lingua default

            $filters = $this->dependencies->filters->single($status["data"]);

            $this->response(true, "API REQUEST SUCCESS", $filters );
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function clone() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("filters"));

        // Se o $_POST tiver um ID copia as informações todas desse produto para outro
        
        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->filters->single($_POST["id"]);
            $clone->photo = '$clone->photo';

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
        $status = $this->dependencies->filters->insert($_POST);
        
        if ($status["success"]) {

            //Define o campo que vai agrupar as linguas todas do produto, 
            // é basicamente um MD5 do ID do produto na lingua default
            if (!isset($_POST["language_group"])) {
                $this->dependencies->filters->edit(array("id" => $status["data"], "language_group" => md5($status["data"])));
            }
            
            $service = $this->dependencies->filters->single($status["data"]);

            //Copiar os atributos
            if (!empty($attributes)) {

                foreach($attributes as $key => $value) {
                    
                    // Remover id do atributo
                    unset($value->id);

                    // Adicionar id do produto novo
                    $value->id_service = $filters->id;

                    $this->dependencies->attributes->insert($value);
                }
            }

            $this->response(true, "API REQUEST SUCCESS", $service);
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
        $this->dependencies(array("filters"));
        
        $status = $this->dependencies->filters->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->filters->single($id));
        }

        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("filters"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->filters->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
} 