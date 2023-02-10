<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class testimonies extends \Fyre\Core\Controller {

    function index() {
        // Dependencies
        $this->dependencies(array("testimonies"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $testimonies = $this->dependencies->testimonies->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/testimonies/index", array("testimonies" => $testimonies));
        exit();

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("testimonies"), array());
        
        // Init products array
        $testimonies = array();
        
        // Pagination
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : null;
        $start      = ($page - 1) * $limit;  
        
        foreach ($app->languages as $language) {
            
            $testimonies[$language["code"]]            = $this->dependencies->testimonies->multiple($language["code"], $start, $limit, $search, $order);
            $total[$language["code"]]["count"]      = $this->dependencies->testimonies->total($language["code"], $search, $order);
            $total[$language["code"]]["pages"]      = ceil($total[$language["code"]]["count"] / $limit);
            $total[$language["code"]]["page"]       = $page;
        }
        
        $this->backoffice("pages/testimonies/index", array("testimonies" => $testimonies, "total" => $total, "query" => http_build_query($_GET)));
    }

    function single($id) {

        global $app;
        
        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/testimonies/page");
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("testimonies"));

        // Data handling
        $data       = $_GET;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->testimonies->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->testimonies->single($id));
    }
}