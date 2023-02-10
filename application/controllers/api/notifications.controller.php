<?php 

/** 
*   Controller notifications ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class notifications extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("notifications"), array());

        $notifications = $this->dependencies->notifications->multiple($this->user["id"]);


        if (empty($notifications)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $notifications);
    }
    
    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("notifications"));
        
        // Delete the data
        $status = $this->dependencies->notifications->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }

        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultipleNotifications() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("notifications"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->notifications->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}