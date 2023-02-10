<?php 

/** 
*   Controller brands ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class brands extends \Fyre\Core\Controller {

    function index() {

        // Dependencies
        $this->dependencies(array("brands"), array());

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["limit"])) ? intval($_GET["limit"]) : 999;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "order_by";
        $start      = ($page - 1) * $limit;
        
        $brands = $this->dependencies->brands->multiple($start, $limit, $search, $order);
        $total = $this->dependencies->brands->total($search);

        $pagination = array (
            "page" => (int) $page,
            "limit" => (int) $limit,
            "total" => (int) $total,
            "start" => (int) $start,
        );
        
        if (empty($brands)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $brands, $pagination);
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("brands"));
        
        // Data handling
        $ids       = $_POST['ids'];   
        $status = $this->dependencies->brands->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function single($id) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("brands"), array());

        $brands = $this->dependencies->brands->single($id);
        
        if (empty($brands)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $brands);
    }

    function active($id) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("brands"), array());
        $brands = $this->dependencies->brands->single($id);
        
        $res = false;

        switch ($brands->active)
        {
            case 0:
                $res = 1;
                break;
            case 1:
                $res = 0;
                break;
        }
       
        $this->dependencies->brands->edit(array("id" => $id, "active" => $res));


        if (empty($brands)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        
        $this->response(true, "API REQUEST SUCCESS", $brands);
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("brands"));        

        if(isset($_POST['active'])) {
            $_POST['active'] = 1;
        } else {
            $_POST['active'] = 0;
        }

        if(isset($_POST['slim']) && !empty($_POST['slim'][0])) 
            $_POST['path'] = $_POST['slim'][0];

        // Se o $_POST tiver um id é para copiar as informações todas dessa marca para a marca nova
        if (isset($_POST["id"])) {
            
            $clone = $this->dependencies->brands->single($_POST["id"]);
            
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

        $multiple = $this->dependencies->brands->multiple();
        // Insert the data
        $status = $this->dependencies->brands->insert($_POST);
        $allIds = [];
        if ($status["success"]) {
            foreach ($multiple as $multi) {
                $allIds[] = $multi->id;
            }
            array_unshift($allIds, $status["data"]);
            $new_positions = implode(",", $allIds);            
            $this->dependencies->brands->order($new_positions);        
            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->brands->single($status["data"]));
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
    
    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("brands"));

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
        $status = $this->dependencies->brands->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->brands->single($id));
    }

    function clone() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("brands"));

        // Se o $_POST tiver um ID copia as informações todas dessa marca para outro
        
        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->brands->single($_POST["id"]);
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
        $status = $this->dependencies->brands->insert($_POST);
        
        if ($status["success"]) {
            
            $brand = $this->dependencies->brands->single($status["data"]);

            $this->response(true, "API REQUEST SUCCESS", $brand);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->dependencies(array("brands"));

        $status = $this->dependencies->brands->remove($id);

        if ($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->brands->single($id));
        }
        
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("brands"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->brands->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}
