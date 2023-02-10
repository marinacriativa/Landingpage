@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <h1>Coupons</h1>
                        <div class="btn-group top-right-button-container">
                            <div class="btn btn-primary btn-lg pl-4 pr-0 check-button">
                                <label class="custom-control custom-checkbox mb-0 d-inline-block">
                                    <input type="checkbox" class="custom-control-input" id="checkAll">
                                    <span class="custom-control-label">&nbsp;</span>
                                </label>
                            </div>
                            <button type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split botaodrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" onclick="deleteMultiple()"> Eliminar Selecionados <i class="simple-icon-trash btn-outline-danger"></i></a>
                            </div>
                        </div>
                        <div class="text-zero top-right-button-container">
                            <div class="btn-group">
                                <a href="#" data-action="newPage" type="button"
                                    class="btn btn-primary top-center-button mr-1 new-item-button add-new-coupons"
                                    style="padding: 9px 34px;">{{ ucfirst($translations["backoffice"]["list_product_create"]) }}</a>
                            </div>
                        </div>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ ucfirst($translations["backoffice"]["coupons"]) }}                                    
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="mb-2">
                        <div class="collapse d-md-block" id="displayOptions">
                            <div class="d-block d-md-inline-block">
                                <div class="btn-group float-md-left mr-1 mb-1">
                                    <button class="btn btn-outline-dark btn-xs dropdown-toggle coupons-order-menu"
                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">{{ ucfirst($translations["backoffice"]["order_by"]) }}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item order-menu" data-order="id">{{ ucfirst($translations["backoffice"]["orderBy_last_inserted"]) }}</a>
                                        <a class="dropdown-item order-menu" data-order="code">{{ ucfirst($translations["backoffice"]["orderBy_name"]) }}</a>
                                        <a class="dropdown-item order-menu" data-order="type">Tipo de ficheiro</a>
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
                                <button class="btn btn-outline-dark btn-xs dropdown-toggle coupons-lenght-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 10 </button>
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
                <div class="col-12 list" data-check-all="checkAll" id="items-list">
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

            <div class="modal fade modal-right" id="big-coupons-modal" tabindex="-1" role="dialog" aria-labelledby="big-coupons-modal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form id="form-coupon">
                                <h3></h3>
                                <hr>                                

                                <label class="form-group has-float-label">
                                    <input class="form-control" name="code" required/>
                                    <span>Código do Coupon</span>
                                </label>
                                
                                <label class="form-group has-float-label"> 
                                    <input type="text" name="tags" class="form-control"> 
                                    <span>{{ ucfirst($translations["backoffice"]["edit_products_fill_badges"]) }}</span> 
                                </label>
                                    
                                
                                <label class="form group">Cupom válido somente para a primeira compra?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input class="form-check-input" type="radio" name="first_purchase"
                                            id="gridRadios1" value="1" checked>
                                        <label class="form-check-label" for="gridRadios1">
                                            Sim
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="first_purchase"
                                            id="gridRadios2" value="0">
                                        <label class="form-check-label" for="gridRadios2">
                                            Não
                                        </label>
                                    </div>
                                </div>  

                                <div class="mb-2 mt-4">
                                    <label class="col-form-label">Onde irá aplicar o desconto?</label>
                                    <div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="apply_discount"
                                                id="val_prod" value="0" checked>
                                            <label class="form-check-label" for="val_prod">
                                                Valor dos Produtos + Frete
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="apply_discount"
                                                id="only_prod" value="1">
                                            <label class="form-check-label" for="only_prod">
                                                Somente nos Produtos
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="apply_discount"
                                                id="only_driver" value="2">
                                            <label class="form-check-label" for="only_driver">
                                                Somente no Frete
                                            </label>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row mb-2 mt-4">
                                    <label class="col-form-label col-sm-6 pt-0">Tipo de desconto</label>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type"
                                                id="percentage" value="0" checked>
                                            <label class="form-check-label" for="percentage">
                                                Percentagem ( % )
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type"
                                                id="money" value="1">
                                            <label class="form-check-label" for="money">
                                                Dinheiro ( € )
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <label class="form-group has-float-label">
                                    <input class="form-control" name="discount" required/>
                                    <span>Valor do desconto</span>
                                </label>

                                <label class="form-group has-float-label" id="customer_ipt">
                                    
                                </label>

                                
                                <label class="form-group has-float-label" id="products_ipt">
                                    
                                </label>

                                <div class="form-group mb-4">
                                    <label>Data em vigor</label>
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="date" class="input-sm form-control" name="start_date"
                                            placeholder="Start" />
                                        <span class="input-group-addon"></span>
                                        <input type="date" class="input-sm form-control" name="end_date"
                                            placeholder="End" />
                                    </div>
                                </div>

                                <label class="form-group">
                                    <label>É válido para compras acima de qual valor?</label>
                                    <div class="has-float-label">
                                        <span>Valor</span>
                                        <input class="form-control" type="number" name="start_price"/>
                                    </div>
                                </label>

                                <label class="form group">Poderá ser utilizado várias vezes pela mesma pessoa?</label>
                                <div class="d-flex mb-4">
                                    <div class="form-check mr-3">
                                        <input class="form-check-input" type="radio" name="reused"
                                            id="reused_yes" value="0" checked>
                                        <label class="form-check-label" for="reused_yes">
                                            Sim
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="reused"
                                            id="reused_not" value="1">
                                        <label class="form-check-label" for="reused_not">
                                            Não
                                        </label>
                                    </div>
                                </div>

                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" name="description" />
                                    <span>Descrição para controle interno</span>
                                </label>
                               
                                <span class="custom-switch custom-switch-secondary mb-2 custom-switch-small vertical-align-center"> 
                                    <input class="custom-switch-input" id="activatedSwitch" type="checkbox" name="active"> 
                                    <label rel="tooltip" title="Desativado / Ativado" class="custom-switch-btn" for="activatedSwitch"></label> 
                                </span>
                                    
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">{{ ucfirst($translations["backoffice"]["banner_btn_cancel"]) }}</button>
                            <button type="button" class="btn btn-danger remove-coupons btn-sm">{{ ucfirst($translations["backoffice"]["banner_btn_remove"]) }}</button>
                            <button type="button" class="btn btn-primary save-coupon btn-sm">{{ ucfirst($translations["backoffice"]["banner_btn_save"]) }}</button>
                        </div>
                    </div>
                </div>
            </div>
            
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@section('scripts')
    <script>
    
        let query = parseQueryString();

        var page        = (query.page   !== undefined) ? query.page     : 1;
        var limit       = (query.limit  !== undefined) ? query.limit    : 150;
        var order       = (query.order  !== undefined) ? query.order    : "id";
        var search      = (query.search !== undefined) ? query.search   : "";

        //Meter o input search com os valores GET se tiver
        if (query.search !== undefined && query.search.length > 0) {

            $(".search-sm input").val(query.search);
        }

        if (query.limit !== undefined && query.limit.length > 0) {
            $(".coupons-lenght-menu").text(limit);
        } 

        coupons();

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
                                url: "/api/coupons_multiple",
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

                                    // Redirecionar para a página de index das notícias
                                    window.location.replace("/adm/coupons/");
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

            function removeCoupon(id) {
                $.confirm({
                    title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                    theme: "supervan",
                    content: '{{ ucfirst($translations["backoffice"]["confirm_product_remove"]) }}',
                    buttons: {

                        Sim: function () {
                            $.ajax({
                                url: "/api/coupons/" + id,
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

                                    // Redirecionar para a página de index das notícias
                                    window.location.replace("/adm/coupons/");
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

            function cloneCoupon(id) {
                $.confirm({
                    title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                    theme: "supervan",
                    content: '{{ ucfirst($translations["backoffice"]["confirm_product_clone"]) }}',
                    buttons: {

                        Sim: function () {
                            $.ajax({
                                url: "/api/couponsClone",
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

                                    // Redirecionar para a página de index dos produtos
                                    window.location.replace("/adm/coupons/");
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

        function coupons() {

            function refreshGroups () {
                $('#products_ipt').html(`
                    <input data-role="tagsinput" type="text" name="products_group">
                    <span>Grupo de produtos</span> `);  

                $('#customer_ipt').html(`
                        <input data-role="tagsinput" type="text" name="customer_group">
                        <span>Grupo de clientes</span> `);  
            }

            initCoupons();

            function initCoupons() {

                window.history.replaceState("", "", '/adm/coupons?' + $.param( { limit: limit, order: order, page: page, search: search } ));  

                // Temos de obter os coupons                         

                $.ajax({
                    url: "/api/coupons?page=" + page + "&search=" + search + "&limit=" + limit + "&order=" + order,
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

                        populatecoupons(response.data);
                        
                        
                        // Ativar os listners 
                        listnerscoupons();

                        //Paginação
                        if (response.pagination !== undefined) {
    
                            let pagination  = response.pagination;
                            let page        = pagination.page;
                            let pages       = Math.ceil(pagination.total / pagination.limit); //Calcula o total de paginas
    
                            //Adiciona o html dos botões da paginação debaixo da lista
                            $(".pagination").html(pagination_template(page, pages));
                        }
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
            
            function populatecoupons(items) {
                $(`#items-list`).html("");

                $.each(items, function (key, coupons) {
                    let type = coupons.type == "1" ? '€' : '%';

                    $(`#items-list`).append(`
                        <div class="card d-flex flex-row mb-3" data-id="` + coupons.id + `">                        
                            <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                                <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                                    <a href="javascript:void(0)" class="w-40 w-sm-100 truncate edit-coupons" data-id="` + coupons.id + `">
                                        <p class="list-item-heading mb-0 truncate">` + coupons.code +`</p>
                                    </a>
                                    <p class="mb-0 text-muted text-small w-10 w-sm-100 m-1">` + coupons.discount + type + `</p>
                                    <p class="mb-0 text-muted text-small w-10 w-sm-100 m-1 truncate">` + coupons.description + `</p>
                                    <div class="w-40 w-sm-100 m-1">
                                        <label class="custom-control custom-checkbox align-self-center float-right ml-2 my-1 mr-1">
                                            <input type="checkbox" name="selected_ids[]" value="` + coupons.id + `" class="checkbox-allowed custom-control-input">
                                            <span class="custom-control-label"></span>
                                        </label>
                                        <button class="btn btn-outline-danger btn-xs m-1 float-right" name="delte_slide_btn " title="apagar" id="delte_slide_btn" onclick="removeCoupon(` + coupons.id + `)"><i class="simple-icon-trash"></i></button>
                                        <button class="btn btn-outline-secondary btn-xs m-1 float-right edit-coupons" data-id="` + coupons.id + `" name="edit_slide_btn" title="editar" id="edit_slide_btn"><i class="simple-icon-pencil"></i></button>
                                        <a class="btn btn-outline-dark btn-xs m-1 float-right" title="copiar" onclick="cloneCoupon(` + coupons.id + `)" data-id="` + coupons.id + `"><i class="simple-icon-docs"></i></a>
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
                        <h4>{{ ucfirst($translations["backoffice"]["not_found_male"]) }} {{ $translations["backoffice"]["coupons"] }}</h4>
                        <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
                    `);
                }  
            }

            $("#checkAll").click(function(){
                $('input:checkbox').not(this).prop('checked', this.checked);
            });


            function editcoupons(id = "") {   
                
                var form = document.getElementById('form-coupon');
                var formData = new FormData(form)                
                
                if($('[name="first_purchase"]').checked) {
                    formData.append('first_purchase', $('[name="first_purchase"]').val());
                }   
                
                if($('[name="apply_discount"]').checked) {
                    formData.append('apply_discount', $('[name="apply_discount"]').val());
                } 
                
                if($('[name="type"]').checked) {
                    formData.append('type', $('[name="type"]').val());
                }  
                
                if($('[name="reused"]').checked) {
                    formData.append('reused', $('[name="reused"]').val());
                } 
            
            
                $.ajax({
                    url: "/api/coupons/" + id,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response.data.coupon_exists)
                        
                        if(response.data.coupon_exists) {
                            // Output do erro
                            console.error(response);

                            $.alert({
                                title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                theme: "supervan",
                                content: response.data.coupon_exists,
                            });

                            // Não deixar a função executar mais
                            return;
                        }
                        else if (!response.success) {

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
                        initCoupons();

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
                $("#big-coupons-modal form").trigger("reset");

                refreshGroups ();
            }

            function listnerscoupons() {

                // Ao clicar no adicionar metodo               
                $(".add-new-coupons").off("click");
                $(".add-new-coupons").on("click", function() {
                   
                    // Alterar o titulo do modal
                    $("#big-coupons-modal h3").text("Novo coupon");

                    cleanEditor();

                    $('[name="products_group"]').tagsinput('refresh');
                    $('[name="customer_group"]').tagsinput('refresh');

                    $(".remove-coupons").hide();

                    $("[name='align']").prop('checked', false);

                    // Retirar id do botao
                    $(".save-coupon").data("id", "");

                    $("#big-coupons-modal").modal("show");
                });

                // Ao clicar no editar
                $(".edit-coupons").off("click");
                $(".edit-coupons").on("click", function() {

                    cleanEditor();

                    // Alterar o titulo do modal
                    $("#big-coupons-modal h3").text("Editar coupon");

                    let id = $(this).data("id");

                    // Adicionar o id ao botao de salvar
                    $(".save-coupon").data("id", id);

                    $(".remove-coupons").show();

                    // Introduzir os dados no modal
                    $.get("/api/coupons/" + id, function(response) {

                        $("[name='align']").prop('checked', false);

                        let coupon_data = response.data;

                        $.each(coupon_data, function(key, value) {

                            switch(key) {
                                case 'active':
                                    $("#activatedSwitch").prop('checked', (value == "1"));
                                    break;
                                
                                case 'first_purchase':
                                    if(value == 1) {                                    
                                        $('#gridRadios1').prop('checked', true);                      
                                    } else {
                                        $('#gridRadios2').prop('checked', true);
                                    }
                                    break;
                                
                                case 'apply_discount':
                                    if(value == 0) {                                    
                                        $('#val_prod').prop('checked', true);                      
                                    } else if (value == 1) {
                                        $('#only_prod').prop('checked', true);
                                    } else if (value == 2) {
                                        $('#only_driver').prop('checked', true);
                                    }
                                   break;

                                case 'type':
                                    if(value == 0) {                                    
                                        $('#percentage').prop('checked', true);                      
                                    } else {
                                        $('#money').prop('checked', true);
                                    }
                                   break;

                                case 'reused':
                                    if(value == 0) {                                    
                                        $('#reused_yes').prop('checked', true);                      
                                    } else {
                                        $('#reused_not').prop('checked', true);
                                    }
                                   break;                               
                                
                                default:
                                    $("#big-coupons-modal [name='" + key + "']").val(value);
                                    break;
                            }        

                        });      
                        
                        $('[name="products_group"]').tagsinput('refresh');
                        $('[name="customer_group"]').tagsinput('refresh');
                        

                        // Abrir o modal de editar
                        $("#big-coupons-modal").modal("show");
                    });
                });

                // Dropdown de mudar o numero de items na página
                $(".length-link").off("click");
                $(".length-link").on("click", function() {

                    limit  = $(this).data("length");
                    page   = 1;

                    $(".coupons-lenght-menu").text(limit);
                    initCoupons();
                });

                // Dropdown de mudar a ordenação dos items
                $(".order-menu").off("click");
                $(".order-menu").on("click", function() {

                    order   = $(this).data("order");
                    page    = 1;

                    $(".coupons-order-menu").text($(this).text());
                    initCoupons();
                });

                $(".search-button").off("click");
                $(".search-button").on("click", function() {

                    search = $(".search-sm input").val();
                    initCoupons();
                });

                $('.search-sm input').unbind( "enterKey" );
                $('.search-sm input').bind("enterKey",function(e) {

                    search = $(".search-sm input").val();
                    initCoupons();
                });

                $('.search-sm input').keyup(function(e) {

                    if (e.keyCode == 13) {

                        $(this).trigger("enterKey");
                    }
                });

                //Ao clicar no eliminar
                $(".remove-coupons").off("click");
                $(".remove-coupons").on("click", function() {

                    let id = $(".save-coupon").data("id");

                    removecoupons(id);

                    $("#big-coupons-modal").modal("hide");

                });

                // Guardar o método de envio
                $(".save-coupon").off("click");
                $(".save-coupon").on("click", function() {
                    if($("[name='code']").val() != "" && $("[name='discount']").val() != "" && $("[name='start_date']").val() != "" && $("[name='end_date']").val() != "") {
                         // Vereficar se vamos guardar ou editar
                        let id = $(this).data("id");                           

                        editcoupons(id);
                        
                        cleanEditor();
                        
                        $("#big-coupons-modal").modal("hide");
                        
                        // Retirar o id do data-id para uma proxima ação
                        $(this).data("id", "");
                    } else {
                        alert('Os campos: Código do coupon, Valor do desconto, e Datas em vigor são obrigatórios.')
                    }
                });
            }

            // Eliminar a método de envio
            function removecoupons(id) {

                $.confirm({
                    title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                    theme: "supervan",
                    content: '{{ ucfirst($translations["backoffice"]["confirm_message_coupons"]) }}',
                    buttons: {

                        Sim: function() {
                            $.ajax({
                                url: "/api/coupons/" + id,
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
                                    initCoupons();
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


