<?php 

/** 
*   Controller custom_page ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller; 

class custom_page extends \Fyre\Core\Controller {

    function index() {

        // Dependencies
        $this->dependencies(array("custom_page"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;  

        $custom_page = $this->dependencies->custom_page->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/custom_page/index", array("custom_page" => $custom_page));
        exit();


        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("custom_page"), array());

        // Init custom_page array
        $custom_page = array();

        // Pagination
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : null;
        $start      = ($page - 1) * $limit;  

        foreach ($app->languages as $language) {

            $custom_page[$language["code"]]            = $this->dependencies->custom_page->multiple($language["code"], $start, $limit, $search, $order);
            $total[$language["code"]]["count"]      = $this->dependencies->custom_page->total($language["code"], $search, $order);
            $total[$language["code"]]["pages"]      = ceil($total[$language["code"]]["count"] / $limit);
            $total[$language["code"]]["page"]       = $page;
        }

        $this->backoffice("pages/custom_page/index", array("custom_page" => $custom_page, "total" => $total, "query" => http_build_query($_GET)));
    }

    function single($id) {

        global $app;

        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/custom_page/page");
    }

    function insert() {

        global $app;

        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/custom_page/page");
    }
} 