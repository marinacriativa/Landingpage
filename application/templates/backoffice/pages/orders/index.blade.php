@extends('layouts.master')
@section('content')
<main class="default-transition pt-5 mb-5 collapsable-main no-load">
    <div class="p-desktop-5">
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <h1>{{ ucfirst($translations["backoffice"]["orders"]) }}</h1>
                    <div class="text-zero top-right-button-container">
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ ucfirst($translations["backoffice"]["orders"]) }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="mb-2">
                    <a class="btn pt-0 pl-0 d-inline-block d-md-none" data-toggle="collapse" href="#displayOptions" role="button" aria-expanded="true" aria-controls="displayOptions">
                        {{ ucfirst($translations["backoffice"]["view_options"]) }}
                        <i class="simple-icon-arrow-down align-middle"></i>
                    </a>
                    <div class="collapse d-md-block" id="displayOptions">
                        <div class="d-block d-md-inline-block">
                            <div class="btn-group float-md-left mr-1 mb-1">
                                <button class="btn btn-outline-dark btn-xs dropdown-toggle clients-order-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ ucfirst($translations["backoffice"]["order_by"]) }}
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item order-menu" data-order="id">{{ ucfirst($translations["backoffice"]["latest_added_female"]) }}</a>
                                    <a class="dropdown-item order-menu" data-order="pay_amount">{{ ucfirst($translations["backoffice"]["value"]) }}</a>
                                </div>
                            </div>
                            <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                                <input placeholder="{{ ucfirst($translations["backoffice"]["search"]) }}...">
                            </div>
                            <a class="search-button"><i class="simple-icon-magnifier"></i></a>
                        </div>
                        <div class="float-md-right">
                            <span class="text-muted text-small mr-1">{{ ucfirst($translations["backoffice"]["listing"]) }} </span>
                            <button class="btn btn-outline-dark btn-xs dropdown-toggle orders-lenght-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                10
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
@endsection
@section('scripts')

<script>
    
    /*
        Filtros, página, etc deste index ok
        Os valores que metemos aqui, são os valores iniciais
    */

    let query = parseQueryString();

    var page    = (query.page   !== undefined) ? query.page     : 1;
    var limit   = (query.limit  !== undefined) ? query.limit    : 10;
    var order   = (query.order  !== undefined) ? query.order    : "id";
    var search  = (query.search !== undefined) ? query.search   : "";

    // Meter o input search com os valores do GET se tiver
    if (query.search !== undefined && query.search.length > 0) {

        $(".search-sm input").val(query.search);
    }

    if (query.limit !== undefined && query.limit.length > 0) {

        $(".orders-lenght-menu").text(limit);
    }

    // Iniciar a página das encomendas
    load();

    function load() {

        // Atualizar o url para ter os novos parametros GET
        window.history.replaceState("", "", '/adm/orders?' + $.param({
            limit: limit,
            order: order,
            page: page,
            search: search
        }));

        $.ajax({
            url: "/api/orders?page=" + page + "&search=" + search + "&length=" + limit + "&order=" + order,
            type: "GET",
            dataType: "json",
            success: function(response) {

                removeTemplateLoader();

                if (!response.success) {

                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });

                    console.error(response);

                    // Não deixar a função executar mais
                    return;
                }

                // Inserir as encomendas obtidas pela api na listagem
                populate(response.data.orders_data);

                // Paginação
                if (response.pagination !== undefined) {

                    let pagination = response.pagination;
                    let page = pagination.page;
                    let pages = Math.ceil(pagination.total / pagination.limit); // Calcular o total de páginas

                    // Adicionar o html dos botões da paginação debaixo da lista
                    $(".pagination").html(pagination_template(page, pages));
                }

                // Ativar os listners
                listners();

            },
            error: function(jqXHR, textStatus, errorThrown) {

                console.error(textStatus, errorThrown);

                $.alert({
                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                    theme: "supervan",
                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                });
            }
        });
    }

    function populate(items) {

        // Limpar a lista de items que temos
        $(".list").html("");

        $.each(items, function(key, item) {

            let status = "";

            $.each(item.status_data, function(key, item_status) {

                if (item.status === item_status.id) {

                    status = item_status.name;
                }
            })

            let template = `
                <div class="cardRowContainer">
                    <div class="card d-flex flex-row mb-3" id="cardRow">
                        <div class="d-flex flex-grow-1 min-width-zero">
                            <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                <a href="/adm/orders/show/` + item.id + `" class="list-item-heading mb-0 truncate w-10 w-xs-100 centerText-max-w-767">  ` + item.order_number + ` </a>
                                <p class="mb-0 text-muted text-small w-10 w-xs-100 displayNone-max-w-900 displayBlock-max-w-767 centerText-max-w-767"> ` + item.customer_name + `</p>
                                <p class="mb-0 text-muted truncate text-small w-10 w-xs-100 displayNone-max-w-1199 displayBlock-max-w-767 centerText-max-w-767"> ` + item.customer_email + `</p>
                                <p class="mb-0 text-muted text-small w-10 w-xs-100 centerText-max-w-767"> ` + item.pay_amount + `€</p>
                                <div class="w-5 w-xs-100 ">
                                    <div class="badge badge-pill btn bg-light">` + item.lang.toUpperCase() + `</div>
                                </div>
                                <div class="w-15 w-xs-100 centerText-max-w-767 displayNone-max-w-1199 displayBlock-max-w-767">
                                    <button id="` + item.order_number +`" data-idOrder ="` + item.id +`"  class="badge badge-pill btn dropdown-toggle bg-info" data-toggle="dropdown" aria-expanded="false">` + status + `</button>
                                    <div class="dropdown-menu dropdown-menu-status-index" data-orderNumber="` + item.order_number + `" aria-labelledby="btnGroupDrop1" x-placement="bottom-start">
                                    </div>
                                </div>
                                <p class="badge badge-light truncate mb-0 text-muted text-small w-10 w-xs-100 displayNone-max-w-1199 displayBlock-max-w-767 centerText-max-w-767">` + item.created_at.substring(0, 10) + `</p>
                            </div>
                        </div>
                    </div>
                </div>`;

            $(".list").append(template);

            populateDropdownStatus(item.status_data)
        });

        // Caso o items esteja vazio
        if (items === undefined || items.length == 0) {

            // Na listagem meter uma mensagem a dizer que está vazio
            $(".list").html(`
                <h4>{{ ucfirst($translations["backoffice"]["not_found_male"]) }} {{ $translations["backoffice"]["orders"] }}</h4>
                <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
            `);
        }
    }


    function populateDropdownStatus(items) {

        $(".dropdown-menu-status-index").html("");

        $.each(items, function(key, item) {

            let templateStatus = `<p class="dropdown-item" data-idStatus = "` + item.id + `">` + item.name + `</p>`;

            $(".dropdown-menu-status-index").append(templateStatus);
        });
    }

    function listners() {

        // Ao clicar na paginação
        $("body").off("click", ".page-link");
        $("body").on("click", ".page-link", function() {

            // Definir a nova página
            page = $(this).data("page");

            // Fazer scroll para cima, mas smoooooth
            window.scroll({
                top: 0,
                behavior: "smooth"
            })

            // Recarregar os dados da API
            load();
        });

        //Ao carregar em qualquer item da dropDown
        $(".dropdown-menu-status-index").on("click", ".dropdown-item", function () {

            //Guarda o texto do item selecionado
            let nameSelectStatus    = $(this).text();
            let orderNumber         = $(this).closest(".dropdown-menu-status-index").data("ordernumber");

            $(`#${orderNumber}`).html(nameSelectStatus)

            //vai buscar e guarda o id do estado que foi guardado no data-idStatus
            let idStatus = $(this).attr("data-idstatus")

            //Vai buscar o idOrder atravez do data
            let idOrder     = $(`#${orderNumber}`).data("idorder");
            let dataOrder   = { "status" : idStatus }
            let data        = { "idOrder" : idOrder, "status" : idStatus }

            editStatusOrder(idOrder, dataOrder)
            saveNewStatusHistoric(data, nameSelectStatus)
        })

        // Dropdown de mudar o numero de items na página
        $(".length-link").off("click");
        $(".length-link").on("click", function() {

            limit = $(this).data("length");
            page = 1;

            $(".orders-lenght-menu").text(limit);
            load();
        });

        // Dropdown de mudar a ordenação dos items
        $(".order-menu").off("click");
        $(".order-menu").on("click", function() {

            order = $(this).data("order");
            page = 1;

            $(".orders-order-menu").text($(this).text());
            load();
        });

        $(".search-button").off("click");
        $(".search-button").on("click", function() {

            search = $(".search-sm input").val();
            load();
        });

        $('.search-sm input').unbind("enterKey");
        $('.search-sm input').bind("enterKey", function(e) {

            search = $(".search-sm input").val();
            load();
        });

        $('.search-sm input').keyup(function(e) {

            if (e.keyCode == 13) {

                $(this).trigger("enterKey");
            }
        });
    }

    function editStatusOrder(idOrder, dataOrder) {

        $.ajax({
            url: "/api/orders/" + idOrder,
            type: "POST",
            data: dataOrder,
            dataType: "json",
            success: function (response) {

                if (!response.success) {

                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });

                    console.error(response);

                    // Não deixar a função executar mais
                    return;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

                console.error(textStatus, errorThrown);

                $.alert({
                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                    theme: "supervan",
                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                });
            }
        });
    }

    function saveNewStatusHistoric(data, nameStatus) {

        $.confirm({

            title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}!',
            theme: "supervan",
            content: '{{ ucfirst($translations["backoffice"]["confirm_change_order_status"]) }}',
            buttons: {

                '{{ ucfirst($translations["backoffice"]["yes"]) }}' : function () {

                    $.ajax({

                        url:        "/api/orders/historic",
                        type:       "POST",
                        data:       data,
                        dataType:   "json",
                        success: function (response) {

                            if (!response.success) {

                                $.alert({
                                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                                    theme: "supervan",
                                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                                });

                                console.error(response);

                                // Não deixar a função executar mais
                                return;
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {

                            console.error(textStatus, errorThrown);

                            $.alert({
                                title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                                theme: "supervan",
                                content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                            });
                        }
                    });

                },
                '{{ ucfirst($translations["backoffice"]["no"]) }}': {}
            }
        });
    }

    function pagination_template(page, pages) {

        // Nav template
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

            nav += '<li class="page-item ' + pageActive + '"><a class="page-link" data-page="' + i + '">' + i +
                '</a></li>';
        }

        if (page < pages) {

            nav += '<li class="page-item"><a class="page-link" data-page="' + (page + 1) + '"><i class="simple-icon-arrow-right"></i></a></li>';
            nav += '<li class="page-item"><a class="page-link" data-page="' + pages + '"><i class="simple-icon-control-end"></i></a></li>';
        }

        return nav;
    }

</script>
@endsection
