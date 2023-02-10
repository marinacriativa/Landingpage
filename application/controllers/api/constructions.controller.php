<?php

/**
*   Controller constructions ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class constructions extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("constructions"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 10;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $lang       = (isset($_GET["lang"]) && !empty($_GET["lang"])) ? $_GET["lang"] : $app->default_language->code;
        $start      = ($page - 1) * $limit;
        
        $constructions = $this->dependencies->constructions->multiple($lang, $start, $limit, $search, $order);
        $total = $this->dependencies->constructions->total($lang, $search);

        $pagination = array (
            "page" => (int) $page,
            "limit" => (int) $limit,
            "total" => (int) $total,
            "start" => (int) $start,
        );

        if (empty($constructions)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $constructions, $pagination);
    }

    function index_featured() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("constructions"), array());

        $constructions = $this->dependencies->constructions->getFeatured($app->default_language->code);

        if (empty($constructions)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $constructions);
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("constructions"));
        
        // Data handling
        $ids       = $_POST['ids'];                
        $status = $this->dependencies->constructions->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function single($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("constructions", "constructions_gallery"), array());

        // construction array
        $construction = $this->dependencies->constructions->single($id);

        if (empty($construction)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        //Obter outras linguas disponiveis no produto
        $construction->related = $this->dependencies->constructions->getRelated($construction->language_group, $construction->id);

        // Obter as imagens
        $construction->images  = $this->dependencies->constructions_gallery->multiple($construction->id); 

        $this->response(true, "API REQUEST SUCCESS", $construction);
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("constructions"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->constructions->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->constructions->single($id));
    }

    function changeStatus() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("constructions"));

        // Data handling
        $data       = $_POST;
        $id         = $data["id"];

        // Edit the data
        $status = $this->dependencies->constructions->changeStatus($data);

        if($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->constructions->single($id));
        }
        
        // Send json response
        $this->response(false, "API REQUEST FALSE");
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("constructions", "constructions_gallery", "attributes_constructions"));

        // Verifica se está a inserir o construction rascunho
        if (isset($_POST["draft"]) && $_POST["draft"] == "1") {

            $draft = $this->dependencies->constructions->getDraft();

            if (!empty($draft)) {

                $this->response(true, "API REQUEST SUCCESS", $draft);
            }
        }

        // Defenir a linguagem principal
        if (!isset($_POST["lang"])) {
            
            $_POST["lang"] = $app->default_language->code;
        }

        // Se o $_POST tiver um ID copia as informações todas desse construction para outro
        $galleryImg = false;
        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->constructions->single($_POST["id"]);
            $galleryImg     = $this->dependencies->constructions_gallery->multiple($_POST["id"]);            
            if($clone->photo == null) {
                $clone->photo   = '/static/images/login-background.jpg';
            }
            $attributes_constructions     = $this->dependencies->attributes_constructions->getAttributesByConstruction($_POST["id"]);

            if (!empty($clone)) {

                //Neste foreach estamos a introduzir os valores que nao temos no novo construction
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
        $status = $this->dependencies->constructions->insert($_POST);
       
        if ($status["success"]) {

            $construction = $this->dependencies->constructions->single($status["data"]);

            if($galleryImg != false) {
                foreach($galleryImg as $g) {
                    unset($g->id);
                    $g->construction_id = $construction->id;
                    $path_parts = pathinfo($g->path);       
                    $new_path = $g->path . '-' . $construction->lang . '.' . $path_parts['extension'];                     
                    copy(ROOT . 'public' . $g->path, ROOT . 'public' . $new_path);
                    if($construction->photo == $g->path) {                   
                        $this->dependencies->constructions->edit(array("id" => $construction->id, "photo" => $new_path));
                    }
                    $g->path = $new_path;
                    $this->dependencies->constructions_gallery->insert($g);                    
                }
            }
            
            //Define o campo que vai agrupar as linguas todas do produto, 
            // é basicamente um MD5 do ID do produto na lingua default
            if (!isset($_POST["language_group"])) {
                $this->dependencies->constructions->edit(array("id" => $construction->id, "language_group" => md5($construction->id)));
            }             

            //Copiar os atributos
            if (!empty($attributes_constructions)) {

                foreach($attributes_constructions as $key => $value) {
                    
                    // Remover id do atributo
                    unset($value->id);

                    // Adicionar id do produto novo
                    $value->id_construction = $construction->id;

                    $this->dependencies->attributes_constructions->insert($value);
                }
            }

            $this->response(true, "API REQUEST SUCCESS", $construction);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function clone() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("constructions", "constructions_gallery", "attributes_constructions"));

        // Se o $_POST tiver um ID copia as informações todas desse produto para outro
        $galleryImg = false;
        if (isset($_POST["id"])) {            
            $clone          = $this->dependencies->constructions->single($_POST["id"]);
            $galleryImg     = $this->dependencies->constructions_gallery->multiple($_POST["id"]);            
            if($clone->photo == null) {
                $clone->photo   = '/static/images/login-background.jpg';
            }
            $attributes_constructions     = $this->dependencies->attributes_constructions->getAttributesByconstruction($_POST["id"]);

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
        $status = $this->dependencies->constructions->insert($_POST);
       
        if ($status["success"]) {

            $construction = $this->dependencies->constructions->single($status["data"]);            
            
            if($galleryImg != false) {
                foreach($galleryImg as $g) {
                    unset($g->id);
                    $g->construction_id = $construction->id;
                    $path_parts = pathinfo($g->path);       
                    $new_path = $g->path . '-' . $construction->lang . '.' . $path_parts['extension'];                     
                    copy(ROOT . 'public' . $g->path, ROOT . 'public' . $new_path);
                    if($construction->photo == $g->path) {                   
                        $this->dependencies->constructions->edit(array("id" => $construction->id, "photo" => $new_path));
                    }
                    $g->path = $new_path;
                    $this->dependencies->constructions_gallery->insert($g);                    
                }
            }
            
            //Define o campo que vai agrupar as linguas todas do produto, 
            // é basicamente um MD5 do ID do produto na lingua default
            if (!isset($_POST["language_group"])) {
                $this->dependencies->constructions->edit(array("id" => $construction->id, "language_group" => md5($construction->id)));
            }             

            //Copiar os atributos
            if (!empty($attributes_constructions)) {

                foreach($attributes_constructions as $key => $value) {
                    
                    // Remover id do atributo
                    unset($value->id);

                    // Adicionar id do produto novo
                    $value->id_construction = $construction->id;

                    $this->dependencies->attributes_constructions->insert($value);
                }
            }

            $this->response(true, "API REQUEST SUCCESS", $construction);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("constructions"));

        // Delete the data
        $status = $this->dependencies->constructions->remove($id);

        if ($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->constructions->single($id));
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("constructions"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->constructions->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
    
}