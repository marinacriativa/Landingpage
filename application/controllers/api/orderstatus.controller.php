<?php 

/** 
*   Controller products ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class orderStatus extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("orderStatus"), array());

        $status = $this->dependencies->orderStatus->multiple();

        if (empty($status)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $status);
    }

    function single($id) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("orderStatus"), array());

        $status = $this->dependencies->orderStatus->single($id);

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
        $this->dependencies(array("orderStatus"));

        // Insert the data
        $status = $this->dependencies->orderStatus->insert($_POST);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->orderStatus->single($status["data"]));
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("orderStatus"));

        // Data handling
        $data = $_POST;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->orderStatus->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->orderStatus->single($id));
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->dependencies(array("orderStatus"));

        $status = $this->dependencies->orderStatus->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->orderStatus->single($id));
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}
