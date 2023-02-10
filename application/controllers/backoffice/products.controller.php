<?php 

/** 
*   Controller products ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class products extends \Fyre\Core\Controller {

    function index() {

        // Dependencies
        $this->dependencies(array("products"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $category   = (isset($_GET["category"])) ? $_GET["category"] : '';
        $start      = ($page - 1) * $limit;  

        $products = $this->dependencies->products->multiple(null, $start, $limit, $search, $order, $category);

        $this->backoffice("pages/products/index", array("products" => $products));   
    }
    
    function single($id) {

        $this->dependencies(array("filters", "filter_items", "products"), array());

        global $app;
        
        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $filters = $this->dependencies->filters->multiple();

        $product = $this->dependencies->products->single($id);

        foreach ($filters as $filter) {
            $filter->items = $this->dependencies->filter_items->multiple($filter->id);
        }

        $this->backoffice("pages/products/page", compact('filters', 'product'));
    }
    
    function insert() {
        
        global $app;
        
        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        $this->backoffice("pages/products/page");
    }
}