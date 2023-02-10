<?php 

/** 
*   Controller payment ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class payment extends \Fyre\Core\Controller {

    function index() {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("payment"), array());

        $payment = $this->dependencies->payment->multiple();
        
        if (empty($payment)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $payment);
    }
    
    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("payment"));

        //Verifica que tipo de edit , se é edit para o estado ou das settings
        if($_POST["type"] == "status"){
            $data = $_POST;
            unset($data['type']);
        }

        if($_POST["type"] == "settings"){
            unset($_POST['type']);
            $data["settings"] = json_encode($_POST);
        }

        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->payment->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS");
    }

    function single($id) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("payment"), array());

        $payment = $this->dependencies->payment->single($id);

        $settings = json_decode($payment->settings);

        if (empty($payment)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $settings);
    }

}
