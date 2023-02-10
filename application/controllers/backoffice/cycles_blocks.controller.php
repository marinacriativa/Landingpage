<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class cycles_blocks extends \Fyre\Core\Controller {

    function index() {

        global $app;        

        $lang       = (isset($_GET["lang"]) && !empty($_GET["lang"])) ? $_GET["lang"] : $app->default_language->code;
                
        // Dependencies
        $this->dependencies(array("cycles_blocks"), array());

        $cycles_blocks = $this->dependencies->cycles_blocks->listing($lang);

        $this->backoffice("pages/cycles_blocks/index", array("cycles_blocks" => $cycles_blocks));
    }

    function single($id) {

        global $app;
        
        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/cycles_blocks/page");
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("cycles_blocks"));

        // Data handling
        $data       = $_GET;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->cycles_blocks->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->cycles_blocks->single($id));
    }
}