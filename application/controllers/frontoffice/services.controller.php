<?php 

/** 
* Controller service ( Backoffice ) 
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class services extends \Fyre\Core\Controller {
    
    function index($slug) {
        
        global $app;
        
        // Dependencies
        $this->dependencies(array("services", "constructions"));
        
        $service = $this->dependencies->services->singleSlug($slug, 1);

        if (empty($service)) {
            
            $app->redirect("/" . $app->select_language . "/");
        }
        
        $works = $this->dependencies->constructions->getServices($app->selected_language->code, 1, $service->id);
        
        echo $this->template("pages/constructions/index", compact("service", "works"));
    }       
}