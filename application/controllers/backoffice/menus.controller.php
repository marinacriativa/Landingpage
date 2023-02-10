<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class menus extends \Fyre\Core\Controller {


    function index() {
        // Dependencies
        $this->dependencies(array("menus"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $menus = $this->dependencies->menus->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/menus/index", array("menus" => $menus));
    }

}