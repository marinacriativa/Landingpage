<?php 

/** 
*   Controller categories_galleries ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class categories_galleries extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("categories_galleries"), array());

        $categories_galleries   = $this->dependencies->categories_galleries->multiple();

        if (empty($categories_galleries)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $categories_galleries);
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("categories_galleries"));

        // Obter a língua da categoria PAI
        if (isset($_POST["parent"])) {

            $_POST["lang"] = $this->dependencies->categories_galleries->single($_POST["parent"])->lang;
        }

        // Insert the data
        $status = $this->dependencies->categories_galleries->insert($_POST);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("categories_galleries"));
        
        // Data handling
        $ids       = $_POST['ids'];   
        $status = $this->dependencies->categories_galleries->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("categories_galleries"));

        // Data handling
        $data       = $_GET;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->categories_galleries->edit($data);

        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("categories_galleries"));

        // Delete the data
        $status = $this->dependencies->categories_galleries->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
} 