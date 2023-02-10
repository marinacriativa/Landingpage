<?php 

/** 
*   Controller recruitments ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class recruitments extends \Fyre\Core\Controller {

    function index() {

       // Dependencies
       $this->dependencies(array("recruitments"), array());

       $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
       $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
       $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
       $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
       $start      = ($page - 1) * $limit;  

       $recruitments = $this->dependencies->recruitments->multiple(null, $start, $limit, $search, $order);

       $this->backoffice("pages/recruitments/index", array("recruitments" => $recruitments));
       exit();
    }
    
    function add() {
        $this->backoffice("pages/recruitments/page");
        exit();
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array(), array());
        
        $this->backoffice("pages/recruitments/page");
    }
    
    function single($id) {

        global $app;
        
        // Middleware, para permitir apenas administradores
        //$this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/recruitments/page");
    }
    
    function edit() {

        $this->backoffice("pages/recruitments/page");
        exit();
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("recruitments"));
        
        // Data handling
        $data       = $_GET;
        $data["id"] = $id;
        
        // Edit the data
        $status = $this->dependencies->recruitments->edit($data);
        
        // Send json response 
        $this->raw_response($status);
    }
    
    
    function insert() {
        
        global $app;
        
        // Middleware, para permitir apenas administradores
        //$this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        $this->backoffice("pages/recruitments/page");
    }
    
    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("recruitments"));
        
        // Delete the data
        $status = $this->dependencies->recruitments->remove($id);
        
        // Send json response 
        $this->raw_response($status);
    }
    
    function order() {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("recruitments"));
        
        // Order the data
        $status = $this->dependencies->recruitments->order($_REQUEST["ids"]);
        
        // Send json response 
        $this->raw_response($status);
    }

    function coupons() {
        $this->backoffice("pages/coupons/index");
        exit();

    }
}