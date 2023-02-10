<?php 

/** 
* Controller main ( Backoffice ) 
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class recruitments extends \Fyre\Core\Controller {
    
    function index() {
        
        global $app;
        
        // Dependencies
        $this->dependencies(array("recruitments"), array());

        /* TODO PAGINAÇÃO */
        $recruitments = $this->dependencies->recruitments->listing($app->selected_language->code, 0, 1000);
        
        echo $this->template("pages/recruitments/index", compact("recruitments"));
    }
    
    function page($id) {
        
        global $app;
        
        // Dependencies
        $this->dependencies(array("recruitments"), array());
        
        // Obter a noticia
        $recruitment = $this->dependencies->recruitments->single($id);
        $recruitments = $this->dependencies->recruitments->listing($app->selected_language->code, 0, 1000);
        
        if (empty($recruitment)) {
            
            $app->redirect("/recruitments");
        }
        
        echo $this->template("pages/recruitments/page", compact("recruitment", "recruitments"));
    }
}