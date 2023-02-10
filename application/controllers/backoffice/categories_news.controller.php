<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class categories_news extends \Fyre\Core\Controller {


    function index() {
        // Dependencies
        $this->dependencies(array("categories_news"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $categories_news = $this->dependencies->categories_news->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/categories/categories_news", array("categories_news" => $categories_news));
    }

}