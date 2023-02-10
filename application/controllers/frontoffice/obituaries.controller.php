<?php

/**
 * Controller main ( Backoffice )
 *
 *   Extends: core/Controller.php
 *   Author: Vlad
 **/

namespace Fyre\Controller;

class obituaries extends \Fyre\Core\Controller
{

    function index()
    {

        global $app;

        // Dependencies
        $this->dependencies(array("obituaries"), array());

        //Filtros
        $limit = 32;
        $page = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $search = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order = (isset($_GET["order"])) ? $_GET["order"] : "id";

        $start = ($page - 1) * $limit;

        // Só produtos marcados como publicados
        $status = 2;

        // Obter produtos
        $obituaries = $this->dependencies->obituaries->listing($app->selected_language->code, $start, $limit, $search, $order, $status);

        // Ultimas novidades
        $latest = $this->dependencies->obituaries->listing($app->selected_language->code, 0, 3, null, "id", 2);

        // Paginação
        $total["count"] = $this->dependencies->obituaries->total_listing($app->select_language, $search, $status);
        $total["pages"] = ceil($total["count"] / $limit);
        $total["page"] = $page;

        echo $this->template("pages/obituaries/index", compact("obituaries", "total", "latest"));
    }

    function page($slug)
    {

        global $app;

        // Dependencies
        $this->dependencies(array("obituaries", "products"), array());

        $lang = $app->select_language;
        
        if(isset($_COOKIE['lang'])) { 
            $lang = $_COOKIE['lang'];
        }

        // Obter o obituário
        $obituary = $this->dependencies->obituaries->singleSlug($slug, 1, $lang);

        $products = $this->dependencies->products->multiple($app->selected_language->code); 

        if (empty($obituary)) {

            $app->redirect("/" . $app->select_language . "/obituaries");
        }     

        echo $this->template("pages/obituaries/page", compact("obituary", "products"));
    }
}