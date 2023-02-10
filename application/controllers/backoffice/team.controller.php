<?php 

/** 
*   Controller services ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class team extends \Fyre\Core\Controller {

    function index() {
        
        $this->backoffice("pages/team/index");
        exit();
    }
}