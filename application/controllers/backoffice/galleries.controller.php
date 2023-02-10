<?php 

/** 
*   Controller galleries ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller; 

class galleries extends \Fyre\Core\Controller {

    function index() {

        // Dependencies
        $this->dependencies(array("galleries"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;  

        $galleries = $this->dependencies->galleries->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/galleries/index", array("galleries" => $galleries));
        exit();


        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("galleries"), array());

        // Init galleries array
        $galleries = array();

        // Pagination
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : null;
        $start      = ($page - 1) * $limit;  

        foreach ($app->languages as $language) {

            $galleries[$language["code"]]            = $this->dependencies->galleries->multiple($language["code"], $start, $limit, $search, $order);
            $total[$language["code"]]["count"]      = $this->dependencies->galleries->total($language["code"], $search, $order);
            $total[$language["code"]]["pages"]      = ceil($total[$language["code"]]["count"] / $limit);
            $total[$language["code"]]["page"]       = $page;
        }

        $this->backoffice("pages/galleries/index", array("galleries" => $galleries, "total" => $total, "query" => http_build_query($_GET)));
    }

    function single($id) {

        global $app;

        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/galleries/page");
    }

    function insert() {

        global $app;

        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/galleries/page");
    }
} 