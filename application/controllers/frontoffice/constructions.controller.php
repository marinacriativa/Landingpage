<?php

/**
 * Controller main ( Backoffice )
 *
 *   Extends: core/Controller.php
 *   Author: Vlad
 **/

namespace Fyre\Controller;

class constructions extends \Fyre\Core\Controller
{

    function index()
    {

        global $app;

        // Dependencies
        $this->dependencies(array("constructions", "categories_constructions"), array());

        //Filtros
        $limit = 12;
        $page = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $search = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $category = (isset($_GET["category"])) ? $_GET["category"] : null;

        $start = ($page - 1) * $limit;

        // Só produtos marcados como publicados
        $status = 2;

        // Obter produtos
        $constructions = $this->dependencies->constructions->listing($app->selected_language->code, $start, $limit, $search, $order, $status, $category);

        // Obter as categorias
        $categories_constructions = $this->dependencies->categories_constructions->listing($category, $app->select_language);

        // Ultimas novidades
        $latest = $this->dependencies->constructions->listing($app->selected_language->code, 0, 3, null, "id", 2);

        // Paginação
        $total["count"] = $this->dependencies->constructions->total_listing($app->select_language, $search, $status, $category);
        $total["pages"] = ceil($total["count"] / $limit);
        $total["page"] = $page;

        echo $this->template("pages/constructions/index", compact("constructions", "total", "latest", "categories_constructions"));
    }

    function page($slug)
    {

        global $app;

        // Dependencies
        $this->dependencies(array("constructions", "attributes_constructions", "constructions_gallery", "services", "categories_constructions"), array());

        $lang = $app->select_language;
        
        if(isset($_COOKIE['lang'])) { 
            $lang = $_COOKIE['lang'];
        }

        // Obter o produto
        $construction = $this->dependencies->constructions->singleSlug($slug, 1, $lang);

        if (empty($construction)) {

            $app->redirect("/" . $app->select_language . "/constructions");
        }

        // Obter os services
        $services_raw = $this->dependencies->services->multiple($app->select_language);
        $services = array();

        // Obter as categorias
        $categories_raw = $this->dependencies->categories_constructions->multiple();
        $categories = array();

        foreach ($categories_raw as $category) {

            if ($category->lang == $app->select_language) {

                $categories[$category->id] = $category;
            }
        }  

        foreach ($services_raw as $serv) {

            if ($serv->lang == $app->select_language) {

                $services[$serv->id] = $serv;
            }
        }        

        // Obter as imagens
        $gallery = $this->dependencies->constructions_gallery->multiple($construction->id);     

        $categories_constructions = $this->dependencies->categories_constructions->listing($categories, $app->select_language);


         // Obter os atributos
        $attributes = $this->dependencies->attributes_constructions->getAttributesByConstruction($construction->id);  


        // Obter produtos relacionados
        $related = $this->dependencies->constructions->random($construction->id, $app->select_language, 5);

        echo $this->template("pages/constructions/page", compact("construction", "attributes", "services", "gallery", "related", "categories_constructions"));
    }
}