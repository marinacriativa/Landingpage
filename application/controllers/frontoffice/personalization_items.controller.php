<?php

/**
 * Controller main ( Backoffice )
 *
 *   Extends: core/Controller.php
 *   Author: Vlad
 **/

namespace Fyre\Controller;

class personalization_items extends \Fyre\Core\Controller
{

    function index()
    {

        global $app;

        // Dependencies
        $this->dependencies(array("personalization"), array());

        // Obter as personalizações
        $allPersonalization = $this->dependencies->personalization->getAllIds($app->selected_language->code, null, null, null, null);

        $allIds = [];      
        foreach($allPersonalization as $personalization) {
            $allIds[] = $personalization->id;
        }

        $personalization = $this->dependencies->personalization->productsPersonalization($allIds);

        echo $this->template("pages/personalization_items/index", compact("personalization"));
    }

}