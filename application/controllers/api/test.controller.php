<?php 

/** 
*   Controller test ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class test extends \Fyre\Core\Controller {
    
    function smtp() {
        
        global $debug; // String com o debug do PHPMailer
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array(), array("email"));
        
        if (!isset($_POST["email"]) || empty($_POST["email"])) {
            
            $this->response("API ERROR", false);
        }
        
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
          
            $this->response("API ERROR", false);  
        }
        
        // Mandar email teste
        $this->dependencies->library->email->send($_POST["email"], "Criativatek SMTP test", "message", array("subject" => "Teste SMTP sucessfull", "message" => "Isto é um email teste de SMTP requisitado na área de administração"), 2);
    
        $this->response("API REQUEST SUCCESS", true, array("debug" => $debug));
    }
}