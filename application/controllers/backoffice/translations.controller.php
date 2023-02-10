<?php 

/** 
*   Controller translations ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class translations extends \Fyre\Core\Controller {

    function single() {

        // Middleware  ok
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->backoffice("pages/translations/page");
    }

    function page($lang) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("translation_words"), array());
        
        foreach ($app->languages as $language) {
            
            if ($language["code"] == $lang) {
                
                $selected = $language;
            }
        }
        
        if (!isset($selected)) {
            
            $app->redirect("/adm/settings");
        }
       
        $translations = $this->dependencies->translation_words->multiple($selected["id"]);
        
        $final = array();
        
        foreach ($translations as $word) {
            
            $final[$word["category"]][] = $word;
        }
        
        $this->backoffice("pages/translations/edit", array("selected_language" => $final, "lang" => $selected));
    }
    
    function update($lang) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("translation", "translation_words"));
        
        foreach ($app->languages as $language) {
            
            if ($language["id"] == $lang) {
                
                $selected = $language;
            }
        }
        
        if (!isset($selected)) {
            
            $this->response(false, $app->translations["common"]["unauthorized"]);
        }

        if (isset($_POST["lang"])) {
            
            $status = $this->dependencies->translation->edit($_POST["lang"]);
            
            if (isset($_POST["frontoffice"]) && !empty($_POST["frontoffice"])) {
            
                // Eu sei que isto vai dar loop 100 vezes
                // não tenho muito tempo para optimizar uma página usada 1 vez por ano no maximo
                
                foreach ($_POST["frontoffice"] as $key => $frontoffice) {
                    
                    $this->dependencies->translation_words->edit_keys($key, $frontoffice, $_POST["lang"]["id"]);
                }
            }
            
            if (isset($_POST["common"]) && !empty($_POST["common"])) {
            
                foreach ($_POST["common"] as $key => $common) {
                    
                    $this->dependencies->translation_words->edit_keys($key, $common, $_POST["lang"]["id"]);
                }
            }
            
            if (isset($_POST["backoffice"]) && !empty($_POST["backoffice"])) {
            
                foreach ($_POST["backoffice"] as $key => $backoffice) {
                    
                    $this->dependencies->translation_words->edit_keys($key, $backoffice, $_POST["lang"]["id"]);
                }
            }
        }
        
        // Send json response 
        $this->raw_response($status);
    }
    
    function edit_language() {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("translation"));
        
        // Data handling
        $data       = $_GET;
        $data["id"] = $id;
        
        // Edit the data
        $status = $this->dependencies->translation->edit($data);
        
        // Send json response 
        $this->raw_response($status);
    }
    
    function edit_translation() {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("translation_words"));
        
        // Data handling
        $data       = $_GET;
        $data["id"] = $id;
        
        // Edit the data
        $status = $this->dependencies->translation_words->edit($data);
        
        // Send json response 
        $this->raw_response($status);
    }
    
    function delete_language($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("translation", "translation_words"));
        
        // Delete the language
        $status = $this->dependencies->translation->remove($id);
        
        if ($status["success"]) {
            
            // Delete the language translations
            $status = $this->dependencies->translation_words->remove($id);
        }
        
        // Send json response 
        $this->raw_response($status);
    }
    
    function insert_language() {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("translation", "translation_words"));
        
        $data       = $_POST;
        $clone      = $_POST["clone"];
        
        // Remove clone
        unset($data["clone"]);
        
        // Edit the language
        $status = $this->dependencies->translation->insert($data);
        
        if ($status["success"]) {
            
            // Clone the translations
            $this->dependencies->translation_words->translation_clone($clone, $status["data"]);
        }

        // Send json response 
        $this->raw_response($status);
    }
    
    function insert_translation($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("translation_words"));
        
        $data = $_POST;
        
        // Insert the translation
        $status = $this->dependencies->translation_words->insert($data);
        
        // Send json response 
        $this->raw_response($status);
    }
}