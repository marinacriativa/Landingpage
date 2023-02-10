<?php

namespace Fyre\Core;

/*
    Lista de todas as routes da aplicação, uma route é definida assim:

        "path/:alpha" => array('controller','function','method')),

        Route::add("/link/personalizado/:alpha", "groups", "multiple", GET);

        Métodos:  GET, POST, DELETE, PUT

    Existem 3 tipos de "wildcards":
        :alpha  -> Todo o tipo de caráters '([a-zA-Z0-9-_.,%\[\]=?]+)'
        :string -> Caraters alfanumericos  '([0-9]+)'
        :number -> Apenas numeros          '([a-zA-Z]+)'

    Para uma função de um controller aceitar um wildcard é preciso apenas que a função tenha 1 argumento  no controller

    Exemplo: function($id) { echo $id; }

    Podes ainda meter os controllers dentro de uma pasta (para nao estar tudo numa pasta) usando um ponto, por exemplo:

    Route::add("/imagens-coloridas", "imagens.coloridas", "multiple",  GET);

    Controller encontrado em: /application/controllers/imagens/coloridas.controller.php
*/



//PÁGINA PRINCIPAL
Route::add("/api/login",            "auth.login",   "authenticate",     POST);
Route::add("/logout",           "auth.login",   "logout",           GET);