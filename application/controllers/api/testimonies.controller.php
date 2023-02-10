<?php

/**
 *   Controller testimonies ( Backoffice )
 *
 *   Extends: core/Controller.php
 *   Author: Vlad
 **/

namespace Fyre\Controller;

class testimonies extends \Fyre\Core\Controller
{

    function index()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("testimonies"), array());

        $page = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit = (isset($_GET["length"])) ? intval($_GET["length"]) : 10;
        $search = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start = ($page - 1) * $limit;
        
        $testimonies = $this->dependencies->testimonies->multiple(null, $start, $limit, $search, $order);
        $total = $this->dependencies->testimonies->listing();


        $pagination = array(
            "page" => (int)$page,
            "limit" => (int)$limit,
            "total" => (int)$total,
            "start" => (int)$start,
        );

               

        if (empty($testimonies)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $testimonies, $pagination);

    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("testimonies"));
        
        // Data handling
        $ids       = $_POST['ids'];                
        $status = $this->dependencies->testimonies->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function single($id)
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("testimonies"), array());

        $page = $this->dependencies->testimonies->single($id);

        if (empty($page)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $page);
    }

    function edit($id) {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("testimonies"), array("s3", "image"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        // Vereficar se a imagem antiga não é igual à nova
        $old_data = $this->dependencies->testimonies->single($id);

        // Edit the data
        $status = $this->dependencies->testimonies->edit($data);

        if (isset($data["url"])) {

            if (($old_data->url !== $data["url"]) && !empty($old_data->url)) {

                // Eliminar imagem antiga
                $this->dependencies->library->image->delete_file($this->dependencies->library->s3, $old_data->url);
            }
        }

        // Vereficar se a imagem antiga não é igual à nova
        $new_data = $this->dependencies->testimonies->single($id);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS", $new_data);
    }

    function insert()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("testimonies"));

        // Verifica se está a inserir o testimony rascunho
        if (isset($_POST["draft"]) && $_POST["draft"] == "1") {

            $draft = $this->dependencies->testimonies->getDraft();

            if (!empty($draft)) {

                $this->response(true, "API REQUEST SUCCESS", $draft);
            }
        }

        // Defenir a linguagem principal
        if (!isset($_POST["lang"])) {
            
            $_POST["lang"] = $app->default_language->code;
        }

        // Se o $_POST tiver um ID copia as informações todas desse testimonies para outro

        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->testimonies->single($_POST["id"]);

            if (!empty($clone)) {

                //Neste foreach estamos a introduzir os valores que nao temos no novo testimonies
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
        $status = $this->dependencies->testimonies->insert($_POST);
        //var_dump($status); die;

        if ($status["success"]) {

            if (!isset($_POST["language_group"])) {
                $this->dependencies->testimonies->edit(array("id" => $status["data"], "language_group" => md5($status["data"])));
            }

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->testimonies->single($status["data"]));
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function changeStatus() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("testimonies"));

        // Data handling
        $data       = $_POST;
        $id         = $data["id"];

        // Edit the data
        $status = $this->dependencies->testimonies->changeStatus($data);

        if($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->testimonies->single($id));
        }
        
        // Send json response
        $this->response(false, "API REQUEST FALSE");
    }

    function clone() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("testimonies"));

        // Se o $_POST tiver um ID copia as informações todas desse testemunho para outro

        
        if (isset($_POST["id"])) {
            
            $clone      = $this->dependencies->testimonies->single($_POST["id"]);
            
            if (!empty($clone)) {
                
                //Neste foreach estamos a introduzir os valores que nao temos no novo testemunho
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
        $status = $this->dependencies->testimonies->insert($_POST);
        
        if ($status["success"]) {
            
            //Define o campo que vai agrupar as linguas todas do produto, 
            // é basicamente um MD5 do ID do produto na lingua default
            if (!isset($_POST["language_group"])) {
                $res = $this->dependencies->testimonies->edit(array("id" => $status["data"], "language_group" => md5($status["data"])));
            }
            
            $testimony = $this->dependencies->testimonies->single($status["data"]);
            
            $this->response(true, "API REQUEST SUCCESS", $testimony);
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
        $this->dependencies(array("testimonies"));
        
        $status = $this->dependencies->testimonies->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->testimonies->single($id));
        }

        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("testimonies"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->testimonies->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}