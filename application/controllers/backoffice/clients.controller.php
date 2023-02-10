<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class clients extends \Fyre\Core\Controller {

    function index() {

        $this->backoffice("pages/clients/index");
    }

    function single() {

        $this->backoffice("pages/clients/page");
    }
}