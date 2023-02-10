<?php 

/** 
*   Controller partners ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class partners extends \Fyre\Core\Controller {

    function index() {

        // Dependencies
        $this->dependencies(array("partners"), array());

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["limit"])) ? intval($_GET["limit"]) : 999;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "order_by";
        $start      = ($page - 1) * $limit;
        
        $partners = $this->dependencies->partners->multiple($start, $limit, $search, $order);
        $total = $this->dependencies->partners->total($search);

        $pagination = array (
            "page" => (int) $page,
            "limit" => (int) $limit,
            "total" => (int) $total,
            "start" => (int) $start,
        );
        
        if (empty($partners)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $partners, $pagination);
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("partners"));
        
        // Data handling
        $ids       = $_POST['ids'];   
        $status = $this->dependencies->partners->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function single($id) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("partners"), array());

        $partners = $this->dependencies->partners->single($id);
        
        if (empty($partners)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $partners);
    }

    function active($id) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("partners"), array());
        $partners = $this->dependencies->partners->single($id);
        
        $res = false;

        switch ($partners->active)
        {
            case 0:
                $res = 1;
                break;
            case 1:
                $res = 0;
                break;
        }
       
        $this->dependencies->partners->edit(array("id" => $id, "active" => $res));


        if (empty($partners)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        
        $this->response(true, "API REQUEST SUCCESS", $partners);
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("partners"));        

        if(isset($_POST['active'])) {
            $_POST['active'] = 1;
        } else {
            $_POST['active'] = 0;
        }

        if(isset($_POST['slim']) && !empty($_POST['slim'][0])) 
            $_POST['path'] = $_POST['slim'][0];

        // Se o $_POST tiver um id é para copiar as informações todas dessa marca para a marca nova
        if (isset($_POST["id"])) {
            
            $clone = $this->dependencies->partners->single($_POST["id"]);
            
            if (!empty($clone)) {
                
                // Neste foreach estamos a introduzir os valores que não temos na nova marca
                foreach ($clone as $key => $value) {
                    
                    if (!isset($_POST[$key])) {
                        
                        $_POST[$key] = $value;
                    }
                }
            }
            
            // retirar o id do post
            unset($_POST["id"]);
        }

        $multiple = $this->dependencies->partners->multiple();
        // Insert the data
        $status = $this->dependencies->partners->insert($_POST);
        $allIds = [];
        if ($status["success"]) {
            foreach ($multiple as $multi) {
                $allIds[] = $multi->id;
            }
            array_unshift($allIds, $status["data"]);
            $new_positions = implode(",", $allIds);            
            $this->dependencies->partners->order($new_positions);        
            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->partners->single($status["data"]));
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
    
    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("partners"));

        if(isset($_POST['active'])) {
            $_POST['active'] = 1;
        } else {
            $_POST['active'] = 0;
        }
       
        if(isset($_POST['slim']) && !empty($_POST['slim'][0])) 
            $_POST['path'] = $_POST['slim'][0];
        
        // Data handling
        $data = $_POST;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->partners->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->partners->single($id));
    }

    function clone() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("partners"));

        // Se o $_POST tiver um ID copia as informações todas dessa marca para outro
        
        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->partners->single($_POST["id"]);
            $clone->photo = '$clone->photo';

            if (!empty($clone)) {

                //Neste foreach estamos a introduzir os valores que nao temos na nova marca
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
        $status = $this->dependencies->partners->insert($_POST);
        
        if ($status["success"]) {
            
            $brand = $this->dependencies->partners->single($status["data"]);

            $this->response(true, "API REQUEST SUCCESS", $brand);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->dependencies(array("partners"));

        $status = $this->dependencies->partners->remove($id);

        if ($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->partners->single($id));
        }
        
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("partners"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->partners->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}
