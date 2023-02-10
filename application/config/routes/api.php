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

//IMAGE UPLOAD GALLERY
Route::add("/api/image/dropzone_gallery",               "api.files",                "dropzone_gallery",                 POST);
Route::add("/api/image/dropzone_gallery/:number",       "api.files",                "remove_gallery",                   DELETE);
Route::add("/api/image/order_gallery",                  "api.files",                "order_gallery",                    PUT);

//PRODUCTS
Route::add("/api/products",                     "api.products",             "index",                    GET);
Route::add("/api/products/export/csv",          "api.products",             "exportProducts",           GET);
Route::add("/api/products/featured",            "api.products",             "index_featured",           GET);
Route::add("/api/products",                     "api.products",             "insert",                   POST);
Route::add("/api/products/sortable",            "api.products",             "ordenation",               POST);
Route::add("/api/productsClone",                "api.products",             "clone",                    POST);
Route::add("/api/products/:number",             "api.products",             "single",                   GET);
Route::add("/api/products/:number",             "api.products",             "edit",                     POST);
Route::add("/api/productsChangeStatus",         "api.products",             "changeStatus",             POST);
Route::add("/api/products/:number",             "api.products",             "delete",                   DELETE);
Route::add("/api/products_multiple",            "api.products",             "deleteMultiple",           POST);
Route::add("/api/advancedProducts/product/:number",  "api.products",        "advancedProductsByProduct",GET);
Route::add("/api/advancedProducts/:number",     "api.products",             "singleAdvancedProducts",   GET);
Route::add("/api/advancedProduct",              "api.products",             "insertAdvancedProduct",    POST);
Route::add("/api/advancedProduct/:number",      "api.products",             "editAdvancedProduct",      POST);
Route::add("/api/advancedProduct/:number",      "api.products",             "deleteAdvancedProduct",    DELETE);
Route::add("/api/advancedProduct/sortable",     "api.products",             "ordenation_adv",           POST);


//GALLERIES
Route::add("/api/galleries",                     "api.galleries",             "index",                    GET);
Route::add("/api/galleries/featured",            "api.galleries",             "index_featured",           GET);
Route::add("/api/galleries",                     "api.galleries",             "insert",                   POST);
Route::add("/api/galleries/:number",             "api.galleries",             "single",                   GET);
Route::add("/api/galleries/:number",             "api.galleries",             "edit",                     POST);
Route::add("/api/galleries/:number",             "api.galleries",             "delete",                   DELETE);
Route::add("/api/advancedGalleries/gallery/:number",  "api.galleries",        "advancedGalleriesByGallery", GET);
Route::add("/api/advancedGalleries/:number",     "api.galleries",             "singleAdvancedGalleries",   GET);
Route::add("/api/advancedGallery",              "api.galleries",              "insertAdvancedGallery",    POST);
Route::add("/api/advancedGallery/:number",      "api.galleries",              "editAdvancedGallery",      POST);
Route::add("/api/advancedGallery/:number",      "api.galleries",              "deleteAdvancedGallery",    DELETE);
Route::add("/api/galleriesChangeStatus",        "api.galleries",              "changeStatus",             POST);
Route::add("/api/galleries_multiple",           "api.galleries",              "deleteMultiple",           POST);
Route::add("/api/galleriesClone",               "api.galleries",              "clone",                    POST);

//SERVICES
Route::add("/api/services",                     "api.services",             "index",                    GET);
Route::add("/api/services/featured",            "api.services",             "index_featured",           GET);
Route::add("/api/services",                     "api.services",             "insert",                   POST);
Route::add("/api/services/:number",             "api.services",             "single",                   GET);
Route::add("/api/services/:number",             "api.services",             "edit",                     POST);
Route::add("/api/services/:number",             "api.services",             "delete",                   DELETE);
Route::add("/api/servicesChangeStatus",         "api.services",             "changeStatus",             POST);
Route::add("/api/services_multiple",            "api.services",             "deleteMultiple",           POST);
Route::add("/api/servicesClone",                "api.services",             "clone",                    POST);

//CUSTOM_PAGE
Route::add("/api/custom_page",                  "api.custom_page",          "index",                    GET);
Route::add("/api/custom_page/featured",         "api.custom_page",          "index_featured",           GET);
Route::add("/api/custom_page",                  "api.custom_page",          "insert",                   POST);
Route::add("/api/custom_page/:number",          "api.custom_page",          "single",                   GET);
Route::add("/api/custom_page/:number",          "api.custom_page",          "edit",                     POST);
Route::add("/api/custom_page/:number",          "api.custom_page",          "delete",                   DELETE);
Route::add("/api/custom_pageChangeStatus",      "api.custom_page",          "changeStatus",             POST);
Route::add("/api/custom_page_multiple",         "api.custom_page",          "deleteMultiple",           POST);
Route::add("/api/custom_pageClone",             "api.custom_page",          "clone",                    POST);


//CUSTOM_INFO
Route::add("/api/custom_info",                  "api.custom_info",          "index",                    GET);
Route::add("/api/custom_info/featured",         "api.custom_info",          "index_featured",           GET);
Route::add("/api/custom_info",                  "api.custom_info",          "insert",                   POST);
Route::add("/api/custom_info/:number",          "api.custom_info",          "single",                   GET);
Route::add("/api/custom_info/:number",          "api.custom_info",          "edit",                     POST);
Route::add("/api/custom_info/:number",          "api.custom_info",          "delete",                   DELETE);
Route::add("/api/custom_infoChangeStatus",      "api.custom_info",          "changeStatus",             POST);
Route::add("/api/custom_info_multiple",         "api.custom_info",          "deleteMultiple",           POST);
Route::add("/api/custom_infoClone",             "api.custom_info",          "clone",                    POST);


//FILTERS
Route::add("/api/filters",                      "api.filters",             "index",                    GET);
Route::add("/api/filters/featured",             "api.filters",             "index_featured",           GET);
Route::add("/api/filters",                      "api.filters",             "insert",                   POST);
Route::add("/api/filters/:number",              "api.filters",             "single",                   GET);
Route::add("/api/filters/:number",              "api.filters",             "edit",                     POST);
Route::add("/api/filters/:number",              "api.filters",             "delete",                   DELETE);
Route::add("/api/filtersChangeStatus",          "api.filters",             "changeStatus",             POST);
Route::add("/api/filters_multiple",             "api.filters",             "deleteMultiple",           POST);
Route::add("/api/filtersClone",                 "api.filters",             "clone",                    POST);
Route::add("/api/filters/sortable",             "api.filters",             "ordenation",               POST);


//COUPONS
Route::add("/api/coupons",                     "api.coupons",             "index",                    GET);
Route::add("/api/coupons",                     "api.coupons",             "insert",                   POST);
Route::add("/api/coupons/:number",             "api.coupons",             "single",                   GET);
Route::add("/api/coupons/:number",             "api.coupons",             "edit",                     POST);
Route::add("/api/coupons/:number",             "api.coupons",             "delete",                   DELETE);
Route::add("/api/coupons_multiple",            "api.coupons",             "deleteMultiple",           POST);
Route::add("/api/couponsClone",                "api.coupons",             "clone",                    POST);

//BRANDS
Route::add("/api/brands",                      "api.brands",             "index",                    GET);
Route::add("/api/brands",                      "api.brands",             "insert",                   POST);
Route::add("/api/brandsActive/:number",        "api.brands",             "active",                   GET);
Route::add("/api/brands/:number",              "api.brands",             "single",                   GET);
Route::add("/api/brands/:number",              "api.brands",             "edit",                     POST);
Route::add("/api/brands/:number",              "api.brands",             "delete",                   DELETE);
Route::add("/api/brands/sortable",             "api.brands",             "ordenation",               POST);
Route::add("/api/brands_multiple",             "api.brands",             "deleteMultiple",           POST);
Route::add("/api/brandsClone",                 "api.brands",             "clone",                    POST);

//imported datas
Route::add("/api/imported_datas",                       "api.imported_datas",      "insert",                     POST);
Route::add("/api/imported_datas/:alpha",                "api.imported_datas",      "get",                        GET);
Route::add("/api/historic/get",                         "api.imported_datas",      "getHistoric",                GET);

//HOMEPAGE
Route::add("/api/homepage",                      "api.homepages",             "index",                    GET);
Route::add("/api/homepageActive/:number",        "api.homepages",             "active",                   GET);
Route::add("/api/homepage/:number",              "api.homepages",             "single",                   GET);
Route::add("/api/homepage/sortable",             "api.homepages",             "ordenation",               POST);
Route::add("/api/homepage/:number",              "api.homepages",             "edit",                     POST);

//CONSTRUCTIONS
Route::add("/api/constructions",                     "api.constructions",             "index",                    GET);
Route::add("/api/constructions/featured",            "api.constructions",             "index_featured",           GET);
Route::add("/api/constructions",                     "api.constructions",             "insert",                   POST);
Route::add("/api/constructions/:number",             "api.constructions",             "single",                   GET);
Route::add("/api/constructions/:number",             "api.constructions",             "edit",                     POST);
Route::add("/api/constructions/:number",             "api.constructions",             "delete",                   DELETE);
Route::add("/api/constructions/sortable",            "api.constructions",             "ordenation",               POST);
Route::add("/api/constructionsChangeStatus",         "api.constructions",             "changeStatus",             POST);
Route::add("/api/constructions_multiple",            "api.constructions",             "deleteMultiple",           POST);
Route::add("/api/constructionsClone",                "api.constructions",             "clone",                    POST);

//CALLBACKS
Route::add("/api/ifthenpay",                     "api.products",             "index",                    GET);
Route::add("/api/products",                     "api.products",             "index",                    GET);
Route::add("/api/products",                     "api.products",             "index",                    GET);

//CALLBACKS GALLERIES
Route::add("/api/ifthenpay",                     "api.galleries",             "index",                    GET);
Route::add("/api/galleries",                     "api.galleries",             "index",                    GET);
Route::add("/api/galleries",                     "api.galleries",             "index",                    GET);

//PERSONALIZATION
Route::add("/api/personalizationItems",         "api.personalization",      "indexItems",               GET);
Route::add("/api/personalizationItems/:number", "api.personalization",      "singleItems",              GET);
Route::add("/api/personalizationItems",         "api.personalization",      "insertItem",               POST);
Route::add("/api/personalizationItems/:number", "api.personalization",      "editItem",                 POST);
Route::add("/api/personalizationItems/:number", "api.personalization",      "deleteItem",               DELETE);
Route::add("/api/personalization",              "api.personalization",      "index",                    GET);
Route::add("/api/personalizationByLanguage/:alpha",    "api.personalization",      "indexByLanguage",          GET);
Route::add("/api/personalization/:number",      "api.personalization",      "single",                   GET);
Route::add("/api/personalization/:number",      "api.personalization",      "edit",                     PUT);
Route::add("/api/personalization",              "api.personalization",      "insert",                   POST);
Route::add("/api/personalization/:number",      "api.personalization",      "delete",                   DELETE);
Route::add("/api/personalizationChangeStatus",  "api.personalization",      "changeStatus",             POST);
Route::add("/api/personalization_multiple",     "api.personalization",      "deleteMultiple",           POST);

/* Route::add("/api/jobs/images",                     "jobs.import",             "productImages",                    GET);
Route::add("/api/jobs/categories",                     "jobs.import",             "categories",                    GET);
Route::add("/api/jobs/products",                     "jobs.import",             "products",                    GET);
 */
//SHIPPING
Route::add("/api/shipping",                     "api.shipping",             "index",                    GET);
Route::add("/api/shipping",                     "api.shipping",             "insert",                   POST);
Route::add("/api/shipping/:number",             "api.shipping",             "single",                   GET);
Route::add("/api/shipping/:number",             "api.shipping",             "edit",                     POST);
Route::add("/api/shipping/:number",             "api.shipping",             "delete",                   DELETE);

//PAYMENT
Route::add("/api/payment",                      "api.payment",              "index",                    GET);
Route::add("/api/payment/:number",              "api.payment",              "single",                   GET);
Route::add("/api/payment/:number",              "api.payment",              "edit",                     POST);

//ATTRIBUTES
Route::add("/api/attributes/products/:number",  "api.attributes",           "index",                    GET);
Route::add("/api/attributes/galleries/:number", "api.attributes",           "index",                    GET);
Route::add("/api/attributes",                   "api.attributes",           "insert",                   POST);
Route::add("/api/attributes/:number",           "api.attributes",           "delete",                   DELETE);
Route::add("/api/attributes/:number",           "api.attributes",           "single",                   GET);
Route::add("/api/attributes/update",            "api.attributes",           "update",                   POST);
Route::add("/api/attributes/sortable",          "api.attributes",           "ordenation",               POST);

//ATTRIBUTES_CONSTRUCTIONS
Route::add("/api/attributes_constructions/constructions/:number","api.attributes_constructions",           "index",                    GET);
Route::add("/api/attributes_constructions/galleries/:number", "api.attributes_constructions",           "index",                    GET);
Route::add("/api/attributes_constructions",                   "api.attributes_constructions",           "insert",                   POST);
Route::add("/api/attributes_constructions/:number",           "api.attributes_constructions",           "delete",                   DELETE);
Route::add("/api/attributes_constructions/:number",           "api.attributes_constructions",           "single",                   GET);
Route::add("/api/attributes_constructions/update",            "api.attributes_constructions",           "update",                   POST);
Route::add("/api/attributes_constructions/sortable",          "api.attributes_constructions",           "ordenation",               POST);


//ATTRIBUTES
Route::add("/api/discounts/products/:number",   "api.discounts",            "index",                    GET);
Route::add("/api/discounts/galleries/:number",   "api.discounts",            "index",                    GET);
Route::add("/api/discounts",                    "api.discounts",            "insert",                   POST);
Route::add("/api/discounts/:number",            "api.discounts",            "delete",                   DELETE);
                            
//ORDERS
Route::add("/api/orders",                       "api.orders",               "index",                    GET);
Route::add("/api/orders/:number",               "api.orders",               "singleAll",                GET);
Route::add("/api/orders/:number",               "api.orders",               "edit",                     POST);
Route::add("/api/orders/:number",               "api.orders",               "delete",                   DELETE);
Route::add("/api/orders/client/:number",        "api.orders",               "ordersByClient",            GET);
Route::add("/api/orders/historic",             "api.orders",               "insertStatusInHistoric",    POST);

//ORDER_STATUS
Route::add("/api/orderStatus",                 "api.orderstatus",         "index",                    GET);
Route::add("/api/orderStatus/:number",         "api.orderstatus",         "single",                   GET);
Route::add("/api/orderStatus",                 "api.orderstatus",         "insert",                   POST);
Route::add("/api/orderStatus/:number",         "api.orderstatus",         "edit",                     POST);
Route::add("/api/orderStatus/:number",         "api.orderstatus",         "delete",                   DELETE);

//CLIENTS   
Route::add("/api/clients",                      "api.clients",              "index",                    GET);
Route::add("/api/clients",                      "api.clients",              "insert",                   POST);
Route::add("/api/clients/:number",              "api.clients",              "single",                   GET);
Route::add("/api/clients/:number",              "api.clients",              "edit",                     POST);
Route::add("/api/clients/:number",              "api.clients",              "delete",                   DELETE);
Route::add("/api/clients_multiple",             "api.clients",              "deleteMultiple",           POST);

//PAGES   
Route::add("/api/pages",                      "api.pages",              "index",                    GET);
Route::add("/api/pages",                      "api.pages",              "insert",                   POST);
Route::add("/api/pages/:number",              "api.pages",              "single",                   GET);
Route::add("/api/pages/:number",              "api.pages",              "edit",                     POST);
Route::add("/api/pages/:number",              "api.pages",              "delete",                   DELETE);
Route::add("/api/pagesChangeStatus",          "api.pages",              "changeStatus",             POST);
Route::add("/api/pages_multiple",             "api.pages",              "deleteMultiple",           POST);
Route::add("/api/pagesClone",                 "api.pages",              "clone",                    POST);


//SITEMAP
Route::add("/api/sitemap",                    "api.sitemap",          "generator",                   POST);
Route::add("/api/sitemap/cron",               "api.sitemap",          "sitemapCron",                 GET);



//DOCUMENTS   
Route::add("/api/documents",                      "api.documents",              "index",                    GET);
Route::add("/api/documents",                      "api.documents",              "insert",                   POST);
Route::add("/api/documents/:number",              "api.documents",              "single",                   GET);
Route::add("/api/documents/:number",              "api.documents",              "edit",                     POST);
Route::add("/api/documents/:number",              "api.documents",              "delete",                   DELETE);
Route::add("/api/documentsChangeStatus",          "api.documents",              "changeStatus",             POST);
Route::add("/api/documents_multiple",             "api.documents",              "deleteMultiple",           POST);


//TESTIMONIES   
Route::add("/api/testimonies",                      "api.testimonies",           "index",                    GET);
Route::add("/api/testimonies",                      "api.testimonies",           "insert",                   POST);
Route::add("/api/testimonies/:number",              "api.testimonies",           "single",                   GET);
Route::add("/api/testimonies/:number",              "api.testimonies",           "edit",                     POST);
Route::add("/api/testimonies/:number",              "api.testimonies",           "delete",                   DELETE);
Route::add("/api/testimoniesChangeStatus",          "api.testimonies",           "changeStatus",             POST);
Route::add("/api/testimonies_multiple",             "api.testimonies",           "deleteMultiple",           POST);
Route::add("/api/testimoniesClone",                 "api.testimonies",           "clone",                    POST);
Route::add("/api/testimonies/sortable",             "api.testimonies",           "ordenation",               POST);

//ALERTS   
Route::add("/api/alerts",                           "api.alerts",           "index",                    GET);
Route::add("/api/alerts",                           "api.alerts",           "insert",                   POST);
Route::add("/api/alerts/:number",                   "api.alerts",           "single",                   GET);
Route::add("/api/alerts/:number",                   "api.alerts",           "edit",                     POST);
Route::add("/api/alerts/:number",                   "api.alerts",           "delete",                   DELETE);
Route::add("/api/alertsChangeStatus",               "api.alerts",           "changeStatus",             POST);
Route::add("/api/alerts_multiple",                  "api.alerts",           "deleteMultiple",           POST);
Route::add("/api/alertsClone",                      "api.alerts",           "clone",                    POST);


//RANKING BLOCKS   
Route::add("/api/ranking_blocks",                           "api.ranking_blocks",           "index",                    GET);
Route::add("/api/ranking_blocks",                           "api.ranking_blocks",           "insert",                   POST);
Route::add("/api/ranking_blocks/:number",                   "api.ranking_blocks",           "single",                   GET);
Route::add("/api/ranking_blocks/:number",                   "api.ranking_blocks",           "edit",                     POST);
Route::add("/api/ranking_blocks/:number",                   "api.ranking_blocks",           "delete",                   DELETE);
Route::add("/api/blocksActive/:number",                     "api.ranking_blocks",           "active",                   GET);

//CYCLES BLOCKS   
Route::add("/api/cycles_blocks",                           "api.cycles_blocks",           "index",                    GET);
Route::add("/api/cycles_blocks",                           "api.cycles_blocks",           "insert",                   POST);
Route::add("/api/cycles_blocks/:number",                   "api.cycles_blocks",           "single",                   GET);
Route::add("/api/cycles_blocks/:number",                   "api.cycles_blocks",           "edit",                     POST);
Route::add("/api/cycles_blocks/:number",                   "api.cycles_blocks",           "delete",                   DELETE);
Route::add("/api/cyclesActive/:number",                    "api.cycles_blocks",           "active",                   GET);


//info-form
Route::add("/api/info-form",                        "api.info_form",             "index",                    GET);
Route::add("/api/info-form/:number",                "api.info_form",             "delete",                   DELETE);

                                                    
//CATEGORIES 
Route::add("/api/categories",                       "api.categories",           "index",                    GET);
Route::add("/api/categories",                       "api.categories",           "insert",                   POST);
Route::add("/api/categories/asc",                   "api.categories",           "orderASC",                 POST);
Route::add("/api/categories/:number",               "api.categories",           "edit",                     PUT);
Route::add("/api/order_categories",                 "api.categories",           "ordenation",               POST);
Route::add("/api/categories/:number",               "api.categories",           "delete",                   DELETE);

//CATEGORIES NEWS
Route::add("/api/categories_news",                       "api.categories_news",           "index",                    GET);
Route::add("/api/categories_news",                       "api.categories_news",           "insert",                   POST);
Route::add("/api/categories_news/asc",                   "api.categories_news",           "orderASC",                 POST);
Route::add("/api/categories_news/:number",               "api.categories_news",           "edit",                     PUT);
Route::add("/api/order_categories_news",                 "api.categories_news",           "ordenation",               POST);
Route::add("/api/categories_news/:number",               "api.categories_news",           "delete",                   DELETE);


//CATEGORIES JOBS
Route::add("/api/categories_jobs",                       "api.categories_jobs",           "index",                    GET);
Route::add("/api/categories_jobs",                       "api.categories_jobs",           "insert",                   POST);
Route::add("/api/categories_jobs/asc",                   "api.categories_jobs",           "orderASC",                 POST);
Route::add("/api/categories_jobs/:number",               "api.categories_jobs",           "edit",                     PUT);
Route::add("/api/order_categories_jobs",                 "api.categories_jobs",           "ordenation",               POST);
Route::add("/api/categories_jobs/:number",               "api.categories_jobs",           "delete",                   DELETE);
Route::add("/api/categories_jobs/cron",                  "api.categories_jobs",           "associateJobCron",         GET);


//FILTER ITEMS 
Route::add("/api/filter_items/:number",             "api.filter_items",         "index",                    GET);
Route::add("/api/filters/cron",                     "api.filter_items",         "associateProductCron",     GET);
Route::add("/api/filter_items/:number",             "api.filter_items",         "insert",                   POST);
Route::add("/api/filter_items/asc",                 "api.filter_items",         "orderASC",                 POST);
Route::add("/api/filter_items/:number",             "api.filter_items",         "edit",                     PUT);
Route::add("/api/order_filter_items",               "api.filter_items",         "ordenation",               POST);
Route::add("/api/filter_items/:number",             "api.filter_items",         "delete",                   DELETE);


//JOBS
Route::add("/api/jobs",                     "api.jobs",         "index",                    GET);
Route::add("/api/jobs/:number",             "api.jobs",         "single",                   GET);
Route::add("/api/jobs",                     "api.jobs",         "insert",                   POST);
Route::add("/api/jobs/asc",                 "api.jobs",         "orderASC",                 POST);
Route::add("/api/jobs/:number",             "api.jobs",         "edit",                     POST);
Route::add("/api/order_jobs",               "api.jobs",         "ordenation",               POST);
Route::add("/api/jobs/:number",             "api.jobs",         "delete",                   DELETE);
Route::add("/api/jobs_multiple",            "api.jobs",         "deleteMultiple",           POST);
Route::add("/api/jobsClone",                "api.jobs",         "clone",                    POST);
Route::add("/api/jobsChangeStatus",         "api.jobs",         "changeStatus",             POST);

//CATEGORIES CONSTRUCTIONS
Route::add("/api/categories_constructions",                       "api.categories_constructions",           "index",                    GET);
Route::add("/api/categories_constructions",                       "api.categories_constructions",           "insert",                   POST);
Route::add("/api/categories_constructions/:number",               "api.categories_constructions",           "edit",                     PUT);
Route::add("/api/order_categories_constructions",                 "api.categories_constructions",           "ordenation",               POST);
Route::add("/api/categories_constructions/:number",               "api.categories_constructions",           "delete",                   DELETE);
Route::add("/api/categories_constructions/cron",                  "api.categories_constructions",           "associateConstructionCron",     GET);

//CATEGORIES GALLERIES
Route::add("/api/categories_galleries",              "api.categories_galleries",           "index",                    GET);
Route::add("/api/categories_galleries",              "api.categories_galleries",           "insert",                   POST);
Route::add("/api/categories_galleries/:number",      "api.categories_galleries",           "edit",                     PUT);
Route::add("/api/categories_galleries/:number",      "api.categories_galleries",           "delete",                   DELETE);

//MENUS
Route::add("/api/menus",                        "api.menus",           "index",                    GET);
Route::add("/api/menus/:number",                "api.menus",           "single",                   GET);
Route::add("/api/menus",                        "api.menus",           "insert",                   POST);
Route::add("/api/menus/changeActive",           "api.menus",           "active",                   POST);
Route::add("/api/menus_update/:number",         "api.menus",           "edit",                     POST);
Route::add("/api/menus/:number",                "api.menus",           "delete",                   DELETE);
Route::add("/api/order_menus",                  "api.menus",           "ordenation",               POST);
Route::add("/api/searchAjax",                   "api.menus",           "searchAjax",                GET);

//POPUPS
Route::add("/api/popups",                       "api.popups",           "index",                    GET);
Route::add("/api/popups/:number",               "api.popups",           "single",                   GET);
Route::add("/api/popups",                       "api.popups",           "insert",                   POST);
Route::add("/api/popups_update/:number",        "api.popups",           "edit",                     POST);
Route::add("/api/popups/:number",               "api.popups",           "delete",                   DELETE);
Route::add("/api/popups_multiple",              "api.popups",           "deleteMultiple",           POST);
Route::add("/api/popupsClone",                  "api.popups",           "clone",                    POST);

//PARTNERS
Route::add("/api/partners",                      "api.partners",             "index",                    GET);
Route::add("/api/partners",                      "api.partners",             "insert",                   POST);
Route::add("/api/partners/:number",              "api.partners",             "single",                   GET);
Route::add("/api/partners/:number",              "api.partners",             "edit",                     POST);
Route::add("/api/partners/:number",              "api.partners",             "delete",                   DELETE);
Route::add("/api/partners/sortable",             "api.partners",             "ordenation",               POST);
Route::add("/api/partners_multiple",             "api.partners",             "deleteMultiple",           POST);
Route::add("/api/partnersClone",                 "api.partners",             "clone",                    POST);
                                                
//CONFIG 
Route::add("/api/config",                       "api.config",               "multiple",                 GET);
Route::add("/api/config/:alpha",                "api.config",               "update",                   PUT);
                                            
//TRANSLATIONS  
Route::add("/api/translations",                 "api.translations",         "multiple",                 GET);
Route::add("/api/translations",                 "api.translations",         "insert_language",          POST);
Route::add("/api/translations/:number",         "api.translations",         "single",                   GET);
Route::add("/api/translations/:alpha",          "api.translations",         "update",                   POST);
Route::add("/api/translations/:alpha",          "api.translations",         "delete",                   DELETE);
Route::add("/api/translations/:alpha",          "api.translations",         "delete_language",          DELETE);

//CONTACTS  
Route::add("/api/contacts",                     "api.contacts",             "index",                    GET);
Route::add("/api/contacts/:number",             "api.contacts",             "delete",                   DELETE);
                            
//NEWSLETTER 
Route::add("/api/newsletter",                   "api.newsletter",           "index",                    GET);
Route::add("/api/newsletter/:number",           "api.newsletter",           "delete",                   DELETE);
Route::add("/api/newsletter",                   "api.newsletter",           "insert",                   PUT);
Route::add("/api/newsletter_multiple",          "api.newsletter",           "deleteMultiple",           POST);
Route::add("/api/newsletter/export",            "api.newsletter",           "multiple",                 GET);


                  
//NEWS
Route::add("/api/news",                         "api.news",                 "index",                    GET);
Route::add("/api/news",                         "api.news",                 "insert",                   POST);
Route::add("/api/news/:number",                 "api.news",                 "single",                   GET);
Route::add("/api/news/:number",                 "api.news",                 "edit",                     POST);
Route::add("/api/news/:number",                 "api.news",                 "delete",                   DELETE);
Route::add("/api/newsChangeStatus",             "api.news",                 "changeStatus",             POST);
Route::add("/api/news_multiple",                "api.news",                 "deleteMultiple",           POST);
Route::add("/api/newsClone",                    "api.news",                 "clone",                    POST);
Route::add("/api/news/sortable",                "api.news",                 "ordenation",               POST);


//SCHEDULE
Route::add("/api/schedule",                         "api.schedule",                 "index",                    GET);
Route::add("/api/schedule",                         "api.schedule",                 "insert",                   POST);
Route::add("/api/schedule/:number",                 "api.schedule",                 "single",                   GET);
Route::add("/api/schedule/:number",                 "api.schedule",                 "edit",                     POST);
Route::add("/api/schedule/:number",                 "api.schedule",                 "delete",                   DELETE);
Route::add("/api/scheduleChangeStatus",             "api.schedule",                 "changeStatus",             POST);
Route::add("/api/schedule_multiple",                "api.schedule",                 "deleteMultiple",           POST);
Route::add("/api/scheduleClone",                    "api.schedule",                 "clone",                    POST);
Route::add("/api/schedule/sortable",                "api.schedule",                 "ordenation",               POST);

//RECRUITMENTS
Route::add("/api/recruitments",                         "api.recruitments",                 "index",                    GET);
Route::add("/api/recruitments",                         "api.recruitments",                 "insert",                   POST);
Route::add("/api/recruitments/:number",                 "api.recruitments",                 "single",                   GET);
Route::add("/api/recruitments/:number",                 "api.recruitments",                 "edit",                     POST);
Route::add("/api/recruitments/:number",                 "api.recruitments",                 "delete",                   DELETE);
Route::add("/api/recruitmentsChangeStatus",             "api.recruitments",                 "changeStatus",             POST);
Route::add("/api/recruitments_multiple",                "api.recruitments",                 "deleteMultiple",           POST);
Route::add("/api/recruitmentsClone",                    "api.recruitments",                 "clone",                    POST);


//TICKETS
Route::add("/api/tickets",                      "api.tickets",              "index",                    GET);
Route::add("/api/tickets/clients/:number",      "api.tickets",              "ticketsByClient",          GET);
Route::add("/api/tickets/messages/:number",     "api.tickets",              "messagesByTicket",         GET);
Route::add("/api/tickets/:number",              "api.tickets",              "single",                   GET);
Route::add("/api/tickets/:number",              "api.tickets",              "editStatus",               POST);
Route::add("/api/tickets",                      "api.tickets",              "insert",                   POST);
Route::add("/api/tickets/messages",             "api.tickets",              "insertMessage",            POST);
Route::add("/api/tickets/:number",              "api.tickets",              "delete",                   DELETE);
Route::add("/api/tickets/message/:number",      "api.tickets",              "deleteMessage",            DELETE);
Route::add("/api/tickets_multiple",             "api.tickets",              "deleteMultiple",           POST);


//BANNERS
Route::add("/api/banners",                      "api.banners",              "index",                    GET);
Route::add("/api/banners",                      "api.banners",              "insert",                   POST);
Route::add("/api/banners/:number",              "api.banners",              "single",                   GET);
Route::add("/api/banners/:number",              "api.banners",              "edit",                     POST);
Route::add("/api/banners/:number",              "api.banners",              "delete",                   DELETE);
Route::add("/api/bannersChangeStatus",          "api.banners",              "changeStatus",             POST);
Route::add("/api/banners_multiple",             "api.banners",              "deleteMultiple",           POST);
Route::add("/api/bannersClone",                 "api.banners",              "clone",                    POST);
Route::add("/api/banners/sortable",             "api.banners",              "ordenation",               POST);
Route::add("/api/bannersActive/:number",        "api.banners",              "active",                   GET);

//FAQ'S
Route::add("/api/faqs",                         "api.faqs",                 "index",                    GET);
Route::add("/api/faqs",                         "api.faqs",                 "insert",                   POST);
Route::add("/api/faqs/:number",                 "api.faqs",                 "single",                   GET);
Route::add("/api/faqs/:number",                 "api.faqs",                 "edit",                     POST);
Route::add("/api/faqs/:number",                 "api.faqs",                 "delete",                   DELETE);

//IMAGE UPLOAD
Route::add("/api/image/slim",                   "api.files",                "slim",                     POST);
Route::add("/api/image/dropzone",               "api.files",                "dropzone",                 POST);
Route::add("/api/image/edit",                   "api.files",                "updateFile",               POST);
Route::add("/api/image/edit_news",              "api.files",                "updateFileNews",           POST);
Route::add("/api/image/dropzone/:number",       "api.files",                "remove",                   DELETE);
Route::add("/api/image/order",                  "api.files",                "order",                    PUT);


//Users
Route::add("/api/users",                        "api.users",                "index",                    GET);
Route::add("/api/users",                        "api.users",                "insert",                   POST);
Route::add("/api/users/:number",                "api.users",                "single",                   GET);
Route::add("/api/users/:number",                "api.users",                "delete",                   DELETE);
Route::add("/api/users/:number",                "api.users",                "edit",                     POST);
Route::add("/api/usersChangeStatus",            "api.users",                "changeStatus",             POST);
Route::add("/api/users_multiple",               "api.users",                "deleteMultiple",           POST);

//Notifications
Route::add("/api/notifications",                "api.notifications",        "index",                                 GET);
Route::add("/api/notifications/:number",        "api.notifications",        "delete",                                DELETE);
Route::add("/api/notifications_multiple",       "api.notifications",        "deleteMultipleNotifications",           POST);

//Graph data
Route::add("/api/graph/sales",                  "api.graph",                "sales",                    GET);
Route::add("/api/graph/views",                  "api.graph",                "views",                    GET);

//TESTE SMTP
Route::add("/api/email/test",                   "api.test",                 "smtp",                     POST);

// CALLBACKS
Route::add("/callback/vivawallet/success",      "callbacks.vivawallet",      "success",                  GET);
Route::add("/callback/vivawallet/error",        "callbacks.vivawallet",      "error",                    GET);

//OBITUARIES
Route::add("/api/obituaries",                     "api.obituaries",             "index",                    GET);
Route::add("/api/obituaries/featured",            "api.obituaries",             "index_featured",           GET);
Route::add("/api/obituaries",                     "api.obituaries",             "insert",                   POST);
Route::add("/api/obituaries/:number",             "api.obituaries",             "single",                   GET);
Route::add("/api/obituaries/:number",             "api.obituaries",             "edit",                     POST);
Route::add("/api/obituaries/:number",             "api.obituaries",             "delete",                   DELETE);
Route::add("/api/obituaries/sortable",            "api.obituaries",             "ordenation",               POST);
Route::add("/api/obituariesChangeStatus",         "api.obituaries",             "changeStatus",             POST);
Route::add("/api/obituaries_multiple",            "api.obituaries",             "deleteMultiple",           POST);
Route::add("/api/obituariesClone",                "api.obituaries",             "clone",                    POST);
