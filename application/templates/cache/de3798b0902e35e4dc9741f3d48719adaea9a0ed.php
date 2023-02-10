
<?php $__env->startSection('content'); ?>
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <h1><?php echo e(ucfirst($translations["backoffice"]["title_list_products"])); ?></h1>
                        <div class="text-zero top-right-button-container">
                            <div class="btn-group">list_product_c
                                <a href="javascript:void(0)" data-action="newProduct" type="button"
                                   class="btn btn-primary top-center-button mr-1 new-item-button"
                                   style="padding: 9px 34px;"><?php echo e(ucfirst($translations["backoffice"]["list_product_create"])); ?></a>
                            </div>
                        </div>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm"><?php echo e(ucfirst($translations["backoffice"]["store"])); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?php echo e(ucfirst($translations["backoffice"]["products"])); ?>

                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="mb-2">



                        <div class="collapse d-md-block" id="displayOptions">
                            <div class="d-block d-md-inline-block">
                                <div class="btn-group float-md-left mr-1 mb-1">
                                    <button class="btn btn-outline-dark btn-xs dropdown-toggle"
                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">Idioma
                                    </button>
                                    <div class="dropdown-menu">
                                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a class="dropdown-item lang-menu" data-lang="<?php echo e($language->code); ?>"><?php echo e($language->name); ?></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <div class="btn-group float-md-left mr-1 mb-1">
                                    <button class="btn btn-outline-dark btn-xs dropdown-toggle clients-order-menu"
                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false"><?php echo e(ucfirst($translations["backoffice"]["order_by"])); ?>

                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item order-menu" data-order="created_at"><?php echo e(ucfirst($translations["backoffice"]["orderBy_last_inserted"])); ?></a>
                                        <a class="dropdown-item order-menu" data-order="name"><?php echo e(ucfirst($translations["backoffice"]["orderBy_name"])); ?></a>
                                        <a class="dropdown-item order-menu" data-order="status"><?php echo e(ucfirst($translations["backoffice"]["orderBy_status"])); ?></a>
                                    </div>
                                </div>
                                <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                                    <input placeholder="<?php echo e(ucfirst($translations["backoffice"]["search"])); ?>">
                                </div>
                                <a class="search-button"><i class="simple-icon-magnifier"></i></a>
                            </div>
                            <div class="float-md-right">
                                <span class="text-muted text-small mr-1"><?php echo e(ucfirst($translations["backoffice"]["items_per_page"])); ?></span>
                                <button class="btn btn-outline-dark btn-xs dropdown-toggle products-lenght-menu"
                                        type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    50
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                    <a class="dropdown-item length-link" data-length="10">10</a>
                                    <a class="dropdown-item length-link" data-length="50">50</a>
                                    <a class="dropdown-item length-link" data-length="100">100</a>
                                    <a class="dropdown-item length-link" data-length="150">150</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="separator mb-5"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 list sortable" data-check-all="checkAll">
                </div>
                <div class="col-12">
                    <nav class="mt-4 mb-3">
                        <ul class="pagination justify-content-center mb-0">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </main>

    <!-- START SCRIPTS -->
    <script src="/static/backoffice/javascript/jodit_editor_js/jodit.js"></script>
    <script src="/static/backoffice/javascript/jodit_editor_js/app.js"></script>
    <script src="/static/backoffice/javascript/jodit_editor_js/prism.js"></script>
    <link rel="stylesheet" href="/static/backoffice/css/jodit_editor_css/app.css"/>
    <link rel="stylesheet" href="/static/backoffice/css/jodit_editor_css/jodit.css"/>
    <link rel="stylesheet" href="/static/backoffice/css/jodit_editor_css/prism.css"/>
<?php $__env->stopSection(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php $__env->startSection('scripts'); ?>
    <script>
        let query = parseQueryString();

        let attributes = []

        var page        = (query.page   !== undefined) ? query.page     : 1;
        var lang        = (query.lang   !== undefined) ? query.lang     : '';
        var limit       = (query.limit  !== undefined) ? query.limit    : 50;
        var order       = (query.order  !== undefined) ? query.order    : "order_by";
        var search      = (query.search !== undefined) ? decodeURI(query.search).replace("+", " ").replace("%2B", " ")   : "";

        //Meter o input search com os valores GET se tiver
        if (query.search !== undefined && query.search.length > 0) {

            $(".search-sm input").val(query.search);
        }

        if (query.limit !== undefined && query.limit.length > 0) {

            $(".products-lenght-menu").text(limit);
        }

        load();

        //Evento onClick butao Registar novo produto
        $('[data-action="newProduct"]').on("click", function () {

            let data = {
                draft: 1,
                status: 0
            }
            create(data);
        });

        function load() {

            window.history.replaceState("", "", '/adm/products?' + $.param( { limit: limit, order: order, page: page, search: search, lang:lang } ));

            $.ajax({
                url: "/api/products?page=" + page + "&search=" + search + "&length=" + limit + "&order=" + order + "&lang=" + lang,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (!response.success) {

                        $.alert({
                            title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                            theme: "supervan",
                            content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                        });

                        // Não deixar a função executar mais
                        return;
                    }

                    // Inserir as notícias obtidas pela api na listagem
                    populate(response.data);

                    //Paginação
                    if (response.pagination !== undefined) {

                        let pagination  = response.pagination;
                        let page        = pagination.page;
                        let pages       = Math.ceil(pagination.total / pagination.limit); //Calcula o total de paginas

                        //Adiciona o html dos botões da paginação debaixo da lista
                        $(".pagination").html(pagination_template(page, pages));
                    }

                    $( ".sortable" ).sortable({                        
                        cursor: "move",
                        dropOnEmpty: true,
                        tolerance: "pointer",
                        opacity: 0.7,
                        revert: 300,
                        delay: 150,
                        placeholder: "movable-placeholder",
                        start: function(e, ui) {
                            ui.placeholder.height(ui.helper.outerHeight());
                        },
                        stop:function () {
                            var ids = '';
                            $('.ui-sortable-handle').each(function () {                                
                                id = $(this).attr("data-id");                        
                                if(ids == '') {
                                    ids = id;
                                } else {
                                    ids = ids + ',' + id;
                                }
                            })
                            
                            $.ajax({
                                url: "/api/products/sortable",
                                type: "POST",
                                data: {ids: ids},
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
                                }
                            })
                        }
                    })

                    listeners();
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
        }

                //Cria um produto
        function create(data) {

            $.ajax({
                url: "/api/products",
                type: "POST",
                data: data,
                dataType: "json",
                success: function (response) {
                    if (!response.success) {

                        $.alert({
                            title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                            theme: "supervan",
                            content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                        });

                        // Não deixar a função executar mais
                        return;
                    }

                    // Rederecionar para a noticia "rascunho"
                    window.location.href = "/adm/products/" + response.data.id;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.alert({
                        title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                        theme: "supervan",
                        content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                    });
                }
            })
        }

        function populate(items) {
            
            //Limpar a lista de items
            $(".list").html("")

            $.each(items, function (key, item) {
                let status = "";
                let name = "";

                //Obter o status do produto
                switch (item.status) {
                    case "0":
                        status = '<span class="dot red mr-2"></span> <?php echo e(ucfirst($translations["backoffice"]["products_status_draft"])); ?>';
                        break;
                    case "1":
                        status = '<span class="dot orange mr-2"></span> <?php echo e(ucfirst($translations["backoffice"]["products_status_private"])); ?>';
                        break;
                    case "2":
                        status = '<span class="dot green mr-2"></span> <?php echo e(ucfirst($translations["backoffice"]["products_status_published"])); ?>';
                        break;
                }

                if(item.name === null){
                    name = "<?php echo e(ucfirst($translations["backoffice"]["unnamed_product"])); ?>"
                }else{
                    name = item.name;
                }

            // <img onerror="this.onerror=null;this.src='/static/backoffice/images/placeholder.png'" src="` + item.photo + `" class="list-thumbnail responsive border-0 card-img-left index-card-img" />

                let template = `
            <div class="card d-flex flex-row mb-3" data-id="` + item.id + `">
                <a class="d-flex a-index-img" href="/adm/products/` + item.id + `">
                    <div class="background-image" style="background-image: url(`+ item.photo +`)"></div>
                </a>
                <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                    <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                        <a href="/adm/products/` + item.id + `" class="w-25 w-sm-100 truncate">
                            <p class="list-item-heading mb-0 truncate">` + name + `</p>
                        </a>
                        <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                            <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                                <a href="/adm/products/` + item.id + `" class="w-60 w-sm-100 truncate">
                                    <p class="list-item-heading mb-0 truncate">` + name + `</p>
                                </a>
                                <p class="mb-0 text-muted text-small w-20 w-sm-100">` + item.sku + `</p>
                                <p class="mb-0 text-muted text-small w-20 w-sm-100">` + item.price + `€</p>
                                <p class="mb-0 text-muted text-small w-20 w-sm-100 displayNone-max-w-1199">` + item.previous_price + `€</p>
                                <p class="mb-0 text-muted text-small w-20 w-sm-100">` + item.stock + ` uni.</p>
                                <p class="mb-0 text-muted text-small w-20 w-sm-100">` + status + `</p>
                                <a class="copy-product" href="javascript:void(0)" data-id="` + item.id + `"><i class="simple-icon-docs font-size-20"></i></a>
                            </div>
                        </div>
                    </div>`;

                $(".list").append(template);
            });

            //Caso os items estejam vazios
            if (items === undefined || items.length == 0) {

                //Na listagem meter uma mensagem a dizer que está vazio
                $(".list").html(`
                	<h4><?php echo e(ucfirst($translations["backoffice"]["not_found_male"])); ?> <?php echo e($translations["backoffice"]["products"]); ?></h4>
				    <p class="text-muted"><?php echo e(ucfirst($translations["backoffice"]["try_again_later_empty"])); ?></p>
                `);
            }
        }

        function listeners() {

            //Ao clicar na paginação
            $("body").off("click", ".page-link");
            $("body").on("click", ".page-link", function () {

                //Definir a nova pagina
                page = $(this).data("page");

                // fazer scroll para cima smooth
                window.scroll({top: 0, behavior: "smooth"});

                //Recarregar os dados da api
                load();
            })

            $(".copy-product").on("click", function () {

                let data = {

                    id: $(this).data("id")
                }

                $.confirm({
                    title: '<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>',
                    content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_duplicate_product"])); ?>',
                    theme: 'supervan',
                    buttons: {
                        yes: {
                            keys: ['enter'],
                            text: '<?php echo e(ucfirst($translations["backoffice"]["yes"])); ?>',
                            action: function () {

                                create(data)
                            }
                        },
                        no: {
                            keys: ['esc'],
                            text: "<?php echo e(ucfirst($translations["backoffice"]["no"])); ?>",
                            action: function () {
                            }
                        },
                    }
                });
            })

            //Dropdown de mudar numero de items da pagina
            $(".length-link").off("click");
            $(".length-link").on("click", function () {

                limit = $(this).data("length");
                page = 1;

                $(".products-lenght-menu").text(limit);
                load();
            })

            //dropdown de mudar ordenação dos items
            $(".order-menu").off("click");
            $(".order-menu").on("click", function () {

                order = $(this).data("order");
                page = 1;

                $(".products-lenght-menu").text($(this).text());
                load();
            })

            //dropdown de mudar o idioma            
            $(".lang-menu").off("click");
            $(".lang-menu").on("click", function () {

                lang = $(this).data("lang");
                page = 1;

                $(".products-lenght-menu").text($(this).text());
                load();
            })

            $(".search-button").off("click");
            $(".search-button").on("click", function () {

                search = $(".search-sm input").val();
                load();
            });

            $('.search-sm input').unbind("enterKey");
            $('.search-sm input').bind("enterKey", function (e) {

                search = $(".search-sm input").val();
                load();
            });

            $('.search-sm input').keyup(function (e) {

                if (e.keyCode == 13) {

                    $(this).trigger("enterKey");
                }
            });
        }

        function pagination_template(page, pages) {

            //Nav template
            let nav = "";
            let number_of_extra_pagination_button = 4;

            if (page != 1) {
                nav += '<li class="page-item"><a class="page-link" data-page="' + 1 + '"><i class="simple-icon-control-start"></i></a></li>';
                nav += '<li class="page-item"><a class="page-link" data-page="' + (page - 1) + '"><i class="simple-icon-arrow-left"></i></a></li>';
            }

            let start_loop = page - number_of_extra_pagination_button;
            start_loop = (start_loop <= 0) ? 1 : start_loop;

            let end_loop = page + number_of_extra_pagination_button;
            end_loop = (end_loop > pages) ? pages : end_loop;

            for (let i = start_loop; i <= end_loop; i++) {
                let pageActive = "";
                if (i == page) {
                    pageActive = "active";
                }

                nav += '<li class="page-item ' + pageActive + '"><a class="page-link" data-page="' + i + '">' + i + '</a></li>';
            }

            if (page < pages) {
                nav += '<li class="page-item"><a class="page-link" data-page="' + (page + 1) + '"><i class="simple-icon-arrow-right"></i></a></li>';
                nav += '<li class="page-item"><a class="page-link" data-page="' + pages + '"><i class="simple-icon-control-end"></i></a></li>';
            }

            return nav;
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/pages/products/index.blade.php ENDPATH**/ ?>