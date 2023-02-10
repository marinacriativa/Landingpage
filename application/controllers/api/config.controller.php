<?php

/**
 *   Controller config ( API )
 *
 *   Extends: core/Controller.php
 *   Author: Vlad
 **/

namespace Fyre\Controller;

class config extends \Fyre\Core\Controller
{

    function multiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // As configurações já foram carregadas em /application/core/application.php

        $this->response(true, "API REQUEST SUCCESS", $app->config);
    }

    function update($setting) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("config"));
        
        // Data handling
        if (!isset($_GET["value"])) {
            
            $this->response(false, "API REQUEST ERROR");
        }
        
        // Edit the data
        $status = $this->dependencies->config->edit_keys($setting, $_GET["value"]);
        
        // Send json response 
        $this->raw_response($status);
    }
}