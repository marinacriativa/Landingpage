<?php 

/** 
*   Controller filters ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller; 

class filters extends \Fyre\Core\Controller {

    function index() {

        // Dependencies
        $this->dependencies(array("filters"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;  

        $filters = $this->dependencies->filters->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/filters/index", array("filters" => $filters));
        exit();


        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("filters"), array());

        // Init filters array
        $filters = array();

        // Pagination
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : null;
        $start      = ($page - 1) * $limit;  

        foreach ($app->languages as $language) {

            $filters[$language["code"]]            = $this->dependencies->filters->multiple($language["code"], $start, $limit, $search, $order);
            $total[$language["code"]]["count"]      = $this->dependencies->filters->total($language["code"], $search, $order);
            $total[$language["code"]]["pages"]      = ceil($total[$language["code"]]["count"] / $limit);
            $total[$language["code"]]["page"]       = $page;
        }

        $this->backoffice("pages/filters/index", array("filters" => $filters, "total" => $total, "query" => http_build_query($_GET)));
    }

    function single($id) {

        global $app;

        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/filters/page");
    }

    function insert() {

        global $app;

        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/filters/page");
    }
} 