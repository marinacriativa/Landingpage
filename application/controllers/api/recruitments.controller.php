<?php 

/** 
*   Controller recruitments ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class recruitments extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("recruitments"), array());

        $page       = (isset($_GET["page"]))    ? intval($_GET["page"])     : 1;
        $limit      = (isset($_GET["length"]))  ? intval($_GET["length"])   : 10;
        $search     = (isset($_GET["search"]))  ? $_GET["search"]           : null;
        $order      = (isset($_GET["order"]))   ? $_GET["order"]            : "id";
        $start      = ($page - 1) * $limit;  

        $recruitments   = $this->dependencies->recruitments->multiple($app->default_language->code, $start, $limit, $search, $order);
        $total  = $this->dependencies->recruitments->total($app->default_language->code, $search);

        $pagination = array (
            "page"      => (int) $page, 
            "limit"     => (int) $limit, 
            "total"     => (int) $total, 
            "start"     => (int) $start, 
        );

        if (empty($recruitments)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $recruitments, $pagination);
    }

    function changeStatus() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("recruitments"));

        // Data handling
        $data       = $_POST;
        $id         = $data["id"];

        // Edit the data
        $status = $this->dependencies->recruitments->changeStatus($data);

        if($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->recruitments->single($id));
        }
        
        // Send json response
        $this->response(false, "API REQUEST FALSE");
    }

    function insert() {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("recruitments"));

        // Vereficar se está a inserir uma notícia "rascunho"
        if (isset($_POST["draft"]) && $_POST["draft"] == "1") {
            
            $draft = $this->dependencies->recruitments->getDraft();
            
            if (!empty($draft)) {
                
                // A API dá return da noticia rascunho, depois desta função o codigo nao executa mais
                $this->response(true, "API REQUEST SUCCESS", $draft);
            }
        }
        
        // Temos de definir a lingua principal da noticia
        if (!isset($_POST["lang"])) {
            
            $_POST["lang"] = $app->default_language->code;
        }
        
        // Se o $_POST tiver um id é para copiar as informações todas dessa noticia para a noticia nova
        if (isset($_POST["id"])) {
            
            $clone = $this->dependencies->recruitments->single($_POST["id"]);
            
            if (!empty($clone)) {
                
                // Neste foreach estamos a introduzir os valores que não temos na nova noticia
                foreach ($clone as $key => $value) {
                    
                    if (!isset($_POST[$key])) {
                        
                        $_POST[$key] = $value;
                    }
                }
            }
            
            // retirar o id do post
            unset($_POST["id"]);
        }

        if (isset($_POST["date"]) && $_POST["date"] == '0000-00-00') {
            $_POST["date"] = date("Y-m-d");
        }
        
        // Insert the data
        $status = $this->dependencies->recruitments->insert($_POST);

        if ($status["success"]) {

            // Definir o campo que vai agrupar as linguas todas da noticia
            // É basicamente um MD5 do ID da noticia na lingua default
            if (!isset($_POST["language_group"])) {
                
                $this->dependencies->recruitments->edit(array("id" => $status["data"], "language_group" => md5($status["data"])));
            }

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->recruitments->single($status["data"]));
        }
        
        // Send json response 
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
    
    function single($id) {
        
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("recruitments"), array());

        // Product array
        $recruit = $this->dependencies->recruitments->single($id);

        if (empty($recruit)) {
            
            $this->response(false, "API REQUEST EMPTY");
        }

        // Obter outras linguas disponiveis na noticia
        $recruit->related = $this->dependencies->recruitments->getRelated($recruit->language_group, $recruit->id);

        $this->response(true, "API REQUEST SUCCESS", $recruit);
    }

    function edit($id) {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("recruitments"), array("s3", "image"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        // Vereficar se a imagem antiga não é igual à nova
        $old_data = $this->dependencies->recruitments->single($id);

        if(!isset($data['date']) || $data['date'] == '')
            $data['date'] = date('Y-m-d');

        // Edit the data
        $status = $this->dependencies->recruitments->edit($data);    

        if (isset($data["photo_path"])) {

            if (($old_data->photo_path !== $data["photo_path"]) && !empty($old_data->photo_path)) {

                // Eliminar imagem antiga
                $this->dependencies->library->image->delete_file($this->dependencies->library->s3, $old_data->photo_path);
            }
        }

        // Vereficar se a imagem antiga não é igual à nova
        $new_data = $this->dependencies->recruitments->single($id);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS", $new_data);
    }
    
    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("recruitments"), array("s3", "image"));

        $data = $this->dependencies->recruitments->single($id);

        if (empty($data)) {

            $this->response(false, "API REQUEST ERROR");
        }
        
        if($data->photo_path != null && !empty($data->photo_path)){
            $this->dependencies->library->image->delete_file($this->dependencies->library->s3, $data->photo_path);
        }

        // Delete the data
        $status = $this->dependencies->recruitments->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function clone() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("recruitments"));

        // Se o $_POST tiver um ID copia as informações todas desse produto para outro
        
        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->recruitments->single($_POST["id"]);

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
        $status = $this->dependencies->recruitments->insert($_POST);
        
        if ($status["success"]) {

            //Define o campo que vai agrupar as linguas todas do produto, 
            // é basicamente um MD5 do ID do produto na lingua default
            if (!isset($_POST["language_group"])) {
                $this->dependencies->recruitments->edit(array("id" => $status["data"], "language_group" => md5($status["data"])));
            }
            
            $recruitment = $this->dependencies->recruitments->single($status["data"]);

            $this->response(true, "API REQUEST SUCCESS", $recruitment);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("recruitments"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->recruitments->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}