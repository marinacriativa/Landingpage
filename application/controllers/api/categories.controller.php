<?php 

/** 
*   Controller categories ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class categories extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("categories"), array());

        $categories   = $this->dependencies->categories->multiple();

        if (empty($categories)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $categories);
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("categories"));

        // Obter a língua da categoria PAI
        if (isset($_POST["parent"])) {

            $_POST["lang"] = $this->dependencies->categories->single($_POST["parent"])->lang;
        }

        // Insert the data
        $status = $this->dependencies->categories->insert($_POST);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
    
    function edit($id) {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("categories"));
        
        // Data handling
        $data       = $_GET;
        $data["id"] = $id;
        
        // Edit the data
        $status = $this->dependencies->categories->edit($data);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("categories"));
        
        // Data handling
        $ids       = $_POST['ids'];   
        $status = $this->dependencies->categories->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function orderASC() {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("categories"));
        
        // get data by alphabetical order 
        $multiple = $this->dependencies->categories->orderASC();
        $allIds = [];
        if ($multiple) {
            foreach ($multiple as $multi) {
                $allIds[] = $multi->id;
            }
            $new_positions = implode(",", $allIds);            
            $this->dependencies->categories->order($new_positions);  

            $this->response(true, "API REQUEST SUCCESS");
        }
        $this->response(false, "API REQUEST ERROR", $multiple);
    }
    
    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("categories"));
        
        // Delete the data
        $status = $this->dependencies->categories->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}