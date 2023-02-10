<?php 

/** 
*   Controller coupons ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class coupons extends \Fyre\Core\Controller {

    function index() {

        // Dependencies
        $this->dependencies(array("coupons"), array());

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["limit"])) ? intval($_GET["limit"]) : 999;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;
        
        $coupons = $this->dependencies->coupons->multiple($start, $limit, $search, $order);
        $total = $this->dependencies->coupons->total($search);

        $pagination = array (
            "page" => (int) $page,
            "limit" => (int) $limit,
            "total" => (int) $total,
            "start" => (int) $start,
        );
        
        if (empty($coupons)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $coupons);
    }

    function single($id) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("coupons"), array());

        $coupons = $this->dependencies->coupons->single($id);
        
        if (empty($coupons)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $coupons);
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("coupons"));

        $_POST['type']              = intval($_POST['type']);
        $_POST['reused']            = intval($_POST['reused']);
        $_POST['first_purchase']    = intval($_POST['first_purchase']);
        $_POST['apply_discount']    = intval($_POST['apply_discount']);
        
        if(isset($_POST['active'])) {
            $_POST['active'] = 1;
        } else {
            $_POST['active'] = 0;
        }
     
        if (isset($_POST["start_date"]) && $_POST["start_date"] == '') {
            $_POST["start_date"] = date("Y-m-d");
        }
        if (isset($_POST["end_date"]) && $_POST["end_date"] == '') {
            $_POST["end_date"] = null;
        }

        // Se o $_POST tiver um id é para copiar as informações todas dessa marca para a marca nova
        if (isset($_POST["id"])) {
            
            $clone = $this->dependencies->coupons->single($_POST["id"]);
            
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

        // Insert the data
        $exists = $this->dependencies->coupons->singleByCode($_POST['code'], false);

        if($exists === false) {
            $status = $this->dependencies->coupons->insert($_POST);
        } else {
            $this->response(false, "API REQUEST ERROR", ['coupon_exists' => 'Este código de coupon já existe!']);
        }
     
        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->coupons->single($status["data"]));
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function clone() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("coupons"));

        // Se o $_POST tiver um ID copia as informações todas dessa marca para outro
        
        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->coupons->single($_POST["id"]);
            $clone->code = "";

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
        $status = $this->dependencies->coupons->insert($_POST);
        
        if ($status["success"]) {
            
            $coupon = $this->dependencies->coupons->single($status["data"]);

            $this->response(true, "API REQUEST SUCCESS", $coupon);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
    
    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("coupons"));

        $_POST['type']              = intval($_POST['type']);
        $_POST['reused']            = intval($_POST['reused']);
        $_POST['first_purchase']    = intval($_POST['first_purchase']);
        $_POST['apply_discount']    = intval($_POST['apply_discount']);


        if(isset($_POST['active'])) {
            $_POST['active'] = 1;
        } else {
            $_POST['active'] = 0;
        }    
     
        if (isset($_POST["start_date"]) && $_POST["start_date"] == '') {
            $_POST["start_date"] = date("Y-m-d");
        }
        if (isset($_POST["end_date"]) && $_POST["end_date"] == '') {
            $_POST["end_date"] = null;
        }

        // Data handling
        $data = $_POST;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->coupons->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->coupons->single($id));
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->dependencies(array("coupons"));

        $status = $this->dependencies->coupons->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->coupons->single($id));
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("coupons"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->coupons->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}
