<?php 

/** 
*   Controller categories_constructions ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class categories_constructions extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("categories_constructions"), array());

        $categories_constructions   = $this->dependencies->categories_constructions->multiple();

        if (empty($categories_constructions)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $categories_constructions);
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("categories_constructions"));

        // Obter a língua da categoria PAI
        if (isset($_POST["parent"])) {

            $_POST["lang"] = $this->dependencies->categories_constructions->single($_POST["parent"])->lang;
        }

        // Insert the data
        $status = $this->dependencies->categories_constructions->insert($_POST);

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
        $this->dependencies(array("categories_constructions"));
        
        // Data handling
        $ids       = $_POST['ids'];   
        $status = $this->dependencies->categories_constructions->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("categories_constructions"));

        // Data handling
        $data       = $_GET;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->categories_constructions->edit($data);

        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("categories_constructions"));

        // Delete the data
        $status = $this->dependencies->categories_constructions->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function associateConstructionCron () {

        $this->dependencies(array("categories_constructions", "constructions"));
        
        // get data 
        $multiple = $this->dependencies->categories_constructions->multiple();

        $ids_categories = [];

        foreach ($multiple as $cat) {  

            $result = $this->dependencies->constructions->getByCategory($cat->id);  

            if(!empty($result)) { 
                $this->dependencies->categories_constructions->associateConstruction($cat->id, 1);
            } else { 
                $this->dependencies->categories_constructions->associateConstruction($cat->id, 0);
            }           

        }

        $this->response(true, "API REQUEST SUCCESS");

    }
} 