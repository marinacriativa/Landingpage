<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class orders extends \Fyre\Core\Controller {

    function index() {

        // Dependencies
        $this->dependencies(array("orders"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $orders = $this->dependencies->orders->multiple(null, $start, $limit, $search, $order);

            $this->backoffice("pages/orders/index", array("orders" => $orders));


    }
    
    function show() {
        
        
        $this->backoffice("pages/orders/show");
        exit();
    }
    function order() {
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("orders"));
        
        // Order the data
        $status = $this->dependencies->orders->order($_REQUEST["ids"]);
        
        // Send json response 
        $this->raw_response($status);
    }
}