<?php

// Tipo de servidor, se for dev => mostra os erros todos
define('ENVIRONMENT', 'dev');
// Definições de database -> /application/core/application.php
define('DB_TYPE', 'mysql');
/* define('DB_HOST', '88.99.150.173');
define('DB_NAME', 'katrina_website');
define('DB_USER', 'katrina_website');
define('DB_PASS', 'TL6X&0y9arnR'); */
define('DB_HOST', '62.171.144.207');
define('DB_NAME', 'bioalternativa_landingpage');
define('DB_USER', 'bioalternativa_landingpage');
define('DB_PASS', '~~@Oy@^eR9L%');
define('DB_CHARSET', 'utf8');

// Proxy CDN para o Amazon S3, serve para meter headers CORS e fazer cache gratis com o cloudflare
define("CRIATIVATEK_CDN_PROXY", "https://cdn.criativatek.com/?url=");

// Cloudflare API
define('CLOUDFLARE_ZONE_ID', 'd8b7b4b01792f599a2cc736058cbc5aa');
define('CLOUDFLARE_API_TOKEN', 'mlmM-z-hiX3a62lUQjSyPCqZqC3BFlAvhXNsICKd');

// Definições de URLs e caminhos dentro do servidor
define('URL_PUBLIC_FOLDER', 'public');
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] != null) {
    define('URL_PROTOCOL', 'https://');
} else {
    define('URL_PROTOCOL', 'http://');
}
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);

// REQUEST METHODS -> /application/config/routes.php
define('GET',       'get');
define('POST',      'post');
define('PUT',       'put');
define('DELETE',    'delete');

// MIDDLEWARE TYPES -> /application/core/controller.php
define('MIDDLEWARE_LOGGED_USER_ONLY'    , 0);
define('MIDDLEWARE_ADMIN_ONLY'          , 1);

// Error log file
define("ERROR_LOG_FILE", APP . "core/logs/errors.data");

if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

function dd($var) {

    var_dump($var);
    exit();
}
