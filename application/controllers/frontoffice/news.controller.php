<?php 

/** 
* Controller main ( Backoffice ) 
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class news extends \Fyre\Core\Controller {
    
    function index() {
        
        global $app;
        
        // Dependencies
        $this->dependencies(array("news", "categories_news"), array());

        //Filtros
        $limit      = 12;
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : null;
        $category   = (isset($_GET["category"])) ? $_GET["category"] : null;

        $start = ($page - 1) * $limit;
        $status = 2;

        /* TODO PAGINAÇÃO */
        $news = $this->dependencies->news->listing($app->selected_language->code, $start, $limit, $search, $order, $status, $category);
        $categories_news = $this->dependencies->categories_news->listing(null, $app->selected_language->code);

        // Paginação
        $total["count"] = $this->dependencies->news->total_listing($app->select_language, $search, $status, $category);
        $total["pages"] = ceil($total["count"] / $limit);
        $total["page"] = $page;
        
        echo $this->template("pages/news/index", compact("news", "total", "categories_news"));
    }

    function search() {
        
        global $app;
        
        // Dependencies
        $this->dependencies(array("news", "pages", "categories_news"), array());

        //Filtros
        $limit      = 12;
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;

        $start = ($page - 1) * $limit;
        $status = 2;

        $resultSearch = [];

        /* TODO PAGINAÇÃO */
        $news = $this->dependencies->news->listingAll($app->selected_language->code, $start, $limit, $search, null, $status);
        $pages = $this->dependencies->pages->listingAll($app->selected_language->code, $start, $limit, $search, null, $status);
        
        $newsTotal = $this->dependencies->news->total_listing($app->selected_language->code, $search, $status, null);
        $pagesTotal = $this->dependencies->pages->total($app->selected_language->code, $search);
      
        
       
        foreach ($news as $key => $new) {
            $result['title'] = $new->title;
            $result['description'] = $new->resume;
            $result['slug'] = '/' . $app->selected_language->code . '/news/' . $new->id;
            $resultSearch[] = $result;
        }
   

        foreach ($pages as $key => $pag) {      
            $result['title'] = $pag->name;
            $result['description'] = $pag->keywords;
            $result['slug'] = '/' . $app->selected_language->code . '/pages/' . $pag->url;
            $resultSearch[] = $result;
        }      

        // Paginação
        $total["count"] = strval(max($pagesTotal, $newsTotal));
        $total["pages"] = ceil($total["count"] / $limit);
        $total["page"] = $page;
   
        echo $this->template("pages/search/index", compact("resultSearch", "total"));
    }


    function searchAjax() {
        
        global $app;
        
        // Dependencies
        $this->dependencies(array("news", "pages", "categories_news"), array());

        //Filtros
        $limit      = 3;
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;

        $start = ($page - 1) * $limit;
        $status = 2;

        $resultSearch = [];

        /* TODO PAGINAÇÃO */
        $news = $this->dependencies->news->listingAll($app->selected_language->code, $start, $limit, $search, null, $status);
        $pages = $this->dependencies->pages->listingAll($app->selected_language->code, $start, $limit, $search, null, $status);
        
       
        foreach ($news as $key => $new) {
            $result['title'] = $new->title;
            $result['description'] = $new->resume;
            $result['slug'] = '/' . $app->selected_language->code . '/news/' . $new->id;
            $resultSearch[] = $result;
        }
   

        foreach ($pages as $key => $pag) {      
            $result['title'] = $pag->name;
            $result['description'] = $pag->keywords;
            $result['slug'] = '/' . $app->selected_language->code . '/pages/' . $pag->url;
            $resultSearch[] = $result;
        }      
   
       
        $this->response(true, "API REQUEST SUCCESS", $resultSearch);
    }
    
    function page($id) {
        
        global $app;
        
        // Dependencies
        $this->dependencies(array("news", "news_gallery", "categories_news"), array());
        
        $lang = $app->select_language;
        
        if(isset($_COOKIE['lang'])) { 
            $lang = $_COOKIE['lang'];
        }
        
        // Obter a noticia
        $new = $this->dependencies->news->single($id, $lang);
        $categories_news = $this->dependencies->categories_news->listing(null, $lang);

        // Obter as imagens
        $gallery_img = $this->dependencies->news_gallery->multiple($new->id);
        
        if (empty($new)) {
            
            $app->redirect("/news");
        }
        
        echo $this->template("pages/news/page", compact("new", "gallery_img", "categories_news"));
    }
}