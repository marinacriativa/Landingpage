<?php

/**
 *   Controller sitemap ( Backoffice )
 *
 *   Extends: core/Controller.php
 *   Author: Vlad
 **/

namespace Fyre\Controller;
use Jenssegers\Blade\Blade;

class sitemap extends \Fyre\Core\Controller
{

    function generator()
    {

        global $app;
        
        $this->dependencies(array("products", "news", "pages", "constructions"));      

        try {
            $pages = $this->dependencies->pages->all(2, $app->default_language->code);
        } catch (\Throwable $th) {
            $pages = [];
        }
        try {
            $products = $this->dependencies->products->all(2, $app->default_language->code);
        } catch (\Throwable $th) {
            $products = [];
        }
        try {
            $news = $this->dependencies->news->all(2, $app->default_language->code);
        } catch (\Throwable $th) {
            $news = [];
        }
        try {
            $constructions = $this->dependencies->constructions->all(2, $app->default_language->code);
        } catch (\Throwable $th) {
            $constructions = [];
        }
      
        $front_pages = false;
        
        if(isset($_POST)) {
            $front_pages = $_POST;
        }

        if(!empty($pages)) { 
            foreach($pages as $p) {               
                $p->related = $this->dependencies->pages->getAllRelated($p->language_group, $p->id);
            }
        }

        if(!empty($products)) { 
            foreach($products as $p) {               
                $p->related = $this->dependencies->products->getAllRelated($p->language_group, $p->id);
            }
        }

        if(!empty($news)) { 
            foreach($news as $p) {               
                $p->related = $this->dependencies->news->getAllRelated($p->language_group, $p->id);
            }
        }
        if(!empty($constructions)) { 
            foreach($constructions as $p) {               
                $p->related = $this->dependencies->constructions->getAllRelated($p->language_group, $p->id);
            }
        }

        $allPages = [$products, $news, $pages, $front_pages];
        $blade  = new Blade(APP . "templates/backoffice", APP . "templates/cache/");
        $sitemapRendered = $blade->render('layouts.sitemap',compact('products', 'news', 'pages', 'constructions', 'front_pages'));

        file_put_contents(ROOT . "public/sitemap.xml", $sitemapRendered);

      
        $this->response(true, "API REQUEST SUCCESS");

    }

    function sitemapCron () {

        $this->generator();
        
    }

}