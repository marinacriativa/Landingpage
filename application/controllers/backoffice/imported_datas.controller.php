<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class imported_datas extends \Fyre\Core\Controller {


    function index() {
        // Dependencies
        $this->dependencies(array("imported_datas"), array());
        
        $imported_datas = $this->dependencies->imported_datas->multiple();

        $this->backoffice("pages/imported_datas/index", array("imported_datas" => $imported_datas));
    }

    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("imported_datas"));
        
        // Delete the data
        $status = $this->dependencies->imported_datas->remove($id);
        
        // Send json response 
        $this->raw_response($status);
    }

}