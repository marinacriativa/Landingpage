
<?php $__env->startSection('content'); ?>
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <h1><?php echo e(ucfirst($translations["backoffice"]["pages"])); ?></h1>
                        <div class="btn-group top-right-button-container">
                            <div class="btn btn-primary btn-lg pl-4 pr-0 check-button">
                                <label class="custom-control custom-checkbox mb-0 d-inline-block">
                                    <input type="checkbox" class="custom-control-input" id="checkAll">
                                    <span class="custom-control-label">&nbsp;</span>
                                </label>
                            </div>
                            <button id="btnGroupDrop1" type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split botaodrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" onclick="deleteMultiple()"> Eliminar Selecionados <i class="simple-icon-trash btn-outline-danger"></i></a>
                            </div>
                        </div>
                        <div class="text-zero top-right-button-container">
                            <div class="btn-group">
                                <a href="javascript:void(0)" data-action="newPage" type="button"
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
                                    <?php echo e(ucfirst($translations["backoffice"]["pages"])); ?>                                    
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
                                            aria-expanded="false">
                                            <?php if(isset($_GET['lang'])): ?>                                                  
                                                <span id="c_language"><?php echo e($_GET['lang']); ?></span>
                                            <?php else: ?> 
                                                <span id="c_language"></span>
                                            <?php endif; ?>                                            
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
                                        <a class="dropdown-item order-menu" data-order="id"><?php echo e(ucfirst($translations["backoffice"]["orderBy_last_inserted"])); ?></a>
                                        <a class="dropdown-item order-menu" data-order="name"><?php echo e(ucfirst($translations["backoffice"]["orderBy_name"])); ?></a>
                                        <a class="dropdown-item order-menu" data-order="status"><?php echo e(ucfirst($translations["backoffice"]["orderBy_status"])); ?></a>
                                    </div>
                                </div>
                                <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                                    <input placeholder=<?php echo e(ucfirst($translations["backoffice"]["search"])); ?>>
                                </div>
                                <a class="search-button"><i class="simple-icon-magnifier"></i></a>
                            </div>
                            <div class="float-md-right">
                                <span class="text-muted text-small mr-1"><?php echo e(ucfirst($translations["backoffice"]["items_per_page"])); ?> </span>
                                <button class="btn btn-outline-dark btn-xs dropdown-toggle clients-lenght-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 10 </button>
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
                <div class="col-12 list" data-check-all="checkAll">
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        let query = parseQueryString();

        var page        = (query.page   !== undefined) ? query.page     : 1;
        var lang        = (query.lang   !== undefined) ? query.lang     : '';
        var limit       = (query.limit  !== undefined) ? query.limit    : 10;
        var order       = (query.order  !== undefined) ? query.order    : "id";
        var search      = (query.search !== undefined) ? query.search   : "";

        //Meter o input search com os valores GET se tiver
        if (query.search !== undefined && query.search.length > 0) {

            $(".search-sm input").val(query.search);
        }

        if (query.limit !== undefined && query.limit.length > 0) {
            $(".clients-lenght-menu").text(limit);
        }

        load();

        //Evento onClick butao Registar novo produto
        $('[data-action="newPage"]').on("click", function () {

        let data = {
            draft: 1,
            status: 0
        }
        create(data);
        });

        function create(data) {

        $.ajax({
            url: "/api/pages",
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
                window.location.href = "/adm/pages/" + response.data.id;
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

        function load() {

            window.history.replaceState("", "", '/adm/pages?' + $.param( { limit: limit, order: order, page: page, search: search, lang:lang } ));

            $.ajax({
                url: "/api/pages?page=" + page + "&search=" + search + "&length=" + limit + "&order=" + order + "&lang=" + lang,
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
                    console.log(response);

                    if(lang === ""){
					$('#c_language').text("<?php echo e(ucfirst($translations["backoffice"]["banner_fill_language"])); ?>")
					} else{
						if(lang === "pt"){
						$('#c_language').text("Português")
						}else{
						$('#c_language').text("English")
						}
				    };

                    //Paginação
                    if(response.pagination !== undefined){
                        let pagination  = response.pagination;
                        let page        = pagination.page;
                        let pages       = Math.ceil(pagination.total / pagination.limit); //Calcula o total de paginas

                        console.log(response.pagination)

                        //Adiciona o html dos botões da paginação debaixo da lista
                        $(".pagination").html(pagination_template(page, pages));
                        console.log(pagination_template(page, pages))
                    }

                    //inicia os listeners
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

        function populate(items){
            //Limpar a lista de items
            $(".list").html("");

            console.log(items)
            $.each(items, function (key, item) {

            let status = "";

                // Obter o status da noticia
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

                let template =`
                    <div class="card d-flex flex-row mb-3">
                        <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                            <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                                <a href="/adm/pages/` + item.id + `" class="w-40 w-sm-100 truncate">
                                    <p class="list-item-heading mb-0 truncate">` + item.name + `</p>
                                </a>
                                <div class="w-20 w-sm-100 m-1">
                                    <button id="` + item.id +`" data-idTicket ="` + item.id +`"  class="badge badge-pill btn dropdown-toggle bg-primary" data-toggle="dropdown" aria-expanded="false">` + status + `</button>
                                    <div class="dropdown-menu dropdown-menu-status-index" data-ticketNumber="` + item.id + `" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(97px, 37px, 0px);">
                                        <p class="dropdown-item p-0 pl-4" onclick="changeStatus(0, ` + item.id +`)">'<span class="dot red mr-2"></span> <?php echo e(ucfirst($translations["backoffice"]["products_status_draft"])); ?></p>
                                        <p class="dropdown-item p-0 pl-4" onclick="changeStatus(1, ` + item.id +`)"><span class="dot orange mr-2"></span> <?php echo e(ucfirst($translations["backoffice"]["products_status_private"])); ?></p>
                                        <p class="dropdown-item p-0 pl-4" onclick="changeStatus(2, ` + item.id +`)"><span class="dot green mr-2"></span> <?php echo e(ucfirst($translations["backoffice"]["products_status_published"])); ?></p>
                                    </div>
                                </div>
                                <p class="mb-0 text-muted text-small w-50 w-sm-100"><?php echo e(URL); ?>` + item.lang + `/pages/` + item.url + `</p>
                                <div class="w-40 w-sm-100 m-1">
							    	<label class="custom-control custom-checkbox align-self-center float-right ml-2 my-1 mr-3">
						        	    <input type="checkbox" name="selected_ids[]" value="` + item.id + `" class="checkbox-allowed custom-control-input">
						            	<span class="custom-control-label"></span>
						        	</label>
									<button class="btn btn-outline-danger mb-1 btn-xs m-1 float-right" name="delte_slide_btn " title="apagar" id="delte_slide_btn" onclick="removePage(` + item.id + `)"><i class="simple-icon-trash"></i></button>
                                    <a href="/adm/pages/` + item.id + `" class="btn btn-outline-secondary mb-1 btn-xs m-1 float-right" name="edit_slide_btn" title="editar" id="edit_slide_btn" onclick="editSlide(3)"><i class="simple-icon-pencil"></i></a>
                                    <a class="btn btn-outline-dark mb-1 btn-xs m-1 float-right" title="copiar" onclick="clonePage(` + item.id + `)" data-id="` + item.id + `"><i class="simple-icon-docs"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                $(".list").append(template);
            });
            //Caso a lista esteja vazia
            if(items === undefined || items.length == 0){
                $(".list").html(`
                    <h4><?php echo e(ucfirst($translations["backoffice"]["not_found_male"])); ?> <?php echo e($translations["backoffice"]["pages"]); ?></h4>
                    <p class="text-muted"><?php echo e(ucfirst($translations["backoffice"]["try_again_later_empty"])); ?></p>
                `);
            }
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

        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        function changeStatus (status, id_page) {            
            $.ajax({
                url: "/api/pagesChangeStatus",
                type: "POST",
                data: {id: id_page, status: status},
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

                    // Redirecionar para a página de index das páginas
                    load()
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

        function deleteMultiple () {
            var selected = [];

            $('.checkbox-allowed:checked').each(function(){
                selected.push($(this).val());
            });

            $.confirm({
                title: '<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>',
                theme: "supervan",
                content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_many_product_remove"])); ?>',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/pages_multiple",
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

                                // Rederecionar para a página de index das notícias
                                window.location.replace("/adm/pages/");
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

        function removePage(id) {
            $.confirm({
                title: '<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>',
                theme: "supervan",
                content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_product_remove"])); ?>',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/pages/" + id,
                            type: "DELETE",
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

                                // Rederecionar para a página de index das pages
                                window.location.replace("/adm/pages/");
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
        }

        function clonePage(id) {
            $.confirm({
                title: '<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>',
                theme: "supervan",
                content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_product_clone"])); ?>',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/pagesClone",
                            type: "POST",
                            data: {id},
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

                                // Rederecionar para a página de index das pages
                                window.location.replace("/adm/pages/");
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
        }

        function listeners() {
            //butoes da paginação
            //Ao clicar na paginação
            $("body").off("click", ".page-link");
            $("body").on("click", ".page-link", function () {

                //Definir a nova pagina
                page = $(this).data("page");

                // fazer scroll para cima smooth
                window.scroll({top: 0, behavior: "smooth"});

                //Recarregar os dados da api
                load();
            });

            // Dropdown de mudar o numero de items na página
            $(".length-link").off("click");
            $(".length-link").on("click", function() {

                limit  = $(this).data("length");
                page   = 1;

                $(".news-lenght-menu").text(limit);
                load();
            });

            // Dropdown de mudar a ordenação dos items
            $(".order-menu").off("click");
            $(".order-menu").on("click", function() {

                order   = $(this).data("order");
                page    = 1;

                $(".clients-order-menu").text($(this).text());
                load();
            });

            //dropdown de mudar o idioma            
            $(".lang-menu").off("click");
            $(".lang-menu").on("click", function () {

                lang = $(this).data("lang");
                page = 1;

                
                load();
            })

            $(".search-button").off("click");
            $(".search-button").on("click", function() {

                search = $(".search-sm input").val();
                load();
            });

            $('.search-sm input').unbind( "enterKey" );
            $('.search-sm input').bind("enterKey",function(e) {

                search = $(".search-sm input").val();
                load();
            });

            $('.search-sm input').keyup(function(e) {

                if (e.keyCode == 13) {

                    $(this).trigger("enterKey");
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/pages/pages/index.blade.php ENDPATH**/ ?>