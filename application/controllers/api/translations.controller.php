<?php 

/** 
*   Controller translations ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class translations extends \Fyre\Core\Controller {

    function multiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // As linguas já foram carregadas em /application/core/application.php

        $this->response(true, "API REQUEST SUCCESS", $app->languages);
    }

    function single($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("translation", "translation_words", "orderStatus"));

        $language = $this->dependencies->translation->single($id);
        $translation_words = $this->dependencies->translation_words->multiple($id);
        $order_Status = $this->dependencies->orderStatus->byLang($language->code);

        if (empty($language)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", array("language" => $language, "translations" => $translation_words, "orderStatus" => $order_Status));
    }

    function update($lang) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("translation", "translation_words", "orderStatus"));

        foreach ($app->languages as $language) {
            
            if ($language->id == $lang) {
                
                $selected = $language;
            }
        }
        
        if (!isset($selected)) {
            
            $this->response(false, "API REQUEST ERROR");
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
        $this->dependencies(array("translation", "translation_words", "categories_news", "categories_constructions", "personalization", "categories", "orderStatus"));
        
        $data       = $_POST;
        $clone      = $_POST["clone"];

        // Remove clone
        unset($data["clone"]);

        $langStatus = $this->dependencies->orderStatus->byLang($_POST["code"]);

        if(empty($langStatus)){
            //Numeros de estados predifenidos
            $numberStatus = 3;
            //por cada estado predefinido é criado um estado na tabela order_status
            for ($i=1; $i <= $numberStatus; $i++){
                $dataStatus = (object)[
                    'name' => $_POST["default_state". $i],
                    'lang' => $_POST["code"],
                    'predefined' => 1,
                ];
                $test = $this->dependencies->orderStatus->insert($dataStatus);
                //na tabela translations os estados ficam guardados os ids correspondentes
                $data["default_state".$i] = $test["data"];
            }
        }


        $langPersonalization = $this->dependencies->personalization->getLanguageByLang($_POST["code"]);

        if(empty($langPersonalization)){
            $dataPersonalization = (object)[
                'name' => $_POST["name"],
                'lang' => $_POST["code"],
                'root' => 1,
            ];
            $this->dependencies->personalization->insert($dataPersonalization);
        }

        $langCategories = $this->dependencies->categories->getLanguageByLang($_POST["code"]);

        if(empty($langCategories)){
            $dataCategories = (object)[
                'name' => $_POST["name"],
                'lang' => $_POST["code"],
                'root' => 1,
            ];
            $this->dependencies->categories->insert($dataCategories);
        }

        $langCategoriesNews = $this->dependencies->categories_news->getLanguageByLang($_POST["code"]);

        if(empty($langCategoriesNews)){
            $dataCategoriesNews = (object)[
                'name' => $_POST["name"],
                'lang' => $_POST["code"],
                'root' => 1,
            ];
            $this->dependencies->categories_news->insert($dataCategoriesNews);
        }

        $langCategoriesConstructions = $this->dependencies->categories_constructions->getLanguageByLang($_POST["code"]);

        if(empty($langCategoriesConstructions)){
            $dataCategoriesConstructions = (object)[
                'name' => $_POST["name"],
                'lang' => $_POST["code"],
                'root' => 1,
            ];
            $this->dependencies->categories_constructions->insert($dataCategoriesConstructions);
        }

        // Edit the language
        $status = $this->dependencies->translation->insert($data);
        
        if ($status["success"]) {

            
            // Clone the translations
            $this->dependencies->translation_words->translation_clone($clone, $status["data"]);
            $language = $this->response(true, "API REQUEST SUCCESS", $this->dependencies->translation->single($status["data"]));
        }

        // Send json response 
        $this->raw_response($status, $language);
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