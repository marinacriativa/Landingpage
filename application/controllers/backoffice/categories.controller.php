<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class categories extends \Fyre\Core\Controller {


    function index() {
        // Dependencies
        $this->dependencies(array("categories"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $categories = $this->dependencies->categories->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/categories/index", array("categories" => $categories));
    }

    function categories_constructions() {
        // Dependencies
        $this->dependencies(array("categories_constructions"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $categories_constructions = $this->dependencies->categories_constructions->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/categories/categories_constructions", array("categories_constructions" => $categories_constructions));
    }    

}