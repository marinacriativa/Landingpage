<?php 

/** 
* Controller newsletter ( Backoffice ) 
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class newsletter extends \Fyre\Core\Controller {
    
    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        echo $this->backoffice("pages/newsletter/index");
    }
    function datatable() {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("newsletter"), array());
        
        $columns = array( 
            "newsletter.email",
            "newsletter.name",
            "newsletter.ip",
            "newsletter.date",
            "newsletter.id",
		);
        
        $this->dependencies->newsletter->datatable($columns);
    }
    function insert() {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("newsletter"), array());
        
        $status = $this->dependencies->newsletter->insert($_GET);
        
        $this->raw_response($status);
    }
}