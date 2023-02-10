<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class schedule extends \Fyre\Core\Controller {

    function index() {

        // Dependencies
        $this->dependencies(array("schedule"));

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "order_by";
        $start      = ($page - 1) * $limit;

        $schedule = $this->dependencies->schedule->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/schedule/index", array("schedule" => $schedule));

    }
    

    function single($id) {

        $this->dependencies(array("schedule"));

        global $app;
        
        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $schedule = $this->dependencies->schedule->single($id);

        $this->backoffice("pages/schedule/page", compact('schedule'));
    }

}