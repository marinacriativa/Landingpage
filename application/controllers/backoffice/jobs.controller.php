<?php 

/** 
*   Controller jobs ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller; 

class jobs extends \Fyre\Core\Controller {

    function index() {

        // Dependencies
        $this->dependencies(array("jobs"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;  

        $jobs = $this->dependencies->jobs->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/jobs/index", array("jobs" => $jobs));
        exit();


        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("jobs"), array());

        // Init jobs array
        $jobs = array();

        // Pagination
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : null;
        $start      = ($page - 1) * $limit;  

        foreach ($app->languages as $language) {

            $jobs[$language["code"]]            = $this->dependencies->jobs->multiple($language["code"], $start, $limit, $search, $order);
            $total[$language["code"]]["count"]      = $this->dependencies->jobs->total($language["code"], $search, $order);
            $total[$language["code"]]["pages"]      = ceil($total[$language["code"]]["count"] / $limit);
            $total[$language["code"]]["page"]       = $page;
        }

        $this->backoffice("pages/jobs/index", array("jobs" => $jobs, "total" => $total, "query" => http_build_query($_GET)));
    }

    function single($id) {

        global $app;

        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/jobs/page");
    }

    function insert() {

        global $app;

        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/jobs/page");
    }
} 