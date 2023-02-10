<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class coupons extends \Fyre\Core\Controller {


    function index() {
        // Dependencies
        $this->dependencies(array("coupons"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $coupons = $this->dependencies->coupons->multiple($start, $limit, $search, $order);

        $this->backoffice("pages/coupons/index", array("coupons" => $coupons));
    }

}