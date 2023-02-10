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
Route::add("/adm",                          "backoffice.index",              "index",                GET);
Route::add("/adm/login",                    "backoffice.auth",               "login",                GET);
Route::add("/adm/reset",                    "backoffice.auth",               "reset",                GET);

//NEWS
Route::add("/adm/news",                     "backoffice.news",               "index",                GET);
Route::add("/adm/news/add",                 "backoffice.news",               "insert",               GET);
Route::add("/adm/news/:number",             "backoffice.news",               "single",               GET);

//RECRUITMENTS
Route::add("/adm/recruitments",             "backoffice.recruitments",       "index",                GET);
Route::add("/adm/recruitments/add",         "backoffice.recruitments",       "insert",               GET);
Route::add("/adm/recruitments/:number",     "backoffice.recruitments",       "single",               GET);

//COUPONS
Route::add("/adm/coupons",                  "backoffice.coupons",            "index",                GET);
Route::add("/adm/coupons/add",              "backoffice.coupons",            "insert",               GET);
Route::add("/adm/coupons/:number",          "backoffice.coupons",            "single",               GET);

//INFO FORM   
Route::add("/adm/info-form",                "backoffice.info_form",           "index",                GET);
Route::add("/adm/info-form/:number",        "backoffice.info_form",           "single",               GET);
Route::add("/adm/info-form/:number",        "backoffice.info_form",           "delete",               DELETE);

//SCHEDULE
Route::add("/adm/schedule",                 "backoffice.schedule",           "index",                GET);
Route::add("/adm/schedule/:number",         "backoffice.schedule",           "single",               GET);
Route::add("/adm/schedule/:number",         "backoffice.schedule",           "delete",               DELETE);

//HOMEPAGES
Route::add("/adm/homepages",                "backoffice.homepages",           "index",                GET);
Route::add("/adm/homepages/editor/:number",         "backoffice.homepages",   "editorH",               GET);
Route::add("/adm/homepages/editor/raw/:number",     "backoffice.homepages",   "editorH_raw",           GET);

//BRANDS
Route::add("/adm/brands",                   "backoffice.brands",             "index",                GET);
Route::add("/adm/brands/add",               "backoffice.brands",             "insert",               GET);
Route::add("/adm/brands/:number",           "backoffice.brands",             "single",               GET);

//IMPORTED DATAS
Route::add("/adm/imported_datas",           "backoffice.imported_datas",      "index",                GET);

//SERVICES
Route::add("/adm/services",                 "backoffice.services",          "index",                GET);
Route::add("/adm/services/:number",         "backoffice.services",          "single",               GET);
Route::add("/adm/services/add",             "backoffice.services",          "insert",               GET);

//CUSTOM PAGE
Route::add("/adm/custom_page",              "backoffice.custom_page",       "index",                GET);
Route::add("/adm/custom_page/:number",      "backoffice.custom_page",       "single",               GET);
Route::add("/adm/custom_page/add",          "backoffice.custom_page",       "insert",               GET);

//CUSTOM INFO
Route::add("/adm/custom_info",              "backoffice.custom_info",       "index",                GET);
Route::add("/adm/custom_info/:number",      "backoffice.custom_info",       "single",               GET);
Route::add("/adm/custom_info/add",          "backoffice.custom_info",       "insert",               GET);

//FILTERS
Route::add("/adm/filters",                  "backoffice.filters",          "index",                GET);
Route::add("/adm/filters/:number",          "backoffice.filters",          "single",               GET);
Route::add("/adm/filters/add",              "backoffice.filters",          "insert",               GET);

//JOBS
Route::add("/adm/jobs",                  "backoffice.jobs",          "index",                GET);
Route::add("/adm/jobs/:number",          "backoffice.jobs",          "single",               GET);
Route::add("/adm/jobs/add",              "backoffice.jobs",          "insert",               GET);

//CONSTRUCTIONS
Route::add("/adm/constructions",            "backoffice.constructions",      "index",                GET);
Route::add("/adm/constructions/:number",    "backoffice.constructions",      "single",               GET);
Route::add("/adm/constructions/add",        "backoffice.constructions",      "insert",               GET);

//OBITUARIES
Route::add("/adm/obituaries",            "backoffice.obituaries",      "index",                GET);
Route::add("/adm/obituaries/:number",    "backoffice.obituaries",      "single",               GET);
Route::add("/adm/obituaries/add",        "backoffice.obituaries",      "insert",               GET);

//CLIENTS 
Route::add("/adm/clients",                "backoffice.clients",            "index",                GET);
Route::add("/adm/clients/:number",        "backoffice.clients",            "single",               GET);

//PAGES 
Route::add("/adm/editor/:number",         "backoffice.pages",               "editor",                GET);
Route::add("/adm/editor/raw/:number",     "backoffice.pages",               "editor_raw",           GET);
Route::add("/adm/pages",                  "backoffice.pages",               "index",                GET);
Route::add("/adm/pages/:number",          "backoffice.pages",               "single",               GET);

//MENUS
Route::add("/adm/menus",                  "backoffice.menus",               "index",                GET);

//POPUPS
Route::add("/adm/popups",                 "backoffice.popups",              "index",                GET);
Route::add("/adm/popups/:number",         "backoffice.popups",              "single",               GET);

//PARTNERS
Route::add("/adm/partners",               "backoffice.partners",             "index",                GET);
Route::add("/adm/partners/add",           "backoffice.partners",             "insert",               GET);
Route::add("/adm/partners/:number",       "backoffice.partners",             "single",               GET);

//BANNERS
Route::add("/adm/banners",                "backoffice.banners",             "index",                GET);

//CATEGORIES
Route::add("/adm/categories",                       "backoffice.categories",          "index",                GET);
Route::add("/adm/categories_news",                  "backoffice.categories_news",     "index",                GET);
Route::add("/adm/categories_jobs",                  "backoffice.categories_jobs",     "index",                GET);
Route::add("/adm/categories_constructions",         "backoffice.categories",          "categories_constructions",        GET);

//CKEDITOR
Route::add("/adm/ckeditor",               "api.files",                      "ckeditor",             POST);

//TESTIMONIES
Route::add("/adm/testimonies",            "backoffice.testimonies",         "index",                GET);
Route::add("/adm/testimonies/:number",    "backoffice.testimonies",         "single",               GET);
Route::add("/adm/testimonies/add",        "backoffice.testimonies",         "insert",               GET);

//ALERTS
Route::add("/adm/alerts",                  "backoffice.alerts",             "index",                GET);
Route::add("/adm/alerts/:number",          "backoffice.alerts",             "single",               GET);
Route::add("/adm/alerts/add",              "backoffice.alerts",             "insert",               GET);

//RANKING BLOCKS
Route::add("/adm/ranking_blocks",                  "backoffice.ranking_blocks",             "index",                GET);
Route::add("/adm/ranking_blocks/:number",          "backoffice.ranking_blocks",             "single",               GET);
Route::add("/adm/ranking_blocks/add",              "backoffice.ranking_blocks",             "insert",               GET);

//CYCLES BLOCKS
Route::add("/adm/cycles_blocks",                  "backoffice.cycles_blocks",             "index",                GET);
Route::add("/adm/cycles_blocks/:number",          "backoffice.cycles_blocks",             "single",               GET);
Route::add("/adm/cycles_blocks/add",              "backoffice.cycles_blocks",             "insert",               GET);


//DOCUMENTS
Route::add("/adm/documents",                 "backoffice.documents",          "index",                GET);
Route::add("/adm/documents/:number",         "backoffice.documents",          "single",               GET);
Route::add("/adm/documents/add",             "backoffice.documents",          "insert",               GET);


//CONTACTS   
Route::add("/adm/contacts",                 "backoffice.contacts",           "index",                GET);
Route::add("/adm/contacts/:number",         "backoffice.contacts",           "single",               GET);
Route::add("/adm/contacts/:number",         "backoffice.contacts",           "delete",               DELETE);

//NEWSLETTER
Route::add("/adm/newsletter",               "backoffice.newsletter",         "index",                GET);
Route::add("/adm/newsletter/:number",       "backoffice.newsletter",         "delete",               DELETE);

//ORDERS
Route::add("/adm/orders",                   "backoffice.orders",             "index",                GET);
Route::add("/adm/orders/show/:number",      "backoffice.orders",             "show",                 GET);

//TEAM
Route::add("/adm/team",                     "backoffice.team",               "index",                GET);
Route::add("/adm/products/:number",         "backoffice.team",               "single",               GET);
Route::add("/adm/galleries/:number",         "backoffice.team",               "single",               GET);
Route::add("/adm/team/add",                 "backoffice.team",               "insert",               GET);      

//SETTINGS
Route::add("/adm/config",                   "backoffice.config",             "index",                GET);

//TICKETS   
Route::add("/adm/tickets",                  "backoffice.tickets",            "index",                GET);
Route::add("/adm/tickets/:number",          "backoffice.tickets",            "show",                 GET);

//PRODUCTS      
Route::add("/adm/products",                 "backoffice.products",           "index",                GET);
Route::add("/adm/products/:number",         "backoffice.products",           "single",               GET);
Route::add("/adm/products/add",             "backoffice.products",           "insert",               GET);

//GALLERY
Route::add("/adm/galleries",                 "backoffice.galleries",          "index",                GET);
Route::add("/adm/galleries/:number",         "backoffice.galleries",          "single",               GET);
Route::add("/adm/galleries/add",             "backoffice.galleries",          "insert",               GET);

//Personalization
Route::add("/adm/personalization",          "backoffice.personalization",    "index",                GET);
Route::add("/adm/personalization/:number",  "backoffice.personalization",    "single",               GET);

//TRANSLATIONS
Route::add("/adm/translations/:number",      "backoffice.translations",      "single",               GET);


