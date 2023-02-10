<?php 

/** 
*   Controller constructions ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class constructions extends \Fyre\Core\Controller {

    function index() {

        // Dependencies
        $this->dependencies(array("constructions"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;  

        $constructions = $this->dependencies->constructions->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/constructions/index", array("constructions" => $constructions));
        exit();


        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("constructions"), array());
        
        // Init constructions array
        $constructions = array();
        
        // Pagination
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : null;
        $start      = ($page - 1) * $limit;  
        
        foreach ($app->languages as $language) {
            
            $constructions[$language["code"]]            = $this->dependencies->constructions->multiple($language["code"], $start, $limit, $search, $order);
            $total[$language["code"]]["count"]      = $this->dependencies->constructions->total($language["code"], $search, $order);
            $total[$language["code"]]["pages"]      = ceil($total[$language["code"]]["count"] / $limit);
            $total[$language["code"]]["page"]       = $page;
        }
        
        $this->backoffice("pages/constructions/index", array("constructions" => $constructions, "total" => $total, "query" => http_build_query($_GET)));
    }
    
    function single($id) {

        global $app;
        
        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/constructions/page");
    }
    
    function insert() {
        
        global $app;
        
        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        $this->backoffice("pages/constructions/page");
    }
}