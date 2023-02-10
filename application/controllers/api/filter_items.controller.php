<?php 

/** 
*   Controller filter_items ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class filter_items extends \Fyre\Core\Controller {

    function index($filter_id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("filter_items"), array());

        $filter_items   = $this->dependencies->filter_items->multiple($filter_id);

        if (empty($filter_items)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $filter_items);
    }

    function insert($filter_id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("filter_items"));

        // Obter a língua da categoria PAI
        if (isset($_POST["parent"])) {

            $_POST["lang"] = $this->dependencies->filter_items->single($_POST["parent"])->lang;
        }

        $_POST["filter_id"] = $filter_id;

        // Insert the data
        $status = $this->dependencies->filter_items->insert($_POST);

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
        $this->dependencies(array("filter_items"));
        
        // Data handling
        $data       = $_GET;
        $data["id"] = $id;
        
        // Edit the data
        $status = $this->dependencies->filter_items->edit($data);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("filter_items"));
        
        // Data handling
        $ids       = $_POST['ids'];   
        $status = $this->dependencies->filter_items->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }
    
    function associateProductCron () {

        $this->dependencies(array("filter_items", "products", "categories"));
        
        // get data 
        $filter_items   = $this->dependencies->filter_items->all();
        $categories     = $this->dependencies->categories->multiple();

        foreach ($filter_items as $cat) {  

            $filter = $this->dependencies->products->getByFilter($cat->id);  

            if(!empty($filter)) { 
                $this->dependencies->filter_items->associateProduct($cat->id, 1);
            } else { 
                $this->dependencies->filter_items->associateProduct($cat->id, 0);
            }           

        }

        foreach ($categories as $cat) {  

            $filter = $this->dependencies->products->getByCategory($cat->id);  

            if(!empty($filter)) { 
                $this->dependencies->categories->associateProduct($cat->id, 1);
            } else { 
                $this->dependencies->categories->associateProduct($cat->id, 0);
            }           

        }

        echo "<center><h2> Filtros atualizadas com sucesso! </h2> <br> <h4> Feche esta aba. </h4></center>";

    }

    function orderASC() {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("filter_items"));
        
        // get data by alphabetical order 
        $multiple = $this->dependencies->filter_items->orderASC();
        $allIds = [];
        if ($multiple) {
            foreach ($multiple as $multi) {
                $allIds[] = $multi->id;
            }
            $new_positions = implode(",", $allIds);            
            $this->dependencies->filter_items->order($new_positions);  

            $this->response(true, "API REQUEST SUCCESS");
        }
        $this->response(false, "API REQUEST ERROR", $multiple);
    }
    
    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("filter_items"));
        
        // Delete the data
        $status = $this->dependencies->filter_items->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}