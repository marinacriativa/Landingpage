<?php

namespace Fyre\Core;

/*
    Lista de todas as routes da aplicação, uma route é definida assim:

        "path/:alpha" => array('controller','function','method')),

        Route::add("/link/personalizado/:alpha", "groups", "multiple", GET);

        Métodos:  GET, POST, DELETE, PUT

    Existem 4 tipos de "wildcards":
        :alpha    -> Todo o tipo de caráters        '([a-zA-Z0-9-_.,%\[\]=?]+)'
        :string   -> Caraters alfanumericos         '([a-zA-Z]+)'
        :language -> Caraters alfanumericos         '([a-zA-Z]+)'
        :number   -> Apenas numeros                 '([0-9]+)'

    Para uma função de um controller aceitar um wildcard é preciso apenas que a função tenha 1 argumento  no controller

    Exemplo: function($id) { echo $id; }

    Podes ainda meter os controllers dentro de uma pasta (para nao estar tudo numa pasta) usando um ponto, por exemplo:

    Route::add("/imagens-coloridas", "imagens.coloridas", "multiple",  GET);

    Controller encontrado em: /application/controllers/imagens/coloridas.controller.php
*/

Route::add("/",                                 "frontoffice.pages",            "redirect_language",    GET);
Route::add("/:language",                        "frontoffice.pages",            "index",                GET);

//pages from editor
Route::add("/:language/pages/:alpha",          "frontoffice.pages",            "page_by_url",          GET);


Route::add("/:language/products",               "frontoffice.products",         "index",                GET);
Route::add("/:language/products/:alpha",        "frontoffice.products",         "page",                 GET);
Route::add("/:language/product",                "frontoffice.pages",            "product",              GET);

Route::add("/:language/constructions",          "frontoffice.constructions",    "index",                GET);
Route::add("/:language/constructions/:alpha",   "frontoffice.constructions",    "page",                 GET);
Route::add("/:language/construction",           "frontoffice.pages",            "construction",         GET);

Route::add("/:language/obituaries",          "frontoffice.obituaries",    "index",                GET);
Route::add("/:language/obituaries/:alpha",   "frontoffice.obituaries",    "page",                 GET);
Route::add("/:language/obituary",            "frontoffice.pages",         "obituary",             GET);

Route::add("/:language/news",                   "frontoffice.news",              "index",               GET);
Route::add("/:language/news/:alpha",            "frontoffice.news",              "page",                GET);
Route::add("/:language/search",                 "frontoffice.news",              "search",              GET);
Route::add("/:language/searchAjax",             "frontoffice.news",              "searchAjax",          GET);

Route::add("/:language/jobs",                   "frontoffice.jobs",              "index",               GET);
Route::add("/:language/jobs/:alpha",            "frontoffice.jobs",              "page",                GET);

Route::add("/:language/recruitments",            "frontoffice.recruitments",    "index",                GET);
Route::add("/:language/recruitments/:alpha",     "frontoffice.recruitments",    "page",                 GET);


Route::add("/:language/faq",                    "frontoffice.pages",            "faq",                  GET);

Route::add("/:language/contact",                "frontoffice.contact",          "contact",              GET);
Route::add("/contact",                          "frontoffice.contact",          "contact_post",         POST);

Route::add("/:language/privacy",                "frontoffice.pages",            "privacy",              GET);

Route::add("/:language/terms",                  "frontoffice.pages",            "terms",                GET);

Route::add("/:language/about",                  "frontoffice.pages",            "about",                GET);

Route::add("/:language/booking",                "frontoffice.pages",            "booking",              GET);


Route::add("/:language/imported-datas",         "frontoffice.pages",            "imported_datas",       GET);
Route::add("/request/table",                    "frontoffice.pages",            "addItemTable",         POST);
Route::add("/request/table/datas",              "frontoffice.pages",            "getItemsTable",        POST);
Route::add("/request/table/:number",            "frontoffice.pages",            "removeItemTable",      DELETE);

Route::add("/:language/brands",                 "frontoffice.pages",            "brands",               GET);

Route::add("/language/:language",               "frontoffice.pages",            "change_language",      GET);

Route::add("/:language/contact",                "frontoffice.pages",            "contact_post",         POST);

Route::add("/:language/services",               "frontoffice.pages",           "services",             GET);
Route::add("/:language/services/:alpha",       "frontoffice.services",         "index",               GET);

// Paginas de utilizador
Route::add("/profile",                          "frontoffice.profile",          "profile",              GET);
Route::add("/profile/change/password",          "frontoffice.profile",          "changePassword",       POST);
Route::add("/profile/:number",                  "frontoffice.profile",          "edit",                 POST);
Route::add("/orders/:number",                   "frontoffice.profile",          "ordersDetails",        GET);
Route::add("/orders",                           "frontoffice.profile",          "ordersIndex",        GET);
Route::add("/tickets",                          "frontoffice.profile",          "tickets",              GET);
Route::add("/tickets/:number",                  "frontoffice.profile",          "ticketsDetails",       GET);
Route::add("/tickets",                          "frontoffice.profile",          "insertTicket",         POST);
Route::add("/tickets/message",                  "frontoffice.profile",          "insertMessage",        POST);

Route::add("/newsletter",                       "frontoffice.pages",            "newsletter",           POST);

Route::add("/budget",                           "frontoffice.contact",          "budget_post",          POST);

Route::add("/:language/login",                  "frontoffice.auth",             "login_page",        GET);
Route::add("/:language/register",               "frontoffice.auth",             "register_page",        GET);
Route::add("/login",                            "frontoffice.auth",             "login",                POST);
Route::add("/register",                         "frontoffice.auth",             "register",             POST);

Route::add("/confirm/:alpha",                   "frontoffice.auth",             "confirm",              GET);
Route::add("/forgot",                           "frontoffice.auth",             "forgot",               POST);
Route::add("/reset",                            "frontoffice.auth",             "reset",                POST);
Route::add("/reset/:alpha",                     "frontoffice.auth",             "reset_page",           GET);

//Profile Page
Route::add("/:language/profile",                "frontoffice.pages",            "profile",              GET);

Route::add("/:language/galleries",               "frontoffice.galleries",         "index",                GET);
Route::add("/:language/galleries/:alpha",        "frontoffice.galleries",         "page",                 GET);
Route::add("/:language/gallery",                "frontoffice.pages",               "gallery",              GET);

// Carrinho
Route::add("/cart",                             "frontoffice.cart",             "add",                  POST);
Route::add("/quantity/:number",                 "frontoffice.cart",             "changeQuantity",       POST);
Route::add("/quantity/advanced/:number",        "frontoffice.cart",             "changeQuantityAdvanced",       POST);
Route::add("/cart",                             "frontoffice.cart",             "get",                  GET);
Route::add("/cart/details",                     "frontoffice.cart",             "details",              GET);
Route::add("/cart/:number",                     "frontoffice.cart",             "removeItem",           DELETE);
Route::add("/cart_adv/:number",                 "frontoffice.cart",             "removeItemAdvanced",   DELETE);

// Coupon
Route::add("/coupon",                           "frontoffice.coupon",           "add",                  POST);
Route::add("/coupon",                           "frontoffice.coupon",           "get",                  GET);
Route::add("/coupon/:alpha",                    "frontoffice.coupon",           "removeItem",           DELETE);

// Checkout
Route::add("/checkout",                         "frontoffice.checkout",         "checkout",             POST);
Route::add("/checkout",                         "frontoffice.checkout",         "get",                  GET);
Route::add("/checkout/:alpha",                  "frontoffice.checkout",         "pay",                  GET);
Route::add("/checkout/:alpha",                  "frontoffice.checkout",         "pay_status",           POST);

// Ajax order status
Route::add("/checkout/:alpha",                  "frontoffice.checkout",         "pay",                  GET);

// CALLBACKS
Route::add("/callback/vivawallet/success",      "callbacks.vivawallet",      "success",                  POST);
Route::add("/callback/vivawallet/error",        "callbacks.vivawallet",      "error",                    GET);
Route::add("/callback/vivawallet/key",          "callbacks.vivawallet",      "key",                      GET);