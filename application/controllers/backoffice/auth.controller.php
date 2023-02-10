<?php 

/** 
*   Controller auth ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class auth extends \Fyre\Core\Controller {

    function login() {
        
        global $app;
        
        if ($app->auth->isLogged()) {
            
            $app->redirect("/adm");
        }
        
        $this->backoffice("pages/auth/login", array(), true);
    }

    function reset() {
        
        global $app;
        
        if ($app->auth->isLogged()) {
            
            $app->redirect("/adm");
        }
        
        $this->backoffice("pages/auth/reset", array(), true);
    }
}