<?php

use Fyre\Core\Application;

/*
*
*   Start the Fyre Framework and serve routes
*   Author: Vlad
*   Copyright 2020 Criativatek™ 
*/

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'application' . DIRECTORY_SEPARATOR);

// Ficheiros de configuração
require APP . 'config/config.php';

require APP . 'templates/frontoffice/modules.php';


// Class de routes
require APP . 'core/route.php';
 
// Lista das routes todas que o site tem
require APP . 'config/routes/backoffice.php';
require APP . 'config/routes/frontoffice.php';
require APP . 'config/routes/api.php';
require APP . 'config/routes/auth.php';

// Authentication
require APP . 'library/authentication.php';

// Ficheiros principais para o funcionamento desta "framework"
require APP . 'core/application.php';
require APP . 'core/controller.php';
require APP . 'core/model.php';

function config() {
    
    return [

        'view_id' => GOOGLE_ANALYTICS_VIEW_ID,
        'credentials_json_file' => APP . "/config/google_analytics.json",
    ];
}

function route() {

    return 1;
}

function asset() {

    return 1;
}

function request() {

    return 1;
}

function input() {

    return 1;
}

// Error handling
function error_logger($errno, $errstr, $errfile, $errline ) {
    
    file_put_contents(ERROR_LOG_FILE, $errfile . ":LINE-" . $errline . " Error:" . $errstr . PHP_EOL. PHP_EOL, FILE_APPEND | LOCK_EX);
    
    if ($errno == 1) {
        
        http_response_code(500);
        echo "ERORRRRRRRR";
        exit();
    }
}


if (ENVIRONMENT != "dev") {
    
    set_error_handler("error_logger");
}

// Composer autload
require APP . 'library/vendor/autoload.php';

$langg = json_decode(file_get_contents("info.json", true));

$app = new Application();
$app->addHook("404", function() {

    $controller = new \Fyre\Core\Controller();

    echo $controller->template("pages/404");
    
    exit();
});


// Servir as routes
$app->serve(\Fyre\Core\Route::formatLanguages($routes, $app->languages));
