<?php 

/** 
*   Controller homepages ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class homepages extends \Fyre\Core\Controller {

    function index() {

        global $app;

        $lang       = (isset($_GET["lang"]) && !empty($_GET["lang"])) ? $_GET["lang"] : $app->default_language->code;

        // Dependencies
        $this->dependencies(array("homepages"), array());

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        
        $homepages = $this->dependencies->homepages->multiple($lang);
        
        if (empty($homepages)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $homepages);
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("homepages"));
        
        // Data handling
        $ids       = $_POST['ids'];   
        $status = $this->dependencies->homepages->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function single($id) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("homepages"), array());

        $homepages = $this->dependencies->homepages->single($id);
        
        if (empty($homepages)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $homepages);
    }

    function active($id) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("homepages"), array());
        $homepages = $this->dependencies->homepages->single($id);
        
        $res = false;

        switch ($homepages->active)
        {
            case 0:
                $res = 1;
                break;
            case 1:
                $res = 0;
                break;
        }
       
        $this->dependencies->homepages->edit(array("id" => $id, "active" => $res));


        if (empty($homepages)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        
        $this->response(true, "API REQUEST SUCCESS", $homepages);
    }    

    function edit($id)
    {
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("homepages"));

        // Data handling

        $_POST['id'] = $id;

        // Edit the data
        $status = $this->dependencies->homepages->edit($_POST);
        
        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->homepages->single($id));

    }
}
