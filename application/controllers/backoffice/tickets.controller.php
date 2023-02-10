<?php 

/** 
*   Controller services ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class tickets extends \Fyre\Core\Controller {

    function index() {

        // Dependencies
        $this->dependencies(array("tickets"), array());

        $page = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start = ($page - 1) * $limit;

        $ticket = $this->dependencies->tickets->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/tickets/index", array("tickets" => $ticket));

    }
    
    function show() {
        
        $this->backoffice("pages/tickets/show");
        exit();
    }
    

}
