<?php 

/** 
*   Controller popups ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class popups extends \Fyre\Core\Controller {    

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("popups"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 10;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $lang       = (isset($_GET["lang"]) && !empty($_GET["lang"])) ? $_GET["lang"] : $app->default_language->code;
        $start      = ($page - 1) * $limit;
        
        $popups = $this->dependencies->popups->multiple($lang, $start, $limit, $search, $order);
        $total = $this->dependencies->popups->total($lang, $search);

        $pagination = array (
            "page" => (int) $page,
            "limit" => (int) $limit,
            "total" => (int) $total,
            "start" => (int) $start,
        );

        if (empty($popups)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $popups, $pagination);
    }

    function single($id) {

        global $app;
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("popups"), array());

        $popups   = $this->dependencies->popups->single($id);

        if (empty($popups)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $popups);
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("popups"));

        //var_dump($_POST); die;

        // Insert the data
        $status = $this->dependencies->popups->insert($_POST);
 
        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $status);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
    
    function edit($id) {
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("popups"));
        
        // Data handling
        $data       = $_POST;
        $data["id"] = $id;
        // Edit the data
        $status = $this->dependencies->popups->edit($data);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }
    
    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("popups"));
        
        // Delete the data
        $status = $this->dependencies->popups->remove($id);

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
        $this->dependencies(array("popups"));

        // Se o $_POST tiver um ID copia as informações todas desse produto para outro

        if (isset($_POST["id"])) {            
            $clone          = $this->dependencies->popups->single($_POST["id"]);         

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
        $status = $this->dependencies->popups->insert($_POST);
       
        if ($status["success"]) {

            $popup = $this->dependencies->popups->single($status["data"]);           
        
            
            //Define o campo que vai agrupar as linguas todas do produto, 
            // é basicamente um MD5 do ID do produto na lingua default
           /*  if (!isset($_POST["language_group"])) {
                $this->dependencies->popups->edit(array("id" => $popup->id, "language_group" => md5($popup->id)));
            }        */      

            $this->response(true, "API REQUEST SUCCESS", $popup);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("popups"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->popups->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}