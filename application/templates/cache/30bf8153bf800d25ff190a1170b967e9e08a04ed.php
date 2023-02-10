
<script src="/static/backoffice/javascript/jquery.js"></script>
<script src="/static/backoffice/javascript/jquery-ui.js"></script> 
<html lang="pt">
    <head></head>
        <meta charset="UTF-8">
        <title><?php echo json_decode($website_config->title, true)[$selected_language->code]; ?> | <?php echo $__env->yieldContent('title'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>
        <link rel="icon" type="image/png" href="/static/backoffice/images/favicon.ico">
        <link rel="stylesheet" href="/static/backoffice/css/style.css"/>
        <link rel="stylesheet" href="/static/backoffice/css/themes/dore.light.blue.css"/>
        <link rel="stylesheet" href="/static/backoffice/css/jquery-ui.css"/>
        <link rel="stylesheet" href="/static/backoffice/css/bootstrap-datepicker3.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />        
    </head>
    <body id="app-container" data-menu="default" class="show-spinner rounded menu-default sub-hidden">
        <style>

.ps{
touch-action: none !important;
}
        </style>
        <nav class="navbar fixed-top"
            style="display:flex;-ms-flex-wrap: wrap; flex-wrap: wrap; -webkit-box-align: center; -ms-flex-align: center; align-items: center; -webkit-box-pack: justify; -ms-flex-pack: justify; justify-content: space-between;">
            <div style="flex-basis: 40%;" class="d-flex align-items-center navbar-left">
                <a href="javascript:void(0)" class="menu-button d-none d-md-block">
                    <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                        <rect x="0.48" y="0.5" width="7" height="1"/>
                        <rect x="0.48" y="7.5" width="7" height="1"/>
                        <rect x="0.48" y="15.5" width="7" height="1"/>
                    </svg>
                    <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                        <rect x="1.56" y="0.5" width="16" height="1"/>
                        <rect x="1.56" y="7.5" width="16" height="1"/>
                        <rect x="1.56" y="15.5" width="16" height="1"/>
                    </svg>
                </a>
                <a href="javascript:void(0)" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                        <rect x="0.5" y="0.5" width="25" height="1"/>
                        <rect x="0.5" y="7.5" width="25" height="1"/>
                        <rect x="0.5" y="15.5" width="25" height="1"/>
                    </svg>
                </a>
            </div>
            <a href="/adm" style="flex-basis: 20%; width: 0" class="navbar-logo active">
                <div class="logo"
                    style="background: url(<?php echo e($website_config->logo); ?>) no-repeat; background-size: contain;"></div>
            </a>
            <div class="navbar-right">
                <div class="header-icons d-inline-block align-middle">
                    <button class="header-icon btn btn-empty d-none d-sm-inline-block" type="button" id="fullScreenButton">
                        <i class="simple-icon-size-fullscreen" style="display: inline;"></i>
                        <i class="simple-icon-size-actual" style="display: none;"></i>
                    </button>
                </div>
                <?php if(MODULES_CLIENTS): ?>
                <div class="position-relative d-inline-block header-icons align-middle">
                        <button class="header-icon btn btn-empty drop-clients" type="button" id="notificationButton">
                            <i class="simple-icon-people"></i>
                            <span class="count count-newClient"></span>
                        </button>
                        
                        <div class="dropdown-menu dropdown-menu-right mt-3 position-absolute scroll drop-clients2" id="notificationDropdown">
                            <div class="row mb-2">
                                <div class="col-6 align-self-center">
                                    <h3 class="mb-0"><?php echo e(ucfirst($translations["backoffice"]["clients"])); ?></h3>
                                </div>
                                <div class="btn-group col-6">
                                    <div class="btn btn-primary btn-xs btn-lg pl-3 pr-0">
                                        <label class="custom-control custom-checkbox mb-0 d-inline-block">
                                            <input type="checkbox" class="custom-control-input" id="checkAllClients">
                                            <span class="custom-control-label"></span>
                                        </label>
                                    </div>
                                    <button id="btnGroupDrop1" type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split botaodrop2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" onclick="deleteMultipleNotifications()"> <?php echo e(ucfirst($translations["backoffice"]["mark_selected_read"])); ?> <i class="simple-icon-ban pl-1 align-middle"></i></a>
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-3">
                            <div id="divNewClients"></div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(MODULES_ORDERS): ?>
                <div class="position-relative d-inline-block header-icons align-middle">
                        <button class="header-icon btn btn-empty drop-orders" type="button" id="notificationButton">
                            <i class="simple-icon-social-dropbox"></i>
                            <span class="count count-newOrders"></span>
                        </button>
                        
                        <div class="dropdown-menu dropdown-menu-right mt-3 position-absolute scroll drop-orders2" id="notificationDropdown">
                            <div class="row mb-2">
                                <div class="col-6 align-self-center">
                                    <h3 class="mb-0"><?php echo e(ucfirst($translations["backoffice"]["orders"])); ?></h3>
                                </div>
                                <div class="btn-group col-6">
                                    <div class="btn btn-primary btn-xs btn-lg pl-3 pr-0">
                                        <label class="custom-control custom-checkbox mb-0 d-inline-block">
                                            <input type="checkbox" class="custom-control-input" id="checkAllOrders">
                                            <span class="custom-control-label"></span>
                                        </label>
                                    </div>
                                    <button id="btnGroupDrop1" type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split botaodrop2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" onclick="deleteMultipleNotifications()"> <?php echo e(ucfirst($translations["backoffice"]["mark_selected_read"])); ?> <i class="simple-icon-ban pl-1 align-middle"></i></a>
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-3">
                            <div id="divNewOrders"></div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(MODULES_MESSAGES): ?>
                    <div class="position-relative d-inline-block header-icons align-middle">
                        <button class="header-icon btn btn-empty drop-messages" type="button" id="notificationButton">
                            <i class="simple-icon-envelope"></i>
                            <span class="count count-notifications"></span>
                        </button>
                        
                        <div class="dropdown-menu dropdown-menu-right mt-3 position-absolute scroll drop-messages2" id="notificationDropdown">
                            <div class="row mb-2">
                                <div class="col-6 align-self-center">
                                    <h3 class="mb-0"><?php echo e(ucfirst($translations["backoffice"]["messages"])); ?></h3>
                                </div>
                                <div class="btn-group col-6">
                                    <div class="btn btn-primary btn-xs btn-lg pl-3 pr-0">
                                        <label class="custom-control custom-checkbox mb-0 d-inline-block">
                                            <input type="checkbox" class="custom-control-input" id="checkAllMessages">
                                            <span class="custom-control-label"></span>
                                        </label>
                                    </div>
                                    <button id="btnGroupDrop1" type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split botaodrop2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" onclick="deleteMultipleNotifications()"> <?php echo e(ucfirst($translations["backoffice"]["mark_selected_read"])); ?> <i class="simple-icon-ban pl-1 align-middle"></i></a>
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-3">
                            <div id="divNotifications"></div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="user d-inline-block">
                    <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="name mt-2"></span>
                        <span><img src="/static/backoffice/images/users/user.png"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right-offset mt-1 account-dropdown">
                        <a class="dropdown-item" href="/">
                            <i class="simple-icon-basket p-2 w-40"></i> <?php echo e(ucfirst($translations["backoffice"]["store"])); ?>

                        </a>
                        <a class="dropdown-item" href="/adm/team">
                            <i class="simple-icon-user p-2 w-40"></i> <?php echo e(ucfirst($translations["backoffice"]["users"])); ?>

                        </a>
                        <a class="dropdown-item" href="/adm/config">
                            <i class="simple-icon-settings p-2 w-40"></i> <?php echo e(ucfirst($translations["backoffice"]["settings"])); ?>

                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/logout">
                            <i class="simple-icon-logout p-2 w-40"></i> <?php echo e(ucfirst($translations["auth"]["logout"])); ?>

                        </a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="sidebar">
            <div class="main-menu">
                <div class="scroll">
                    <ul class="list-unstyled">
                        <li>
                            <a href="/adm">
                                <i class="iconsmind-Home"></i><?php echo e(ucfirst($translations["backoffice"]["home"])); ?>

                            </a>
                        </li>
                        <?php if(MODULES_COUPONS): ?>
                        <li>
                            <a href="/adm/coupons">
                                <i class="iconsmind-pantone"></i>Coupons
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_ORDERS): ?>
                        <li>
                            <a href="/adm/orders">
                                <i class="iconsmind-Box-Close"></i><?php echo e(ucfirst($translations["backoffice"]["orders"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <?php if(MODULES_HOMEPAGE && $user['role'] == '0'): ?>
                        <li>
                            <a href="/adm/homepages">
                                <i class="iconsmind-Box-Close"></i><?php echo e(ucfirst($translations["backoffice"]["homepage"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_CLIENTS): ?>
                        <li>
                            <a href="/adm/clients">
                                <i class="iconsmind-Mens"></i><?php echo e(ucfirst($translations["backoffice"]["clients"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_JOBS): ?>
                        <li>
                            <a href="#jobs">
                                <i class="fa fa-briefcase"></i>Empregos
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_PRODUCTS): ?>
                            <li>
                                <a class="link-sub" href="#products">
                                    <i class="iconsmind-Shopping-Bag"></i><?php echo e(ucfirst($translations["backoffice"]["products"])); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(MODULES_PAGES): ?>
                        <li>
                            <a href="/adm/pages">
                                <i class="iconsmind-digital-drawing"></i><?php echo e(ucfirst($translations["backoffice"]["pages"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_DOCUMENTS): ?>
                        <li>
                            <a href="/adm/documents">
                                <i class="iconsmind-files"></i><?php echo e(ucfirst($translations["backoffice"]["documents"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_INFO_FORM): ?>
                        <li>
                            <a href="/adm/info-form">
                                <i class="iconsmind-files"></i><?php echo e(ucfirst($translations["backoffice"]["info_form_tilte"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_OBITUARIES): ?>
                        <li>
                            <a href="/adm/obituaries">
                                <i class="iconsmind-conference"></i>Obituários
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_MENUS): ?>
                        <li>
                            <a href="/adm/menus">
                                <i class="iconsmind-arrow-inside"></i><?php echo e(ucfirst($translations["backoffice"]["menu_manager"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_POPUPS): ?>
                        <li>
                            <a href="/adm/popups">
                                <i class="iconsmind-window"></i><?php echo e(ucfirst($translations["backoffice"]["title_popup"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_CUSTOM_PAGE): ?>
                        <li>
                            <a href="/adm/custom_page/1">
                                <i class="iconsmind-info-window"></i><?php echo e(ucfirst($translations["backoffice"]["custom_page_title"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_CUSTOM_INFO): ?>
                        <li>
                            <a href="/adm/custom_info/1">
                                <i class="iconsmind-information"></i><?php echo e(ucfirst($translations["backoffice"]["custom_info_title"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_ALERTS): ?>
                        <li>
                            <a href="/adm/alerts">
                                <i class="iconsmind-bell"></i><?php echo e(ucfirst($translations["backoffice"]["title_alerts"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_PARTNERS): ?>
                        <li>
                            <a href="/adm/partners">
                                <i class="iconsmind-bell"></i><?php echo e(ucfirst($translations["backoffice"]["brands"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_RANKING_BLOCKS): ?>
                        <li>
                            <a href="/adm/ranking_blocks">
                                <i class="iconsmind-bell"></i><?php echo e(ucfirst($translations["backoffice"]["title_ranking_blocks"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_CYCLES_BLOCKS): ?>
                        <li>
                            <a href="/adm/cycles_blocks">
                                <i class="iconsmind-bell"></i><?php echo e(ucfirst($translations["backoffice"]["title_cycles_blocks"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_BANNERS): ?>
                        <li>
                            <a href="/adm/banners">
                                <i class="iconsmind-switch"></i><?php echo e(ucfirst($translations["backoffice"]["banner_title"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_NEWS): ?>
                        <li>
                            <a href="#news">
                                <i class="iconsmind-Newspaper"></i><?php echo e(ucfirst($translations["backoffice"]["news"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_RECRUITMENTS): ?>
                        <li>
                            <a href="/adm/recruitments">
                                <i class="iconsmind-Jet"></i><?php echo e(ucfirst($translations["backoffice"]["recruitments"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_GALLERY): ?>
                        <li>
                            <a href="/adm/galleries">
                                <i class="iconsmind-Photos"></i><?php echo e(ucfirst($translations["backoffice"]["gallery"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_MESSAGES): ?>
                        <li>
                            <a class="link-sub" href="#mensagem">
                                <i class="iconsmind-Envelope-2"></i><?php echo e(ucfirst($translations["backoffice"]["messages"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_SERVICES): ?>
                            <li>
                                <a href="/adm/services">
                                    <i class="iconsmind-wrench"></i> <?php echo e(ucfirst($translations["backoffice"]["services"])); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(MODULES_TEAM): ?>
                        <li>
                            <a href="/adm/team">
                                <i class="iconsmind-King-2"></i><?php echo e(ucfirst($translations["backoffice"]["users"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_SCHEDULE): ?>
                        <li>
                            <a href="/adm/schedule">
                                <i class="iconsmind-calendar-4"></i><?php echo e(ucfirst($translations["backoffice"]["schedule"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_PORTFOLIO): ?>
                        <li>
                            <a class="link-sub" href="#portfolio">
                                <i class="iconsmind-Folder-Search"></i>Portfolio
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_TESTIMONIES): ?>
                        <li>
                            <a href="/adm/testimonies">
                                <i class="iconsmind-Testimonal"></i> <?php echo e(ucfirst($translations["backoffice"]["testimonies"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_IMPORTED_DATAS): ?>
                        <li>
                            <a href="/adm/imported_datas">
                                <i class="iconsmind-Testimonal"></i> <?php echo e(ucfirst($translations["backoffice"]["imported_datas"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_SETTINGS): ?>
                        <li>
                            <a href="/adm/config">
                                <i class="iconsmind-Gear"></i> <?php echo e(ucfirst($translations["backoffice"]["settings"])); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="sub-menu">
                <div class="scroll">
                    <!-- Sub-menu produtos -->
                    <ul class="list-unstyled" data-link="products">
                        <li>
                            <a href="/adm/products">
                                <i class="iconsmind-Shopping-Cart"></i> <?php echo e(ucfirst($translations["backoffice"]["products"])); ?>

                            </a>
                        </li>
                        <?php if(MODULES_PERSONALIZATION): ?>
                            <li>
                                <a href="/adm/personalization">
                                    <i class="simple-icon-layers"></i> <?php echo e(ucfirst($translations["backoffice"]["custom"])); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(MODULES_BRANDS): ?>
                        <li>
                            <a href="/adm/brands">
                                <i class="simple-icon-layers"></i> Marcas
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(MODULES_CATEGORIES): ?>
                            <li>
                                <a href="/adm/categories">
                                    <i class="simple-icon-list"></i> <?php echo e(ucfirst($translations["backoffice"]["categories"])); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(MODULES_FILTERS): ?>
                            <li>
                                <a href="/adm/filters">
                                    <i class="simple-icon-list"></i> <?php echo e(ucfirst($translations["backoffice"]["filters"])); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <a href="/api/products/export/csv" target="_blank">
                                <i class="fa fa-download"></i> Exp. p/ facebook
                            </a>
                        </li>
                        <li>
                            <a href="/api/products/export/csv?google=true" target="_blank">
                                <i class="fa fa-download"></i> Exp. p/ google
                            </a>
                        </li>
                    </ul>
                    
                    <ul class="list-unstyled" data-link="news">
                        <li>
                            <a href="/adm/news">
                                <i class="iconsmind-Newspaper"></i><?php echo e(ucfirst($translations["backoffice"]["news"])); ?>

                            </a>
                        </li>
                        <li>
                            <a href="/adm/categories_news">
                                <i class="simple-icon-list"></i> <?php echo e(ucfirst($translations["backoffice"]["categories"])); ?>

                            </a>
                        </li>
                    </ul>

                    <ul class="list-unstyled" data-link="jobs">
                        <li>
                            <a href="/adm/jobs">
                                <i class="iconsmind-Newspaper"></i>Empregos
                            </a>
                        </li>
                        <li>
                            <a href="/adm/categories_jobs">
                                <i class="simple-icon-list"></i> <?php echo e(ucfirst($translations["backoffice"]["categories"])); ?>

                            </a>
                        </li>
                    </ul>

                    <!-- Sub-menu mensagem -->
                    <ul class="list-unstyled" data-link="mensagem">
                        <?php if(MODULES_TICKETS): ?>
                            <li>
                                <a href="/adm/tickets">
                                    <i class="iconsmind-Envelope-2"></i> <?php echo e(ucfirst($translations["backoffice"]["tickets"])); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <a href="/adm/contacts">
                                <i class="iconsmind-Globe-2"></i> <?php echo e(ucfirst($translations["backoffice"]["contact_request"])); ?>

                            </a>
                        </li>
                        <li>
                            <a href="/adm/newsletter">
                                <i class="iconsmind-Full-View2"></i> <?php echo e(ucfirst($translations["backoffice"]["newsletter"])); ?>

                            </a>
                        </li>
                    </ul>
                    <!-- Sub-menu portfolio -->
                    <?php if(MODULES_PORTFOLIO): ?>
                        <ul class="list-unstyled" data-link="portfolio">
                            <?php if(MODULES_CONSTRUCTIONS): ?>
                                <li>
                                    <a href="/adm/constructions">
                                        <i class="iconsmind-wheelbarrow"></i> <?php echo e(ucfirst($translations["backoffice"]["constructions"])); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(MODULES_SERVICES): ?>
                                <li>
                                    <a href="/adm/services">
                                        <i class="iconsmind-wrench"></i> <?php echo e(ucfirst($translations["backoffice"]["services"])); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a href="/adm/categories_constructions">
                                    <i class="simple-icon-list"></i> <?php echo e(ucfirst($translations["backoffice"]["categories"])); ?>

                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php echo $__env->yieldContent('content'); ?>
        <footer class="page-footer">
            <div class="footer-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <span class="mb-0 text-muted  float-right">v2.0.57C</span>
                        </div>
                        <div class="col-sm-6 d-none d-sm-block">
                            <p class="text-right"></p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <script src="/static/backoffice/javascript/tags.js"></script>
        <script src="/static/backoffice/javascript/perfect_scrollbar.js"></script>
        <script src="/static/backoffice/javascript/scripts.js"></script>
        <script src="/static/backoffice/javascript/dropzone.js"></script>
        <script src="/static/backoffice/javascript/bootstrap-datepicker.js"></script>
        <script src="/static/backoffice/javascript/dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        
        <script>
            $('.drop-messages').on('click', function (event) {
                $('.drop-messages2').toggleClass('d-block');
                $('.drop-orders2').removeClass('d-block');
                $('.drop-clients2').removeClass('d-block');

            });

            $('.drop-orders').on('click', function (event) {
                $('.drop-orders2').toggleClass('d-block');
                $('.drop-messages2').removeClass('d-block');
                $('.drop-clients2').removeClass('d-block');
            });

            $('.drop-clients').on('click', function (event) {
                $('.drop-clients2').toggleClass('d-block');
                $('.drop-orders2').removeClass('d-block');
                $('.drop-messages2').removeClass('d-block');
            });

            $('body').on('click', function (e) {
                if (!$('drop-messages2').is(e.target) 
                    && $('drop-messages2').has(e.target).length === 0 
                    && $('.d-block').has(e.target).length === 0
                ) {
                    $('drop-messages2').removeClass('d-block');
                }
            });

            
        </script>
        <script>

            function removeTemplateLoader() {

                $("body > *")
                    .stop()
                    .delay(100)
                    .animate({ opacity: 1 }, 300);
                $("body").removeClass("show-spinner");
                $("main").addClass("default-transition");
                $(".sub-menu").addClass("default-transition");
                $(".main-menu").addClass("default-transition");
                $(".theme-colors").addClass("default-transition");
            }

            // Retirar automaticamente se não for tirado em 10 segundos
            setTimeout(function() {

                removeTemplateLoader();

            }, 50);

        </script>
        <?php echo $__env->yieldContent('scripts'); ?>
        <script>
            
            let notificationCount = 0

            loadNotification();

            function deleteMultipleNotifications () {
                var selected = [];

                $('.check:checked').each(function(){
                    selected.push($(this).val());
                });

                $.confirm({
                    title: '<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>',
                    theme: "supervan",
                    content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_many_product_remove"])); ?>',
                    buttons: {

                        Sim: function () {
                            $.ajax({
                                url: "/api/notifications_multiple",
                                type: "POST",
                                data: {selected},
                                dataType: "json",
                                success: function (response) {

                                    if (!response.success) {

                                        // Output do erro
                                        console.error(response);

                                        $.alert({
                                            title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                            theme: "supervan",
                                            content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                                        });

                                        // Não deixar a função executar mais
                                        return;
                                    }

                                    // Rederecionar para a página de index dos banners
                                    loadNotification()
                                },
                                error: function (jqXHR, textStatus, errorThrown) {

                                    console.log(textStatus, errorThrown);

                                    $.alert({
                                        title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                        theme: "supervan",
                                        content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                                    });
                                }
                            });

                        },
                        Não: {}
                    }
                });
                
                console.log(selected);
            } 

            function removeNotification($id) {

                $.ajax({
                    url: "/api/notifications/" + $id,
                    type: "DELETE",
                    dataType: "json",
                    success: function (response) {

                        if (!response.success) {

                            $.alert({
                                title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>!',
                                theme: "supervan",
                                content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                            });

                            // Não deixar a função executar mais
                            return;
                        }

                        loadNotification();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                        console.log(textStatus, errorThrown);

                        $.alert({
                            title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>!',
                            theme: "supervan",
                            content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                        });
                    }
                });
            }

            function loadNotification() {

                $.ajax({
                    url: "/api/notifications",
                    type: "GET",
                    dataType: "json",
                    success: function (response) {

                        if (!response.success) {

                            $.alert({
                                title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>!',
                                theme: "supervan",
                                content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                            });

                            console.error(response);

                            // Não deixar a função executar mais
                            return;
                        }

                        populateNotifications(response.data)
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                        $.alert({
                            title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>!',
                            theme: "supervan",
                            content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                        });
                    }
                });
            }

            function getTotalNotifications(countTicket = 0, countMessage = 0, countContact = 0) {

                return countTicket + countMessage + countContact;
            }

            function populateNotifications(notifications) {

                //Limpa as div das notificações
                
                $("#divNotifications").html("");
                $("#divNewOrders").html("");
                $("#divNewClients").html("");

                //Se tiver notificações
                if (notifications != undefined) {

                    //Divide as notificações em tipo
                    const notificationsPerTypes = notifications.reduce(function (acc, cur) {

                        acc[cur.type] = [...acc[cur.type] || [], cur];
                        return acc;
                    }, {});

                    if (!notificationsPerTypes.ticket?.length && !notificationsPerTypes.message?.length && !notificationsPerTypes.contact?.length) {
                        
                        $("#divNotifications").html("<?php echo e(ucfirst($translations["backoffice"]["empty_notifications"])); ?>");
                        $(".count-notifications").html(0);

                    } else {

                        let count = getTotalNotifications(notificationsPerTypes.ticket?.length, notificationsPerTypes.message?.length, notificationsPerTypes.contact?.length)
                        $(".count-notifications").html(count);

                        if (notificationsPerTypes.ticket?.length) {

                            $.each(notificationsPerTypes.ticket, function (key, notificationTicket) {

                                let template =
                                `<div class="d-flex flex-row mb-3 pb-3 border-bottom">
                                    <label class="custom-checkbox align-self-center col-1">
                                        <input type="checkbox" name="selected_ids[]" value="` + notificationTicket.id + `" class="checkbox-allowed-messages check custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                    <div class="pl-3 notification col-9" data-id="` + notificationTicket.id + `">
                                        <a class="notification" href="` + notificationTicket.link + `" data-id="` + notificationTicket.id + `">
                                            <p class="font-weight-medium mb-1"><?php echo e(ucfirst($translations["backoffice"]["new"])); ?> <?php echo e($translations["backoffice"]["ticket"]); ?></p>
                                            <p class="text-muted mb-0 text-small">` + notificationTicket.identifier + `</p>
                                            <p class="text-muted mb-0 text-small">` + notificationTicket.date + `</p>
                                        </a>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-outline-danger mb-1 btn-xs m-1 float-right markasread" title="<?php echo e(ucfirst($translations["backoffice"]["mark_as_read"])); ?>" data-id="` + notificationTicket.id + `">
                                            <i class="simple-icon-ban"></i>
                                        </button>
                                    </div>
                                </div>`;

                                $("#divNotifications").append(template);
                            });
                        }

                        if (notificationsPerTypes.message?.length) {

                            $.each(notificationsPerTypes.message, function (key, notificationMessage) {

                                let template =
                                `<div class="d-flex flex-row mb-3 pb-3 border-bottom">
                                    <label class="custom-checkbox align-self-center col-1">
                                        <input type="checkbox" name="selected_ids[]" value="` + notificationMessage.id + `" class="checkbox-allowed-messages check custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                    <div class="pl-3 notification col-9" data-id="` + notificationMessage.id + `">
                                        <a class="notification" href="` + notificationMessage.link + `" data-id="` + notificationMessage.id + `">
                                            <p class="font-weight-medium mb-1"><?php echo e(ucfirst($translations["backoffice"]["new_female"])); ?> <?php echo e($translations["backoffice"]["message"]); ?>:</p>
                                            <p class="text-muted mb-0 text-small">` + notificationMessage.identifier + `</p>
                                            <p class="text-muted mb-0 text-small">` + notificationMessage.date + `</p>
                                        </a>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-outline-danger mb-1 btn-xs m-1 float-right markasread" title="<?php echo e(ucfirst($translations["backoffice"]["mark_as_read"])); ?>" data-id="` + notificationMessage.id + `">
                                            <i class="simple-icon-ban"></i>
                                        </button>
                                    </div>
                                </div>`;

                                $("#divNotifications").append(template);
                            })
                        }

                        if (notificationsPerTypes.contact?.length) {

                            $.each(notificationsPerTypes.contact, function (key, notificationContact) {

                                let template =
                                `<div class="d-flex flex-row mb-3 pb-3 border-bottom row">
                                    <label class="custom-checkbox align-self-center col-1 ml-3">
                                        <input type="checkbox" name="selected_ids[]" value="` + notificationContact.id + `" class="checkbox-allowed-messages check custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                    <div class="pl-3 notification col-8" data-id="` + notificationContact.id + `">
                                        <a class="notification" href="` + notificationContact.link + `" data-id="` + notificationContact.id + `">
                                            <p class="font-weight-medium mb-1"><?php echo e(ucfirst($translations["backoffice"]["new"])); ?> <?php echo e($translations["backoffice"]["contact_request"]); ?></p>
                                            <p class="text-muted mb-0 text-small">` + notificationContact.date + `</p>
                                        </a>
                                    </div>
                                    <div class="col-1">
                                        <button class="btn btn-outline-danger mb-1 btn-xs m-1 float-right markasread" title="<?php echo e(ucfirst($translations["backoffice"]["mark_as_read"])); ?>" data-id="` + notificationContact.id + `">
                                            <i class="simple-icon-ban"></i>
                                        </button>
                                    </div>
                                </div>`;

                                $("#divNotifications").append(template);
                            });
                        }
                    }

                    if (!notificationsPerTypes.order?.length) {

                        $("#divNewOrders").html("<?php echo e(ucfirst($translations["backoffice"]["empty_notifications"])); ?>")
                        $(".count-newOrders").html(0)

                    } else {

                        $(".count-newOrders").html(notificationsPerTypes.order.length);

                        $.each(notificationsPerTypes.order, function (key, notificationOrder) {

                            let template =
                            `<div class="d-flex flex-row mb-3 pb-3 border-bottom">
                                <label class="custom-checkbox align-self-center col-1">
                                    <input type="checkbox" name="selected_ids[]" value="` + notificationOrder.id + `" class="checkbox-allowed-order check custom-control-input">
                                    <span class="custom-control-label"></span>
                                </label>
                                <div class="pl-3 notification col-9" data-id="` + notificationOrder.id + `">
                                    <a class="notification" href="` + notificationOrder.link + `" data-id="` + notificationOrder.id + `">
                                        <p class="font-weight-medium mb-1"><?php echo e(ucfirst($translations["backoffice"]["new"])); ?> <?php echo e($translations["backoffice"]["order"]); ?></p>
                                        <p class="text-muted mb-0 text-small">` + notificationOrder.identifier + `</p>
                                        <p class="text-muted mb-0 text-small">` + notificationOrder.date + `</p>
                                    </a>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-outline-danger mb-1 btn-xs m-1 float-right markasread" title="<?php echo e(ucfirst($translations["backoffice"]["mark_as_read"])); ?>" data-id="` + notificationOrder.id + `">
                                        <i class="simple-icon-ban"></i>
                                    </button>
                                </div>
                            </div>`;

                            $("#divNewOrders").append(template);
                        })
                    }

                    if (!notificationsPerTypes.client?.length) {

                        $("#divNewClients").html("<?php echo e(ucfirst($translations["backoffice"]["empty_notifications"])); ?>");
                        $(".count-newClient").html(0);

                    } else {

                        $(".count-newClient").html(notificationsPerTypes.client.length);

                        $.each(notificationsPerTypes.client, function (key, notificationClient) {

                            let template =
                            `<div class="d-flex flex-row mb-3 pb-3 border-bottom">
                                <label class="custom-checkbox align-self-center col-1">
                                    <input type="checkbox" name="selected_ids[]" value="` + notificationClient.id + `" class="checkbox-allowed-client check custom-control-input">
                                    <span class="custom-control-label"></span>
                                </label>
                                <div class="pl-3 notification col-9" data-id="` + notificationClient.id + `">
                                    <a class="notification" href="` + notificationClient.link + `" data-id="` + notificationClient.id + `">
                                        <p class="font-weight-medium mb-1">Novo Registo</p>
                                        <p class="text-muted mb-0 text-small">` + notificationClient.identifier + `</p>
                                        <p class="text-muted mb-0 text-small">` + notificationClient.date + `</p>
                                    </a>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-outline-danger mb-1 btn-xs m-1 float-right markasread" title="<?php echo e(ucfirst($translations["backoffice"]["mark_as_read"])); ?>" data-id="` + notificationClient.id + `">
                                        <i class="simple-icon-ban"></i>
                                    </button>
                                </div>
                            </div>`;

                            $("#divNewClients").append(template);
                        });
                    }

                } else {

                    $("#divNotifications").html("<?php echo e(ucfirst($translations["backoffice"]["empty_notifications"])); ?>");
                    $("#divNewClients").html("<?php echo e(ucfirst($translations["backoffice"]["empty_notifications"])); ?>");
                    $("#divNewOrders").html("<?php echo e(ucfirst($translations["backoffice"]["empty_notifications"])); ?>");

                    $(".count-notifications").html(0);
                    $(".count-newClient").html(0);
                    $(".count-newOrders").html(0);
                }
            }

            $("#checkAllMessages").click(function(){
                $('.checkbox-allowed-messages').not(this).prop('checked', this.checked);
            });

            $("#checkAllClients").click(function(){
                $('.checkbox-allowed-client').not(this).prop('checked', this.checked);
            });

            $("#checkAllOrders").click(function(){
                $('.checkbox-allowed-order').not(this).prop('checked', this.checked);
            });

            $("body").on("click", ".notification", function () {              

                removeNotification($(this).data("id"));
            })

            $("body").on("click", ".markasread", function () {

                removeNotification($(this).data("id"));
                loadNotification();
            })

        </script>
    </body>
</html><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/layouts/master.blade.php ENDPATH**/ ?>