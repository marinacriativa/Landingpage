<?php

namespace Fyre\Core;

class Route {

    static function add($url, $controller, $function, $method) {
        
        global $routes;
        
        $routes[$method . $url] = array($controller, $function, $method);
    }   

    static function formatLanguages($routes, $languages) {

        $formatted_routes = array();

        foreach ($languages as $language) {

            foreach ($routes as $key => $route) {

                $new_key = str_replace(":language", $language->code, $key);

                $formatted_routes[$new_key] = $route;
            }
        }
        
        return $formatted_routes;
    }


}