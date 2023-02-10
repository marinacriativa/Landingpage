<?php 

/** 
*   Controller info_form ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class info_form extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("info_form"), array());

        $page       = (isset($_GET["page"]))    ? intval($_GET["page"])     : 1;
        $limit      = (isset($_GET["length"]))  ? intval($_GET["length"])   : 10;
        $search     = (isset($_GET["search"]))  ? $_GET["search"]           : null;
        $order      = (isset($_GET["order"]))   ? $_GET["order"]            : "id";
        $start      = ($page - 1) * $limit;  

        $info_form   = $this->dependencies->info_form->multiple($start, $limit, $search, $order);
        $total  = $this->dependencies->info_form->total($search);

        $pagination = array (
            "page"      => (int) $page, 
            "limit"     => (int) $limit, 
            "total"     => (int) $total, 
            "start"     => (int) $start, 
        );

        if (empty($info_form)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $info_form, $pagination);
    } 
    
    function single($id) {
        
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("info_form"), array());

        // Product array
        $new = $this->dependencies->info_form->single($id);

        if (empty($new)) {
            
            $this->response(false, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $new);
    }

    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("info_form"));

        $data = $this->dependencies->info_form->single($id);

        if (empty($data)) {

            $this->response(false, "API REQUEST ERROR");
        }

        // Delete the data
        $status = $this->dependencies->info_form->remove($id);        

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }
        
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }


}