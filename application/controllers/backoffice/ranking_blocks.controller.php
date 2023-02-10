<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class ranking_blocks extends \Fyre\Core\Controller {

    function index() {

        global $app;        

        $lang       = (isset($_GET["lang"]) && !empty($_GET["lang"])) ? $_GET["lang"] : $app->default_language->code;
                
        // Dependencies
        $this->dependencies(array("ranking_blocks"), array());

        $ranking_blocks = $this->dependencies->ranking_blocks->listing($lang);

        $this->backoffice("pages/ranking_blocks/index", array("ranking_blocks" => $ranking_blocks));
    }

    function single($id) {

        global $app;
        
        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/ranking_blocks/page");
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("ranking_blocks"));

        // Data handling
        $data       = $_GET;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->ranking_blocks->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->ranking_blocks->single($id));
    }
}