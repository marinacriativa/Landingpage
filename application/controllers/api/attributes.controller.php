<?php 

/** 
*   Controller attributes ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class attributes extends \Fyre\Core\Controller {

    function index($product_id) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("attributes"), array());

        $page       = (isset($_GET["page"]))    ? intval($_GET["page"])     : 1;
        $limit      = (isset($_GET["length"]))  ? intval($_GET["length"])   : 5;
        $search     = (isset($_GET["search"]))  ? $_GET["search"]           : null;
        $order      = (isset($_GET["order"]))   ? $_GET["order"]            : "id";
        
        $start      = ($page - 1) * $limit;

        $attributes = $this->dependencies->attributes->getAttributesByProduct($product_id);
        
        if (empty($attributes)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $attributes);
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("attributes"));
        
        // Data handling
        $ids       = $_POST['ids'];                
        $status = $this->dependencies->attributes->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("attributes"));

        if (isset($_POST["categories"]) && is_array($_POST["categories"])) {

            $_POST["categories"] = json_encode($_POST["categories"]);
        }

        // Insert the data
        $status = $this->dependencies->attributes->insert($_POST);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->attributes->single($status["data"]));
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->dependencies(array("attributes"));

        $status = $this->dependencies->attributes->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->attributes->single($id));
        }
        
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function single($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->dependencies(array("attributes"));

        $status = $this->dependencies->attributes->single($id);

        if ($status) {

            $this->response(true, "API REQUEST SUCCESS", $status);
        }
        
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function update() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->dependencies(array("attributes"));

        $status = $this->dependencies->attributes->edit($_POST);

        if ($status['success']) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->attributes->single($_POST['id']));
        }
        
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}
