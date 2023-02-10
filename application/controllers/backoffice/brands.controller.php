<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class brands extends \Fyre\Core\Controller {


    function index() {
        // Dependencies
        $this->dependencies(array("brands"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 150;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "display_order";
        $start      = ($page - 1) * $limit;
        
        $brands = $this->dependencies->brands->multiple($start, $limit, $search, $order);

        $this->backoffice("pages/brands/index", array("brands" => $brands));
    }

    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("brands"));
        
        // Delete the data
        $status = $this->dependencies->brands->remove($id);
        
        // Send json response 
        $this->raw_response($status);
    }

}