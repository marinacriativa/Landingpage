<?php 

/** 
*   Controller products ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class products extends \Fyre\Core\Controller {

    function slim() {
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array(), array("image"));

        $slim           =  json_decode($_POST["slim"][0], true);
        $directory      = "/static/images/" . $slim["meta"]["folder"] . "/";
        
        if (!file_exists(ROOT . "public/" . $directory)) {
            
            mkdir(ROOT . "public/" . $directory, 0777, true);
        }
        
        $max_width = null;
        
        if ($slim["meta"]["folder"] == "team") {
            
            $max_width = "500";
        }
        
        $data["file"]   = $_FILES[$slim["output"]["field"]];
        $status         = $this->dependencies->library->image->send($data, $directory, array("image/jpeg", "image/png"), $max_width);

        $this->raw_response($status);
    }
}