<?php 

/** 
*   Controller contacts ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class contacts extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("contacts"), array());

        $page       = (isset($_GET["page"]))    ? intval($_GET["page"])     : 1;
        $limit      = (isset($_GET["length"]))  ? intval($_GET["length"])   : 50;
        $order      = (isset($_GET["order"]))   ? $_GET["order"]            : "date";

        $start      = ($page - 1) * $limit;  

        $contacts = $this->dependencies->contacts->multiple($start, $limit);
        $total      = $this->dependencies->contacts->total();

        $pagination = array (
            "page"      => (int) $page, 
            "limit"     => (int) $limit, 
            "total"     => (int) $total, 
            "start"     => (int) $start, 
        );

        if (empty($contacts)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $contacts, $pagination);
    }
    
    function single($id) {
        
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("contacts"), array());

        // Product array
        $contact = $this->dependencies->contacts->single($id);

        if (empty($contact)) {
            
            $this->response(false, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $contact);
    }
    
    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("contacts"));
        
        // Delete the data
        $status = $this->dependencies->contacts->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->contacts->single($id));
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}