<?php 

/** 
* Controller main ( Backoffice ) 
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class favourite extends \Fyre\Core\Controller {
    
    function index() {
        
        global $app;
        
        // Dependencies
        $this->dependencies(array("testimonials", "products", "brands", "styles"), array());
        
        $testimonials   = $this->dependencies->testimonials->listing($app->select_language);
        $brands         = $this->dependencies->brands->listing($app->select_language);
        $styles         = $this->dependencies->styles->listing($app->select_language, 5);
        
        $cookies        = (isset($_COOKIE["fav"]) &&  is_array(json_decode($_COOKIE["fav"], true)) ) ? json_decode($_COOKIE["fav"], true) : array();
        
        if (!empty($cookies)) {
            
            $products = $this->dependencies->products->getByIds($cookies);
            
        } else {
            
            $products = array();
        }
        
        echo $this->template("pages/favourite", compact("products", "testimonials", "brands", "styles"));
    }
    
    function insert() {
        
        if (!isset($_POST["id"])) {
            
            $this->response(false, "Pedido inválido");
        }
        
        if (isset($_COOKIE["fav"])) {
            
            $cookie = json_decode($_COOKIE["fav"], true);
            $cookie[] = intval($_POST["id"]);
            
        } else {
            
            $cookie = array(intval($_POST["id"]));
        }
        
        setcookie("fav", json_encode($cookie), time() + 3600 * 24 * 365, "/"); // 1 ano
        
        $this->response(true, "");
    }
    
    function delete($id) {
        
        if (!isset($id)) {
            
            $this->response(false, "Pedido inválido");
        }
        
        $cookie = json_decode($_COOKIE["fav"], true);
        
        foreach($cookie as $key => $value) {
      
            if ($value == $id) {
                
              unset($cookie[$key]);
            }
        }
        
        setcookie("fav", json_encode(array_values($cookie)), time() + 3600 * 24 * 365, "/"); // 1 ano
        $this->response(true, "");
    }
}