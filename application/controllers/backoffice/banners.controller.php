<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class banners extends \Fyre\Core\Controller {


    function index() {

        global $app;

        // Dependencies
        $this->dependencies(array("banners"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 50;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $lang       = (isset($_GET["lang"]) && !empty($_GET["lang"])) ? $_GET["lang"] : $app->default_language->code;
        $start      = ($page - 1) * $limit;

        $banners = $this->dependencies->banners->multiple($lang, $start, $limit, $search, $order);

        $this->backoffice("pages/banners/index", array("banners" => $banners));
    }

}