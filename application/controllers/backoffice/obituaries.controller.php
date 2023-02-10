<?php 

/** 
*   Controller obituaries ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class obituaries extends \Fyre\Core\Controller {

    function index() {

        // Dependencies
        $this->dependencies(array("obituaries"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;  

        $obituaries = $this->dependencies->obituaries->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/obituaries/index", array("obituaries" => $obituaries));
        exit();


        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("obituaries"), array());
        
        // Init obituaries array
        $obituaries = array();
        
        // Pagination
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : null;
        $start      = ($page - 1) * $limit;  
        
        foreach ($app->languages as $language) {
            
            $obituaries[$language["code"]]            = $this->dependencies->obituaries->multiple($language["code"], $start, $limit, $search, $order);
            $total[$language["code"]]["count"]      = $this->dependencies->obituaries->total($language["code"], $search, $order);
            $total[$language["code"]]["pages"]      = ceil($total[$language["code"]]["count"] / $limit);
            $total[$language["code"]]["page"]       = $page;
        }
        
        $this->backoffice("pages/obituaries/index", array("obituaries" => $obituaries, "total" => $total, "query" => http_build_query($_GET)));
    }
    
    function single($id) {

        global $app;
        
        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/obituaries/page");
    }
    
    function insert() {
        
        global $app;
        
        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        $this->backoffice("pages/obituaries/page");
    }
}