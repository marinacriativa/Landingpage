<?php 

/** 
* Controller main ( Backoffice ) 
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class jobs extends \Fyre\Core\Controller {
    
    function index() {
        
        global $app;
        
        // Dependencies
        $this->dependencies(array("jobs", "categories_jobs"), array());

        //Filtros
        $limit      = 3;
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : null;
        $category   = (isset($_GET["category"])) ? $_GET["category"] : null;

        $start = ($page - 1) * $limit;
   

        /* TODO PAGINAÇÃO */
        $jobs = $this->dependencies->jobs->listing($app->selected_language->code, $start, $limit, $search, $order, '', $category);
        $categories_jobs = $this->dependencies->categories_jobs->listing(null, $app->selected_language->code);

        // Paginação
        $total["count"] = $this->dependencies->jobs->total_listing($app->select_language, $search, '', $category);
        $total["pages"] = ceil($total["count"] / $limit);
        $total["page"] = $page;
        
        echo $this->template("pages/jobs/index", compact("jobs", "total", "categories_jobs"));
    }

    function search() {
        
        global $app;
        
        // Dependencies
        $this->dependencies(array("jobs", "pages", "categories_jobs"), array());

        //Filtros
        $limit      = 12;
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;

        $start = ($page - 1) * $limit;
        $status = 2;

        $resultSearch = [];

        /* TODO PAGINAÇÃO */
        $jobs = $this->dependencies->jobs->listingAll($app->selected_language->code, $start, $limit, $search, null, $status);
        $pages = $this->dependencies->pages->listingAll($app->selected_language->code, $start, $limit, $search, null, $status);
        
        $jobsTotal = $this->dependencies->jobs->total_listing($app->selected_language->code, $search, $status, null);
        $pagesTotal = $this->dependencies->pages->total($app->selected_language->code, $search);
      
        
       
        foreach ($jobs as $key => $new) {
            $result['title'] = $new->title;
            $result['description'] = $new->resume;
            $result['slug'] = '/' . $app->selected_language->code . '/jobs/' . $new->id;
            $resultSearch[] = $result;
        }
   

        foreach ($pages as $key => $pag) {      
            $result['title'] = $pag->name;
            $result['description'] = $pag->keywords;
            $result['slug'] = '/' . $app->selected_language->code . '/pages/' . $pag->url;
            $resultSearch[] = $result;
        }      

        // Paginação
        $total["count"] = strval(max($pagesTotal, $jobsTotal));
        $total["pages"] = ceil($total["count"] / $limit);
        $total["page"] = $page;
   
        echo $this->template("pages/search/index", compact("resultSearch", "total"));
    }


    function searchAjax() {
        
        global $app;
        
        // Dependencies
        $this->dependencies(array("jobs", "pages", "categories_jobs"), array());

        //Filtros
        $limit      = 3;
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;

        $start = ($page - 1) * $limit;
        $status = 2;

        $resultSearch = [];

        /* TODO PAGINAÇÃO */
        $jobs = $this->dependencies->jobs->listingAll($app->selected_language->code, $start, $limit, $search, null, $status);
        $pages = $this->dependencies->pages->listingAll($app->selected_language->code, $start, $limit, $search, null, $status);
        
       
        foreach ($jobs as $key => $job) {
            $result['name'] = $job->name;
            $result['description'] = $job->description;
            $result['slug'] = '/' . $app->selected_language->code . '/jobs/' . $job->slug;
            $resultSearch[] = $result;
        }
   
       
        $this->response(true, "API REQUEST SUCCESS", $resultSearch);
    }
    
    function page($id) {
        
        global $app;
        
        // Dependencies
        $this->dependencies(array("jobs", "jobs_gallery", "categories_jobs"), array());
        
        $lang = $app->select_language;
        
        if(isset($_COOKIE['lang'])) { 
            $lang = $_COOKIE['lang'];
        }
        
        // Obter a noticia
        $new = $this->dependencies->jobs->single($id, $lang);
        $categories_jobs = $this->dependencies->categories_jobs->listing(null, $lang);

        // Obter as imagens
        $gallery_img = $this->dependencies->jobs_gallery->multiple($new->id);
        
        if (empty($new)) {
            
            $app->redirect("/jobs");
        }
        
        echo $this->template("pages/jobs/page", compact("new", "gallery_img", "categories_jobs"));
    }
}