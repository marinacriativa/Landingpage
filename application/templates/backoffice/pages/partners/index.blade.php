@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <h1>{{ ucfirst($translations["backoffice"]["brands"]) }}</h1>
                        <div class="btn-group top-right-button-container">
                            <div class="btn btn-primary btn-lg pl-4 pr-0 check-button">
                                <label class="custom-control custom-checkbox mb-0 d-inline-block">
                                    <input type="checkbox" class="custom-control-input" id="checkAll">
                                    <span class="custom-control-label">&nbsp;</span>
                                </label>
                            </div>
                            <button type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split botaodrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" onclick="deleteMultiple()"> Eliminar Selecionados <i class="simple-icon-trash btn-outline-danger"></i></a>
                            </div>
                        </div>
                        <div class="text-zero top-right-button-container">
                            <div class="btn-group">
                                <a href="javascript:void(0)" data-action="newPage" type="button" class="btn btn-primary top-center-button mr-1 new-item-button add-new-brands" style="padding: 9px 34px;">{{ ucfirst($translations["backoffice"]["list_product_create"]) }}</a>
                            </div>
                        </div>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ ucfirst($translations["backoffice"]["brands"]) }}                                    
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="mb-2">
                        <div class="collapse d-block" id="displayOptions">
                            <div class="d-block d-md-inline-block">
                                <div class="btn-group float-md-left mr-1 mb-1">
                                    <button class="btn btn-outline-dark btn-xs dropdown-toggle clients-order-menu"
                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">{{ ucfirst($translations["backoffice"]["order_by"]) }}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item order-menu" data-order="id">{{ ucfirst($translations["backoffice"]["orderBy_last_inserted"]) }}</a>
                                        <a class="dropdown-item order-menu" data-order="name">{{ ucfirst($translations["backoffice"]["orderBy_name"]) }}</a>
                                        <a class="dropdown-item order-menu" data-order="active">{{ ucfirst($translations["backoffice"]["orderBy_status"]) }}</a>
                                    </div>
                                </div>
                                <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                                    <input placeholder={{ ucfirst($translations["backoffice"]["search"]) }}>
                                </div>
                                <a class="search-button"><i class="simple-icon-magnifier"></i></a>
                            </div>
                            <div class="float-md-right">
                                <span class="text-muted text-small mr-1">{{ ucfirst($translations["backoffice"]["items_per_page"]) }} </span>
                                <button class="btn btn-outline-dark btn-xs dropdown-toggle brands-lenght-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 150 </button>
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
                <div class="col-12 list sortable" data-check-all="checkAll" id="items-list">
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

            <div class="modal fade modal-right" id="big-brands-modal" tabindex="-1" role="dialog" aria-labelledby="big-brands-modal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form>
                                <h3></h3>
                                <hr>                                

                                <div id="slimBrand" class="form-group"></div>


                                <label class="form-group has-float-label">
                                    <input class="form-control" type="text" name="url">
                                    <span>Link</span>
                                </label>                               
                              
                                    
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light btn-sm cancel-modal" data-dismiss="modal">{{ ucfirst($translations["backoffice"]["banner_btn_cancel"]) }}</button>
                            <button type="button" class="btn btn-danger remove-brands btn-sm">{{ ucfirst($translations["backoffice"]["banner_btn_remove"]) }}</button>
                            <button type="button" class="btn btn-primary save-brands btn-sm">{{ ucfirst($translations["backoffice"]["banner_btn_save"]) }}</button>
                        </div>
                    </div>
                </div>
            </div>
            
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@section('scripts')
    <script>   
          
        let query = parseQueryString();

        var page        = (query.page   !== undefined) ? query.page     : 1;
        var limit       = (query.limit  !== undefined) ? query.limit    : 150;
        var order       = (query.order  !== undefined) ? query.order    : "order_by";
        var search      = (query.search !== undefined) ? query.search   : "";

        //Meter o input search com os valores GET se tiver
        if (query.search !== undefined && query.search.length > 0) {

            $(".search-sm input").val(query.search);
        }

        if (query.limit !== undefined && query.limit.length > 0) {
            $(".brands-lenght-menu").text(limit);
        } 

        // Iniciar o plugin de imagens Slim

        function slimDefaultConfig(meta) {

            return {
                
                push: true,
                service: '/api/image/slim',
                label: 'Carregar',
                statusUploadSuccess: 'Guardado!',
                ratio: "16:9",
                
                buttonCancelLabel: 'Cancelar',
                buttonConfirmLabel: 'Confirmar',
                buttonEditLabel: 'Editar',
                buttonDownloadLabel: 'Download',
                buttonUploadLabel: 'Upload',
                
                buttonCancelTitle: 'Cancelar',
                buttonConfirmTitle: 'Confirmar',
                buttonEditTitle: 'Editar',
                buttonDownloadTitle: 'Download',
                buttonUploadTitle: 'Upload',
                buttonRotateTitle: 'Rodar',
                buttonRemoveTitle: 'Remover',

                meta : meta
            }
        }

        brands();

        function removeBrand(id) {         
            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_product_remove"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/partners/" + id,
                            type: "DELETE",
                            dataType: "json",
                            success: function (response) {

                                if (!response.success) {

                                    // Output do erro
                                    console.error(response);

                                    $.alert({
                                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                        theme: "supervan",
                                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                                    });

                                    // Não deixar a função executar mais
                                    return;
                                }

                                // Redirecionar para a página de index das marcas
                                window.location.replace("/adm/partners/");
                            },
                            error: function (jqXHR, textStatus, errorThrown) {

                                console.log(textStatus, errorThrown);

                                $.alert({
                                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                    theme: "supervan",
                                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                                });
                            }
                        });

                    },
                    Não: {}
                }
            });
        }

        function deleteMultiple () {
            var selected = [];

            $('.checkbox-allowed:checked').each(function(){
                selected.push($(this).val());
            });

            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_many_product_remove"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/partners_multiple",
                            type: "POST",
                            data: {selected},
                            dataType: "json",
                            success: function (response) {

                                if (!response.success) {

                                    // Output do erro
                                    console.error(response);

                                    $.alert({
                                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                        theme: "supervan",
                                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                                    });

                                    // Não deixar a função executar mais
                                    return;
                                }

                                // Rederecionar para a página de index das notícias
                                window.location.replace("/adm/partners/");
                            },
                            error: function (jqXHR, textStatus, errorThrown) {

                                console.log(textStatus, errorThrown);

                                $.alert({
                                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                    theme: "supervan",
                                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                                });
                            }
                        });

                    },
                    Não: {}
                }
            });
         
            console.log(selected);
        }
        

        function cloneBrand(id) {
            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_product_clone"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/partnersClone",
                            type: "POST",
                            data: {id},
                            dataType: "json",
                            success: function (response) {

                                if (!response.success) {

                                    // Output do erro
                                    console.error(response);

                                    $.alert({
                                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                        theme: "supervan",
                                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                                    });

                                    // Não deixar a função executar mais
                                    return;
                                }

                                // Rederecionar para a página de index das notícias
                                window.location.replace("/adm/partners/");
                            },
                            error: function (jqXHR, textStatus, errorThrown) {

                                console.log(textStatus, errorThrown);

                                $.alert({
                                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                    theme: "supervan",
                                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                                });
                            }
                        });

                    },
                    Não: {}
                }
            });
        }

        function brands() {
            
            initBrands();

            function initBrands() {

                $("#slimBrand").slim(slimDefaultConfig( { folder: 'partners' } ));

                window.history.replaceState("", "", '/adm/partners?' + $.param( { limit: limit, order: order, page: page, search: search } ));                    

                $.ajax({
                    url: "/api/partners?page=" + page + "&search=" + search + "&limit=" + limit + "&order=" + order,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {

                        if (!response.success) {

                            // Output do erro
                            console.error(response);

                            $.alert({
                                title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                theme: "supervan",
                                content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                            });

                            // Não deixar a função executar mais
                            return;
                        }                 
                                               
                        
                        populatebrands(response.data);                              
                        
                        // Ativar os listners 
                        listenersbrands();

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
                                    url: "/api/partners/sortable",
                                    type: "POST",
                                    data: {ids: ids},
                                    dataType: "json",
                                    success: function (response) {
                                        if (!response.success) {
                                        // Output do erro
                                        console.error(response);
                                        $.alert({
                                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                            theme: "supervan",
                                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                                        });
                                        // Não deixar a função executar mais
                                        return;
                                        }
                                    }
                                })
                            }
                        })
                        
                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                        console.log(textStatus, errorThrown);

                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });
                    }
                });
                
            }  
            
            
            
            function populatebrands(items) {
                $(`#items-list`).html("");

                $.each(items, function (key, brands) {
                    let is_checked = brands.active == 1 ? 'checked' : '';
                    $(`#items-list`).append(`
                    <div class="card d-flex flex-row mb-3" data-id="` + brands.id + `">    
                        <a class="d-flex a-index-img edit-brands" data-id="` + brands.id + `" href="javascript:void(0)">
                            <div class="background-image" style="background-image: url(`+ brands.path +`)"></div>
                        </a>                    
                        <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                            <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                                <a href="javascript:void(0)" class="w-40 w-sm-100 truncate edit-brands" data-id="` + brands.id + `">
                                    <p class="list-item-heading mb-0 truncate">` + brands.url + `</p>
                                </a>                              
                                <div class="w-40 w-sm-100 ">
							    	<label class="custom-control custom-checkbox align-self-center float-right ml-2 my-1 mr-3">
										<input type="checkbox" name="selected_ids[]" value="` + brands.id + `" class="checkbox-allowed custom-control-input">
						            	<span class="custom-control-label"></span>
						        	</label>                                    
									<button class="btn btn-outline-danger mb-1 btn-xs m-1 float-right" name="delte_slide_btn " title="apagar" id="delte_slide_btn" onclick="removeBrand(` + brands.id + `)"><i class="simple-icon-trash"></i></button>
                                    <button class="btn btn-outline-secondary btn-xs m-1 float-right edit-brands" data-id="` + brands.id + `" name="edit_slide_btn" title="editar" id="edit_slide_btn"><i class="simple-icon-pencil"></i></button>
                                    <a class="btn btn-outline-dark mb-1 btn-xs m-1 float-right" title="copiar" onclick="cloneBrand(` + brands.id + `)" data-id="` + brands.id + `"><i class="simple-icon-docs"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    `);
                });
                
                //Caso os items estejam vazios
                if (items === undefined || items.length == 0) {

                    //Na listagem meter uma mensagem a dizer que está vazio
                    $(`#items-list`).html(`
                        <h4>{{ ucfirst($translations["backoffice"]["not_found_male"]) }} {{ $translations["backoffice"]["brands"] }}</h4>
                        <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
                    `);
                }  
            } 

            $("#checkAll").click(function(){
            $('.checkbox-allowed').not(this).prop('checked', this.checked);
            
        });

            function editbrands(id = "", data) {       
            
                $.ajax({
                    url: "/api/partners/" + id,
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function(response) {

                        if (!response.success) {

                            // Output do erro
                            console.error(response);

                            $.alert({
                                title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                theme: "supervan",
                                content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                            });

                            initBrands()

                            // Não deixar a função executar mais
                            return;
                        }                       
                        
                        // Obter dados novos do servidor
                        initBrands();


                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                        console.log(textStatus, errorThrown);

                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });
                    }
                });
            }

            function cleanEditor() {
                $("#big-brands-modal form").trigger("reset");     
                $("#slimBrand").slim('remove');
                refreshAgentsGroup ();
            }

            function listenersbrands() {               

                // Ao clicar no adicionar metodo               
                $(".add-new-brands").off("click");
                $(".add-new-brands").on("click", function() {
                   
                    // Alterar o titulo do modal
                    $("#big-brands-modal h3").text("Nova Marca");

                    cleanEditor();                      

                    $('[name="agents_group"]').tagsinput('refresh');

                    $(".remove-brands").hide();

                    // Retirar id do botao
                    $(".save-brands").data("id", "");

                    $("#slimBrand").slim('remove');

                    $("#big-brands-modal").modal("show");
                });

                $(".change_active_status").off("click");
                $(".change_active_status").on("click", function() {

                    let id  = $(this).attr("data-id");

                    $.ajax({
                        url: "/api/partnersActive/" + id,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {

                            if (!response.success) {

                                // Output do erro
                                console.error(response);

                                $.alert({
                                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                    theme: "supervan",
                                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                                });

                                initBrands()

                                // Não deixar a função executar mais
                                return;
                            }                       
                            
                            // Obter dados novos do servidor
                            initBrands();


                        },
                        error: function(jqXHR, textStatus, errorThrown) {

                            console.log(textStatus, errorThrown);

                            $.alert({
                                title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                theme: "supervan",
                                content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                            });
                        }
                    });
                    
                });

                // Ao clicar no editar  
                $(".edit-brands").off("click");
                $(".edit-brands").on("click", function() {

                    cleanEditor();

                    // Alterar o titulo do modal
                    $("#big-brands-modal h3").text("Editar marca");

                    let id = $(this).data("id");

                    // Adicionar o id ao botao de salvar
                    $(".save-brands").data("id", id);

                    $(".remove-brands").show();

                    // Introduzir os dados no modal
                    $.get("/api/partners/" + id, function(response) {


                        console.log(response);                      

                        let coupon_data = response.data;                        

                        $.each(coupon_data, function(key, value) {

                            if (key == "path"){
                                if (value != null && value.length > 0) {                                    
                                    // Carregar imagem do slide
                                    $("#slimBrand").slim('load',  value, { blockPush : true }, function(error, data) { });
                                }
                            } else if (key == "active") {

                                $("#activatedSwitch").prop('checked', (value == "1"));

                            } else {

                                $("#big-brands-modal [name='" + key + "']").val(value);
                            }
                        });                            
                        
                        $('[name="agents_group"]').tagsinput('refresh');
                        
                        // Abrir o modal de editar
                        $("#big-brands-modal").modal("show");                       
                        
                    });


                });

                 // Dropdown de mudar o numero de items na página
                $(".length-link").off("click");
                $(".length-link").on("click", function() {

                    limit  = $(this).data("length");
                    page   = 1;

                    $(".brands-lenght-menu").text(limit);
                    initBrands();
                });

                // Dropdown de mudar a ordenação dos items
                $(".order-menu").off("click");
                $(".order-menu").on("click", function() {

                    order   = $(this).data("order");
                    page    = 1;

                    $(".clients-order-menu").text($(this).text());
                    initBrands();
                });

                $(".search-button").off("click");
                $(".search-button").on("click", function() {

                    search = $(".search-sm input").val();
                    initBrands();
                });

                $('.search-sm input').unbind( "enterKey" );
                $('.search-sm input').bind("enterKey",function(e) {

                    search = $(".search-sm input").val();
                    initBrands();
                });

                $('.search-sm input').keyup(function(e) {

                    if (e.keyCode == 13) {

                        $(this).trigger("enterKey");
                    }
                });

                //Ao clicar no eliminar
                $(".remove-brands").off("click");
                $(".remove-brands").on("click", function() {

                    let id = $(".save-brands").data("id");

                    removebrands(id);

                    $("#big-brands-modal").modal("hide");

                });

                //Ao clicar na paginação
                $("body").off("click", ".page-link");
                $("body").on("click", ".page-link", function () {

                    //Definir a nova pagina
                    page = $(this).data("page");

                    // fazer scroll para cima smooth
                    window.scroll({top: 0, behavior: "smooth"});

                    //Recarregar os dados da api
                    initBrands();
                })

                // Guardar o método de envio
                $(".save-brands").off("click");
                $(".save-brands").on("click", function() {

                    if($("[name='code']").val() != "" && $("[name='discount']").val() != "") {
                         // Vereficar se vamos guardar ou editar
                        let id = $(this).data("id");
                        let data = $("#big-brands-modal form").serialize();
                    
                        editbrands(id, data);
                        
                        cleanEditor();
                        
                        $("#big-brands-modal").modal("hide");
                        
                        // Retirar o id do data-id para uma proxima ação
                        $(this).data("id", "");
                    }
                });
            }

            function refreshAgentsGroup () {
                $('#group_ipt').html(`
                    <input type="text" name="agents_group" class="form-control"> 
                    <span>Grupos</span> `);  
            }

            // Eliminar a método de envio
            function removebrands(id) {

                $.confirm({
                    title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                    theme: "supervan",
                    content: '{{ ucfirst($translations["backoffice"]["confirm_message_coupons"]) }}',
                    buttons: {

                        Sim: function() {
                            $.ajax({
                                url: "/api/partners/" + id,
                                // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                                // De texto, etc e em alguns servidores pode dar erro
                                type: "DELETE",
                                dataType: "json",
                                success: function(response) {

                                    if (!response.success) {

                                        // Output do erro
                                        console.error(response);

                                        $.alert({
                                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                            theme: "supervan",
                                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                                        });

                                        // Não deixar a função executar mais
                                        return;
                                    }

                                    // Obter dados novos do servidor
                                    initBrands();
                                },
                                error: function(jqXHR, textStatus, errorThrown) {

                                    console.log(textStatus, errorThrown);

                                    $.alert({
                                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                        theme: "supervan",
                                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                                    });
                                }
                            });

                        },
                        Não: {}
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
   

        }
    </script>
@endsection


