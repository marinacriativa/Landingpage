<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class alerts extends \Fyre\Core\Controller {

    function index() {
        // Dependencies
        $this->dependencies(array("alerts"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $alerts = $this->dependencies->alerts->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/alerts/index", array("alerts" => $alerts));
    }

    function single($id) {

        global $app;
        
        // Middleware, para permitir apenas administradores
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/alerts/page");
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("alerts"));

        // Data handling
        $data       = $_GET;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->alerts->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->alerts->single($id));
    }
}