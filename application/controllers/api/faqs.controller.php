<?php 

/** 
*   Controller products ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class faqs extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("faqs"), array());

        $status = $this->dependencies->faqs->multiple();

        if (empty($status)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $status);
    }

    function single($id) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("faqs"), array());

        $status = $this->dependencies->faqs->single($id);

        if (empty($status)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $status);
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("faqs"));

        // Insert the data
        $status = $this->dependencies->faqs->insert($_POST);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->faqs->single($status["data"]));
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("faqs"));

        // Data handling
        $data = $_POST;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->faqs->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->faqs->single($id));
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->dependencies(array("faqs"));

        $status = $this->dependencies->faqs->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->faqs->single($id));
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}