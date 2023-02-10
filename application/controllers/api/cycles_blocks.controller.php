<?php

/**
 *   Controller cycles_blocks ( Backoffice )
 *
 *   Extends: core/Controller.php
 *   Author: Vlad
 **/

namespace Fyre\Controller;

class cycles_blocks extends \Fyre\Core\Controller
{

    function index()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $lang       = (isset($_GET["lang"]) && !empty($_GET["lang"])) ? $_GET["lang"] : $app->default_language->code;

        // Dependencies
        $this->dependencies(array("cycles_blocks"), array());
        
        $cycles_blocks = $this->dependencies->cycles_blocks->multiple($lang); 

        if (empty($cycles_blocks)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $cycles_blocks);

    }

    function single($id)
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("cycles_blocks"), array());

        $alert = $this->dependencies->cycles_blocks->single($id);

        if (empty($alert)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $alert);
    }

    function edit($id) {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("cycles_blocks"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->cycles_blocks->edit($data);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS", $status);
    }

    function active($id) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("cycles_blocks"));

        $cycles_blocks = $this->dependencies->cycles_blocks->single($id);
        
        $res = false;

        switch ($cycles_blocks->active)
        {
            case 0:
                $res = 1;
                break;
            case 1:
                $res = 0;
                break;
        }
       
        $this->dependencies->cycles_blocks->edit(array("id" => $id, "active" => $res));


        if (empty($cycles_blocks)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $cycles_blocks);
    }


    function insert()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("cycles_blocks"));

        // Defenir a linguagem principal
        if (!isset($_POST["lang"])) {
            
            $_POST["lang"] = $app->default_language->code;
        }

        // Se o $_POST tiver um ID copia as informações todas desse produto para outro

        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->cycles_blocks->single($_POST["id"]);

            if (!empty($clone)) {

                //Neste foreach estamos a introduzir os valores que nao temos no novo produto
                foreach ($clone as $key => $value) {

                    if (!isset($_POST[$key])) {

                        $_POST[$key] = $value;
                    }
                }
            }

            //Retirar o id do post
            unset($_POST["id"]);            
            
        }
        
        // Insert the data
        $status = $this->dependencies->cycles_blocks->insert($_POST);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->cycles_blocks->single($status["data"]));
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }



    function delete($id)
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("cycles_blocks"));
        
        $status = $this->dependencies->cycles_blocks->remove($id);

        if ($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->cycles_blocks->single($id));
        }
        
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }


}