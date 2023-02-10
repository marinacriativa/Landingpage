<?php 

/** 
*   Controller settings ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class config extends \Fyre\Core\Controller {

    function index() {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/config/index");
    }
    
    function update($setting) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("config"));
        
        // Data handling
        if (!isset($_GET["value"])) {
            
            $this->response(false, $app->translations["common"]["redirected"]);
        }
        
        // Edit the data
        $status = $this->dependencies->config->edit_keys($setting, $_GET["value"]);
        
        // Send json response 
        $this->raw_response($status);
    }
}