<?php

/**
 * Controller main ( Backoffice )
 *
 *   Extends: core/Controller.php
 *   Author: Vlad
 **/

namespace Fyre\Controller;

class products extends \Fyre\Core\Controller
{

    function index()
    {

        global $app;

        // Dependencies
        $this->dependencies(array("products", "filters", "filter_items", "categories", "brands"), array());

        //Filtros
        $limit      = 12;
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : null;
        $category   = (isset($_GET["category"])) ? $_GET["category"] : null;
        $filter     = (isset($_GET["filter"])) ? $_GET["filter"] : null;
        $brand      = (isset($_GET["brand"])) ? $_GET["brand"] : null;

        $start = ($page - 1) * $limit;

        // Só produtos marcados como publicados
        $status = 2;

        $filters            = $this->dependencies->filters->listing($app->select_language);
        $selected_filters   = [];
        $storedFilters      = $filters;

        $filters_model = [];
        foreach ($_GET as $key => $value) {

            if (strpos($key, 'filter-') !== false) {

                $filterId = str_replace('filter-', '', $key);

                foreach ($storedFilters as $storedFilter) {

                    if ($storedFilter->id == $filterId) {
                        $filters_model[] = ['id' => $storedFilter->id, 'is_multiple' => $storedFilter->is_multiple, 'values' => $value];
                    }

                    foreach (explode(',', $value) as $v) {
                        $selected_filters[] = $v;
                    }
                }
            }
        }

        

        // Obter produtos
        $products = $this->dependencies->products->listing($app->selected_language->code, $start, $limit, $search, $order, $status, $category, $brand, $filters_model);        
       
        foreach($products as $k => $p) {
            $arr = explode(",", $p->brands);       
            foreach($arr as  $b) {             
                
                $p->brandsProduct[] = $this->dependencies->brands->single($b);
            }       
        }
        // Obter as categorias
        $categories = $this->dependencies->categories->listing($category, $app->select_language);

        // Obter filtros
        $all_filters    = [];  
        foreach ($filters as $filter) {
            $filter->items   = $this->dependencies->filter_items->listing($filter->id);
            foreach ($filter->items as $item) {
                $all_filters[] = $item;
            }
        }

        // Obter as marcas
        $brands = $this->dependencies->brands->multiple();
        

        // Ultimas novidades
        $latest = $this->dependencies->products->listing($app->selected_language->code, 0, 3, null, "id", 2);

        // Paginação
        $total["count"] = $this->dependencies->products->total_listing($app->select_language, $search, $status, $category, $brand, $filters_model);
        $total["pages"] = ceil($total["count"] / $limit);
        $total["page"] = $page;

        $selected_filters = array_unique($selected_filters);

        echo $this->template("pages/products/index", compact("products", "all_filters", "filters", "total", "latest", "brands", "categories", "selected_filters"));
    }

    function page($slug)
    {
        global $app;

        // Dependencies
        $this->dependencies(array("products", "attributes", "categories", "filter_items", "products_gallery", "personalization", "discounts", "brands", "advanced_products"), array());

        $lang = $app->select_language;
        
        if(isset($_COOKIE['lang'])) { 
            $lang = $_COOKIE['lang'];
        }

        // Obter o produto
        $product = $this->dependencies->products->singleSlug($slug, 1, $lang);

        if (empty($product)) {

            $app->redirect("/" . $app->select_language . "/products");
        }            

        // Obter as categorias
        $categories_raw = $this->dependencies->categories->multiple(); 
        $categories = array();

        foreach ($categories_raw as $category) {

            if ($category->lang == $app->select_language) {

                $categories[$category->id] = $category;
            }
        } 

        // Obter os filtros
        $filters_raw = $this->dependencies->filter_items->all(); 
        $filters = array();

        foreach ($filters_raw as $filter) {

                $filters[$filter->id] = $filter;
        } 
        
        // Obter as marcas
        $brands = $this->dependencies->brands->multiple();

        $brand = explode(",", $product->brands);       
        foreach($brand as  $b) {             
            
            $product->productBrands[] = $this->dependencies->brands->single($b);
        } 

        // Obter os atributos do produto
        $attributes = $this->dependencies->attributes->getAttributesByProduct($product->id);

        // Obter descontos por quantidade
        $discounts = $this->dependencies->discounts->getDiscountByProduct($product->id);

        // Obter produto composto ou avançado
        $product_type = array();
        $productsAdvanced = array();

        // Obter as imagens
        $gallery = $this->dependencies->products_gallery->multiple($product->id);

        if ($product->type == "1") {

            // Produto composto
            $productsAdvanced = $this->dependencies->advanced_products->advancedProductsByProduct($product->id);
            foreach ($productsAdvanced as $productAdvanced) {
                $imagesId = explode(",", $productAdvanced->gallery);

                $filteredGallery = array_filter($gallery, function ($image) use ($imagesId) {
                    return in_array($image->id, $imagesId);
                });

                $productAdvanced->gallery = $filteredGallery;
            }

        } elseif ($product->type == "2" && isset($product->personalizationGroup)) {

            // Produto personalizado
            $product_type = $this->dependencies->personalization->productsPersonalization(explode(",", $product->personalizationGroup));
        }

        // Obter produtos relacionados
        $related = $this->dependencies->products->random($product->id, $app->select_language, 5);

        echo $this->template("pages/products/page", compact("product", "productsAdvanced", "attributes", "categories", "filters", "discounts", "gallery", "product_type", "related", "brands", 'productsAdvanced'));
    }
}