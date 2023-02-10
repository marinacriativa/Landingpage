<?php

/**
 * Controller main ( Backoffice )
 *
 *   Extends: core/Controller.php
 *   Author: Vlad
 **/

namespace Fyre\Controller;

class galleries extends \Fyre\Core\Controller
{

    function index()
    {

        global $app;

        // Dependencies
        $this->dependencies(array("galleries", "categories_galleries"), array());

        //Filtros
        $limit = 12;
        $page = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $search = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order = (isset($_GET["order"])) ? $_GET["order"] : null;
        $category = (isset($_GET["category"])) ? $_GET["category"] : null;

        $start = ($page - 1) * $limit;

        // Só produtos marcados como publicados
        $status = 2;

        // Obter produtos
        $galleries = $this->dependencies->galleries->listing($app->selected_language->code, $start, $limit, $search, $order, $status, $category);

        // Obter as categorias
        $categories_g = $this->dependencies->categories_galleries->listing($category, $app->select_language);
        // Ultimas novidades
        $latest = $this->dependencies->galleries->listing($app->selected_language->code, 0, 3, null, "id", 2);

        // Paginação
        $total["count"] = $this->dependencies->galleries->total_listing($app->select_language, $search, $status, $category);
        $total["pages"] = ceil($total["count"] / $limit);
        $total["page"] = $page;

        echo $this->template("pages/galleries/index", compact("galleries", "total", "latest", "categories_g"));
    }

    function page($slug)
    {

        global $app;

        // Dependencies
        $this->dependencies(array("galleries", "attributes", "categories_galleries", "galleries_gallery", "personalization", "discounts", "advanced_galleries"), array());

        // Obter o produto
        $gallery = $this->dependencies->galleries->singleSlug($slug, 1);

        if (empty($gallery)) {

            $app->redirect("/" . $app->select_language . "/galleries");
        }

        // Obter as categorias
        $categories_raw = $this->dependencies->categories_galleries->multiple();
        $categories = array();

        foreach ($categories_raw as $category) {

            if ($category->lang == $app->select_language) {

                $categories[$category->id] = $category;
            }
        }

        // Obter os atributos do produto
        $attributes = $this->dependencies->attributes->getAttributesByProduct($gallery->id);

        // Obter descontos por quantidade
        $discounts = $this->dependencies->discounts->getDiscountByProduct($gallery->id);

        // Obter produto composto ou avançado
        $gallery_type = array();
        $galleriesAdvanced = array();

        // Obter as imagens
        $gallery_img = $this->dependencies->galleries_gallery->multiple($gallery->id);

        if ($gallery->type == "1") {

            // Produto composto
            $galleriesAdvanced = $this->dependencies->advanced_galleries->advancedProductsByProduct($gallery->id);
            foreach ($galleriesAdvanced as $galleryAdvanced) {
                $imagesId = explode(",", $galleryAdvanced->gallery);

                $filteredGallery = array_filter($gallery, function ($image) use ($imagesId) {
                    return in_array($image->id, $imagesId);
                });

                $galleryAdvanced->gallery = $filteredGallery;
            }

        } elseif ($gallery->type == "2" && isset($gallery->personalizationGroup)) {

            // Produto personalizado
            $gallery_type = $this->dependencies->personalization->productsPersonalization(explode(",", $gallery->personalizationGroup));
        }

        // Obter produtos relacionados
        $related = $this->dependencies->galleries->random($gallery->id, $app->select_language, 5);

        echo $this->template("pages/galleries/page", compact("gallery", "attributes", "categories", "discounts", "gallery_img", "gallery_type", "related", 'galleriesAdvanced'));
    }
}