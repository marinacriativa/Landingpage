<?php

/**
*   Controller galleries ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class galleries extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("galleries"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 10;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $galleries = $this->dependencies->galleries->multiple($app->default_language->code, $start, $limit, $search, $order);
        $total = $this->dependencies->galleries->total($app->default_language->code, $search);

        $pagination = array (
            "page" => (int) $page,
            "limit" => (int) $limit,
            "total" => (int) $total,
            "start" => (int) $start,
        );

        if (empty($galleries)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $galleries, $pagination);
    }

    function index_featured() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("galleries"), array());

        $galleries = $this->dependencies->galleries->getFeatured($app->default_language->code);

        if (empty($galleries)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $galleries);
    }

    function single($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("galleries", "galleries_gallery"), array());

        // Gallery array
        $gallery = $this->dependencies->galleries->single($id);

        if (empty($gallery)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        //Obter outras linguas disponiveis no produto
        $gallery->related = $this->dependencies->galleries->getRelated($gallery->language_group, $gallery->id);

        // Obter as imagens
        $gallery->images  = $this->dependencies->galleries_gallery->multiple($gallery->id);

        $this->response(true, "API REQUEST SUCCESS", $gallery);
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("galleries"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->galleries->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->galleries->single($id));
    }

    function changeStatus() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("galleries"));

        // Data handling
        $data       = $_POST;
        $id         = $data["id"];

        // Edit the data
        $status = $this->dependencies->galleries->changeStatus($data);

        if($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->galleries->single($id));
        }
        
        // Send json response
        $this->response(false, "API REQUEST FALSE");
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("galleries", "galleries_gallery", "discounts", "advanced_galleries"));

        //Verifica se está a inserir o produto rascunho
        if(isset($_POST["draft"]) && $_POST["draft"] == "1"){
            $draft = $this->dependencies->galleries->getDraft();

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

            $clone = $this->dependencies->galleries->single($_POST["id"]);
            $imgs = $this->dependencies->galleries_gallery->multiple($_POST["id"]);
            $discounts = $this->dependencies->discounts->getDiscountByGallery($_POST["id"]);
            $advanced_galleries = $this->dependencies->advanced_galleries->advancedGalleriesByGallery($_POST["id"]);

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

            //Retirar language
            unset($_POST["language_group"]);
        }

        // Insert the data
        $status = $this->dependencies->galleries->insert($_POST);

        if ($status["success"]) {

            //Define o campo que vai agrupar as linguas todas do produto, é basicamente um MD5 do ID do produto na lingua default
            if (!isset($_POST["language_group"])) {

                $this->dependencies->galleries->edit(array("id" => $status["data"], "language_group" => md5(time())));
            }

            $gallery = $this->dependencies->galleries->single($status["data"]);

            //Copiar as imagens
            if(!empty($imgs)){
                foreach($imgs as $key => $value){
                    unset($value->id);
                    $value->gallery_id = $gallery->id;
                    $this->dependencies->galleries_gallery->insert($value);
                }
            }

            //Copiar as Descontos
            if(!empty($discounts)){
                foreach($discounts as $key => $value){
                    unset($value->id);
                    $value->id_gallery = $gallery->id;
                    $this->dependencies->discounts->insert($value);
                }
            }

            //Copiar os produtos compostos
            if(!empty($advanced_galleries)){
                foreach($advanced_galleries as $key => $value){
                    unset($value->id);
                    $value->id_gallery = $gallery->id;
                    $this->dependencies->advanced_galleries->insert($value);
                }
            }
            $this->response(true, "API REQUEST SUCCESS", $gallery );
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function clone() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("galleries", "galleries_gallery", "discounts", "advanced_galleries"));

        // Se o $_POST tiver um ID copia as informações todas desse produto para outro
        
        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->galleries->single($_POST["id"]);
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
        $status = $this->dependencies->galleries->insert($_POST);
        
        if ($status["success"]) {

            //Define o campo que vai agrupar as linguas todas do produto, 
            // é basicamente um MD5 do ID do produto na lingua default
            if (!isset($_POST["language_group"])) {
                $this->dependencies->galleries->edit(array("id" => $status["data"], "language_group" => md5($status["data"])));
            }
            
            $gallery = $this->dependencies->galleries->single($status["data"]);

            //Copiar os atributos
            if (!empty($attributes)) {

                foreach($attributes as $key => $value) {
                    
                    // Remover id do atributo
                    unset($value->id);

                    // Adicionar id do produto novo
                    $value->id_gallery = $gallery->id;

                    $this->dependencies->attributes->insert($value);
                }
            }

            $this->response(true, "API REQUEST SUCCESS", $gallery);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("galleries"));

        // Delete the data
        $status = $this->dependencies->galleries->remove($id);

        if ($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->galleries->single($id));
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("galleries"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->galleries->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    //#########################################ADVANCED GALLERY#############################################

    function advancedGalleriesByGallery($idGallery){
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("advanced_galleries"), array());

        // Gallery array
        $advanced_galleries = $this->dependencies->advanced_galleries->advancedGalleriesByGallery($idGallery);

        if (empty($advanced_galleries)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $advanced_galleries);
    }

    function insertAdvancedGallery() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("advanced_galleries"));

        // Insert the data
        $status = $this->dependencies->advanced_galleries->insert($_POST);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->advanced_galleries->single($status["data"]));
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function editAdvancedGallery($id) {

        global $app;

        // Middleware
        //$this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("advanced_galleries"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->advanced_galleries->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->advanced_galleries->single($id));
    }

    function deleteAdvancedGallery($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->dependencies(array("advanced_galleries"));

        $status = $this->dependencies->advanced_galleries->removeSelected($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->advanced_galleries->single($id));
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function singleAdvancedGalleries($idAdvancedGallery){
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("advanced_galleries"), array());

        // Gallery array
        $advancedGallery = $this->dependencies->advanced_galleries->single($idAdvancedGallery);

        if (empty($advancedGallery)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $advancedGallery);
    }
} 