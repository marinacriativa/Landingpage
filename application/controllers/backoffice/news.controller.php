<?php 

/** 
*   Controller news ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class news extends \Fyre\Core\Controller {

    function index() {


       // Dependencies
       $this->dependencies(array("news"), array());

       $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
       $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
       $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
       $order      = (isset($_GET["order"])) ? $_GET["order"] : "order_by";
       $start      = ($page - 1) * $limit;  

       $news = $this->dependencies->news->multiple(null, $start, $limit, $search, $order);

       $this->backoffice("pages/news/index", array("news" => $news));
       exit();

       global $app;
        
       // Middleware
       $this->middleware(MIDDLEWARE_ADMIN_ONLY);
       
       // Dependencies
       $this->dependencies(array("news"), array());
       
       // Init products array
       $news = array();
       
       // Pagination
       $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
       $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
       $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
       $order      = (isset($_GET["order"])) ? $_GET["order"] : null;
       $start      = ($page - 1) * $limit;  
       
       foreach ($app->languages as $language) {
           
           $news[$language["code"]]            = $this->dependencies->news->multiple($language["code"], $start, $limit, $search, $order);
           $total[$language["code"]]["count"]      = $this->dependencies->news->total($language["code"], $search, $order);
           $total[$language["code"]]["pages"]      = ceil($total[$language["code"]]["count"] / $limit);
           $total[$language["code"]]["page"]       = $page;
       }
       
       $this->backoffice("pages/news/index", array("news" => $news, "total" => $total, "query" => http_build_query($_GET)));
    }
    
    function add() {
        $this->backoffice("pages/news/page");
        exit();
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array(), array());
        
        $this->backoffice("pages/news/page");
    }
    
    function single($id) {

        global $app;
        
        // Middleware, para permitir apenas administradores
        //$this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/news/page");
    }
    
    function edit() {

        $this->backoffice("pages/news/page");
        exit();
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("news"));
        
        // Data handling
        $data       = $_GET;
        $data["id"] = $id;
        
        // Edit the data
        $status = $this->dependencies->news->edit($data);
        
        // Send json response 
        $this->raw_response($status);
    }
    
    
    function insert() {
        
        global $app;
        
        // Middleware, para permitir apenas administradores
        //$this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        $this->backoffice("pages/news/page");
    }
    
    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("news"));
        
        // Delete the data
        $status = $this->dependencies->news->remove($id);
        
        // Send json response 
        $this->raw_response($status);
    }
    
    function order() {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("news"));
        
        // Order the data
        $status = $this->dependencies->news->order($_REQUEST["ids"]);
        
        // Send json response 
        $this->raw_response($status);
    }

    function coupons() {
        $this->backoffice("pages/coupons/index");
        exit();

    }
}