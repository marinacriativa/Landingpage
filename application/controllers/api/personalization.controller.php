<?php

/**
*   Controller products ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class personalization extends \Fyre\Core\Controller {

    function indexItems() {

        global $app;

        // Middleware
        //$this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("personalization_items"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 10;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $personalization_items = $this->dependencies->personalization_items->multiple($app->default_language->code, $start, $limit, $search, $order);
        $total = $this->dependencies->personalization_items->total($app->default_language->code, $search);

        $pagination = array (
            "page" => (int) $page,
            "limit" => (int) $limit,
            "total" => (int) $total,
            "start" => (int) $start,
        );

        if (empty($personalization_items)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $personalization_items, $pagination);
    }

    function changeStatus() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("personalization_items"));

        // Data handling
        $data       = $_POST;
        $id         = $data["id"];

        // Edit the data
        $status = $this->dependencies->personalization_items->changeStatus($data);

        if($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->personalization_items->single($id));
        }
        
        // Send json response
        $this->response(false, "API REQUEST FALSE");
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("personalization_items"));

        $status = false;
     
        if(isset($_POST['selected'])) {

            $status = $this->dependencies->personalization_items->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("personalization"), array());

        $personalization   = $this->dependencies->personalization->multiple();

        if (empty($personalization)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $personalization);
    }

    function indexByLanguage($lang) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("personalization"), array());

        $personalization   = $this->dependencies->personalization->multipleByLanguage($lang);

        if (empty($personalization)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $personalization);
    }

    function single($id) {

        global $app;

        // Middleware
        //$this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("personalization"), array());

        // Product array
        $personalization = $this->dependencies->personalization->single($id);

        if (empty($personalization)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        //Obter outras linguas disponiveis no produto
        $personalization->related = $this->dependencies->personalization->getRelated($personalization->id);

        $this->response(true, "API REQUEST SUCCESS", $personalization);
    }

    function singleItems($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("personalization_items"), array());

        // Product array
        $personalization_items = $this->dependencies->personalization_items->single($id);

        if (empty($personalization_items)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        //Obter outras linguas disponiveis no produto
        $personalization_items->related = $this->dependencies->personalization_items->getRelated($personalization_items->language_group, $personalization_items->id);

        $this->response(true, "API REQUEST SUCCESS", $personalization_items);
    }

    function editItem($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("personalization_items"), array("s3", "image"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        // Vereficar se a imagem antiga não é igual à nova
        $old_data = $this->dependencies->personalization_items->single($id);

        // Edit the data
        $status = $this->dependencies->personalization_items->edit($data);

        if (isset($data["photo"])) {

            if ($old_data->photo !== $data["photo"] && !empty($old_data->photo)) {

                // Eliminar imagem antiga
                $this->dependencies->library->image->delete_file($this->dependencies->library->s3, $old_data->photo);
            }
        }

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->personalization_items->single($id));
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("personalization"));

        // Data handling
        $data       = $_GET;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->personalization->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS");
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("personalization"));

        // Obter a língua da categoria PAI
        if (isset($_POST["parent"])) {

            $_POST["lang"] = $this->dependencies->personalization->single($_POST["parent"])->lang;
        }

        // Insert the data
        $status = $this->dependencies->personalization->insert($_POST);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function insertItem() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("personalization_items"));

        //Verifica se está a inserir o produto rascunho
        if(isset($_POST["draft"]) && $_POST["draft"] == "1"){
            $draft = $this->dependencies->personalization_items->getDraft();

            if(!empty($draft)){
                $this->response(true, "API REQUEST SUCCESS", $draft);
            }
        }

        //Defenir a linguagem principal
        if(!isset($_POST["lang"])){
            $_POST["lang"] = $app->default_language->code;
        }

        //Se o $_POST tiver um id copia as informações todas dessa noticua para a noticia nova
        if(isset($_POST["id"])){
            $clone = $this->dependencies->personalization_items->single($_POST["id"]);

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
        $status = $this->dependencies->personalization_items->insert($_POST);

        if ($status["success"]) {

            //Define o campo que vai agrupar as linguas todas do produto, é basicamente um MD5 do ID do produto na lingua default
            if(!isset($_POST["language_group"])){
                $this->dependencies->personalization_items->edit(array("id" => $status["data"], "language_group" => md5($status["data"])));
            }
            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->personalization_items->single($status["data"]));
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteItem($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("personalization_items"));

        // Delete the data
        $status = $this->dependencies->personalization_items->remove($id);

        if ($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->personalization_items->single($id));
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("personalization"));

        // Delete the data
        $status = $this->dependencies->personalization->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}