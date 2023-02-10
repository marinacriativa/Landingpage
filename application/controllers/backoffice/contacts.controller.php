<?php 

/** 
* Controller contacts ( Backoffice ) 
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class contacts extends \Fyre\Core\Controller {
    
    function index() {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/contacts/index");

    }
    
    function single($id) {
        
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("contacts"), array());
        
        // Get contact information
        $contact = $this->dependencies->contacts->single($id);
        
        if (empty($contact)) {
            
            $app->redirect("/adm/contacts");
        }
        
        echo $this->backoffice("pages/contacts/page", array("contact" => $contact));
    }
}