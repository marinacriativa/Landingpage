<?php 

/** 
*   Controller categories_jobs ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class categories_jobs extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("categories_jobs"), array());

        $categories_jobs   = $this->dependencies->categories_jobs->multiple();

        if (empty($categories_jobs)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $categories_jobs);
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("categories_jobs"));

        // Obter a língua da categoria PAI
        if (isset($_POST["parent"])) {

            $_POST["lang"] = $this->dependencies->categories_jobs->single($_POST["parent"])->lang;
        }

        // Insert the data
        $status = $this->dependencies->categories_jobs->insert($_POST);

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
        $this->dependencies(array("categories_jobs"));
        
        // Data handling
        $data       = $_GET;
        $data["id"] = $id;
        
        // Edit the data
        $status = $this->dependencies->categories_jobs->edit($data);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("categories_jobs"));
        
        // Data handling
        $ids       = $_POST['ids'];   
        $status = $this->dependencies->categories_jobs->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function orderASC() {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("categories_jobs"));
        
        // get data by alphabetical order 
        $multiple = $this->dependencies->categories_jobs->orderASC();
        $allIds = [];
        if ($multiple) {
            foreach ($multiple as $multi) {
                $allIds[] = $multi->id;
            }
            $new_positions = implode(",", $allIds);            
            $this->dependencies->categories_jobs->order($new_positions);  

            $this->response(true, "API REQUEST SUCCESS");
        }
        $this->response(false, "API REQUEST ERROR", $multiple);
    }
    
    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("categories_jobs"));
        
        // Delete the data
        $status = $this->dependencies->categories_jobs->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function associateJobCron () {

        $this->dependencies(array("categories_jobs", "jobs"));
        
        // get data 
        $multiple = $this->dependencies->categories_jobs->multiple();

        $ids_categories = [];

        foreach ($multiple as $cat) {  

            $result = $this->dependencies->jobs->getByCategory($cat->id);  

            if(!empty($result)) { 
         
                $catJob = $this->dependencies->jobs->single($cat->id);
              
                $this->dependencies->categories_jobs->edit(['id' => $cat->id, 'qntd' => $result]);
                
                $this->dependencies->categories_jobs->associateJob($cat->id, 1);
            } else { 
                $this->dependencies->categories_jobs->associateJob($cat->id, 0);
            }           

        }

        $this->response(true, "API REQUEST SUCCESS");

    }
}