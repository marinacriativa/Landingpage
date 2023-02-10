<?php 

/** 
*   Controller graph ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class graph extends \Fyre\Core\Controller {

    function sales() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("views"), array());

        $data = $this->dependencies->views->getMonthlySales();

        $this->response(true, "API REQUEST SUCCESS", $data);
    }
    
    function views() {
        
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("views"), array());

        $data = $this->dependencies->views->getMonthlyVisits();

        $this->response(true, "API REQUEST SUCCESS", $data);
    }
}