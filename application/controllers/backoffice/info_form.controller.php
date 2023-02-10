<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class info_form extends \Fyre\Core\Controller {

    function index() {

        // Dependencies
        $this->dependencies(array("info_form"));

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $info_form = $this->dependencies->info_form->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/info_form/index", array("info_form" => $info_form));


    }
    

    function single($id) {

        $this->dependencies(array("info_form"));

        global $app;
        
        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $info_form = $this->dependencies->info_form->single($id);

        $this->backoffice("pages/info_form/page", compact('info_form'));
    }

}