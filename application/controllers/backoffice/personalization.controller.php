<?php 

/** 
*   Controller products ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class personalization extends \Fyre\Core\Controller {

    function index() {

        // Dependencies
        $this->dependencies(array("personalization"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;  

        $personalization = $this->dependencies->personalization->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/personalization/index", array("personalization" => $personalization));
        exit();


        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("products"), array());
        
        // Init products array
        $products = array();
        
        // Pagination
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : null;
        $start      = ($page - 1) * $limit;  
        
        foreach ($app->languages as $language) {
            
            $products[$language["code"]]            = $this->dependencies->products->multiple($language["code"], $start, $limit, $search, $order);
            $total[$language["code"]]["count"]      = $this->dependencies->products->total($language["code"], $search, $order);
            $total[$language["code"]]["pages"]      = ceil($total[$language["code"]]["count"] / $limit);
            $total[$language["code"]]["page"]       = $page;
        }
        
        $this->backoffice("pages/products/index", array("products" => $products, "total" => $total, "query" => http_build_query($_GET)));
    }
    
    function single($id) {

        global $app;
        
        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/personalization/page");
    }
    
    function insert() {
        
        global $app;
        
        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        $this->backoffice("pages/products/page");
    }
}