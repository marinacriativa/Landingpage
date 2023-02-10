<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class documents extends \Fyre\Core\Controller {

    function index() {
        // Dependencies
        $this->dependencies(array("documents"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 10;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $documents = $this->dependencies->documents->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/documents/index", array("documents" => $documents));
    }

    function single($id) {

        global $app;
        
        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/documents/page");
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("documents"));

        // Data handling
        $data       = $_GET;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->documents->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->documents->single($id));
    }
}