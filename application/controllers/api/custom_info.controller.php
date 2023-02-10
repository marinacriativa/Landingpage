<?php

/**
*   Controller custom_info ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class custom_info extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("custom_info"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 10;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $custom_info = $this->dependencies->custom_info->multiple($app->default_language->code, $start, $limit, $search, $order);
        $total = $this->dependencies->custom_info->total($app->default_language->code, $search);

        $pagination = array (
            "page" => (int) $page,
            "limit" => (int) $limit,
            "total" => (int) $total,
            "start" => (int) $start,
        );

        if (empty($custom_info)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $custom_info, $pagination);
    }


    function single($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("custom_info"));

        // Gallery array
        $custom_info = $this->dependencies->custom_info->single($id);

        if (empty($custom_info)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        //Obter outras linguas disponiveis no produto
        $custom_info->related = $this->dependencies->custom_info->getRelated($custom_info->language_group, $custom_info->id);

        $this->response(true, "API REQUEST SUCCESS", $custom_info);
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("custom_info"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        if(isset($_FILES)) {
            foreach($_FILES as $key => $current_file) {    
            
                $file = $_FILES[$key];

                $fileName = $_FILES[$key]['name'];
                $fileTmpName = $_FILES[$key]['tmp_name'];
                $fileSize = $_FILES[$key]['size'];
                $fileError = $_FILES[$key]['error'];
                $fileType = $_FILES[$key]['type'];

                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));

                $allowed = array('jpg', 'jpeg', 'png', 'gif', 'svg');                        

                if(in_array($fileActualExt, $allowed)) {
                    if($fileError === 0) {
                        if($fileSize < 5000000) {
                            $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                            $fileDestination = ROOT . 'public/static/images/custom_info/' . $fileNameNew;
                            //$_POST['file'] = $fileNameNew;
                            move_uploaded_file($fileTmpName, $fileDestination);   
                            if (!empty($_FILES[$key])) {
                                $myf[] = array("name" => $fileNameNew, "path" => $fileDestination);
                            } 

                            
                            $fileDestination = str_replace(ROOT . "public", "", $fileDestination);                      

                            $data[$key] = $fileDestination;


                        } else { 
                            $this->response(false, "API REQUEST ERROR", "Arquivo muito grande!");

                        }
                    } else {
                        $this->response(false, "API REQUEST ERROR", "Falha no upload, tente novamente.");
                    }
                } elseif($fileActualExt != "") {
                    $this->response(false, "API REQUEST ERROR", "Somente são permitidos arquivos jpg, jpeg, png, svg e gif.");
                }
            }

        } else {
            $this->response(false, "API REQUEST ERROR", 'Nenhum arquivo foi enviado.');
        }

        // Edit the data
        $status = $this->dependencies->custom_info->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->custom_info->single($id));   
    }

    function changeStatus() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("custom_info"));

        // Data handling
        $data       = $_POST;
        $id         = $data["id"];

        // Edit the data
        $status = $this->dependencies->custom_info->changeStatus($data);

        if($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->custom_info->single($id));
        }
        
        // Send json response
        $this->response(false, "API REQUEST FALSE");
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("custom_info"));
        
        //Verifica se está a inserir o produto rascunho
        if(isset($_POST["draft"]) && $_POST["draft"] == "1"){
            $draft = $this->dependencies->custom_info->getDraft();
            
            if(!empty($draft)){
                $this->response(true, "API REQUEST SUCCESS", $draft);
            }
        }
        
        //Definir a linguagem principal
        if(!isset($_POST["lang"])){
            $_POST["lang"] = $app->default_language->code;
        }
        
        //Se o $_POST tiver um id copia as informações todas dessa noticua para a noticia nova
        if(isset($_POST["id"])){
            
            $clone = $this->dependencies->custom_info->single($_POST["id"]);
            
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
            
            if (!isset($_POST["keep_language_group"])) {
                
                // Retirar o language group se tiver
                unset($_POST['language_group']);
            }
        }
        
        // Insert the data
        $status = $this->dependencies->custom_info->insert($_POST);

        if ($status["success"]) {

            //Define o campo que vai agrupar as linguas todas do produto, é basicamente um MD5 do ID do produto na lingua default
            if (!isset($_POST["language_group"])) {

                $this->dependencies->custom_info->edit(array("id" => $status["data"], "language_group" => md5(time())));
            }

            $custom_info = $this->dependencies->custom_info->single($status["data"]);


            $this->response(true, "API REQUEST SUCCESS", $custom_info );
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function clone() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("custom_info"));

        // Se o $_POST tiver um ID copia as informações todas desse produto para outro
        
        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->custom_info->single($_POST["id"]);
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
        $status = $this->dependencies->custom_info->insert($_POST);
        
        if ($status["success"]) {

            //Define o campo que vai agrupar as linguas todas do produto, 
            // é basicamente um MD5 do ID do produto na lingua default
            if (!isset($_POST["language_group"])) {
                $this->dependencies->custom_info->edit(array("id" => $status["data"], "language_group" => md5($status["data"])));
            }
            
            $service = $this->dependencies->custom_info->single($status["data"]);

            //Copiar os atributos
            if (!empty($attributes)) {

                foreach($attributes as $key => $value) {
                    
                    // Remover id do atributo
                    unset($value->id);

                    // Adicionar id do produto novo
                    $value->id_service = $custom_info->id;

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
        $this->dependencies(array("custom_info"));
        
        $status = $this->dependencies->custom_info->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->custom_info->single($id));
        }

        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("custom_info"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->custom_info->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
} 