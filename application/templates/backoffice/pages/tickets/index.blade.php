@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <h1>{{ ucfirst($translations["backoffice"]["title_list_tickets"]) }}</h1>
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
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ ucfirst($translations["backoffice"]["tickets"]) }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="mb-2">
{{--                        <a class="btn pt-0 pl-0 d-inline-block d-md-none" data-toggle="collapse" href="#displayOptions"--}}
{{--                            role="button" aria-expanded="true" aria-controls="displayOptions">Opções de visualização <i--}}
{{--                                class="simple-icon-arrow-down align-middle"></i></a>--}}
                        <div class="collapse d-md-block" id="displayOptions">
                            <div class="d-block d-md-inline-block">
                                <div class="btn-group float-md-left mr-1 mb-1">
                                    <button class="btn btn-outline-dark btn-xs dropdown-toggle tickets-order-menu"
                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">{{ ucfirst($translations["backoffice"]["order_by"]) }}</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item order-menu" data-order="create_date">{{ ucfirst($translations["backoffice"]["orderBy_last_inserted"]) }}</a>
                                        <a class="dropdown-item order-menu" data-order="subject">{{ ucfirst($translations["backoffice"]["orderBy_subject"]) }}</a>
                                        <a class="dropdown-item order-menu" data-order="state">Estado</a>
                                    </div>
                                </div>
                                <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                                    <input placeholder="{{ ucfirst($translations["backoffice"]["search"]) }}">
                                </div>
                                <a class="search-button"><i class="simple-icon-magnifier"></i></a>
                            </div>
                            <div class="float-md-right">
                                <span class="text-muted text-small mr-1">{{ ucfirst($translations["backoffice"]["items_per_page"]) }} </span><button
                                    class="btn btn-outline-dark btn-xs dropdown-toggle tickets-lenght-menu" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">10</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@section('scripts')
    <script>
        /*
        Filtros, página, etc deste index
        Os valores que metemos aqui, são os valores iniciais
        */

        let query = parseQueryString();

        var page = (query.page !== undefined) ? query.page : 1;
        var limit = (query.limit !== undefined) ? query.limit : 10;
        var order = (query.order !== undefined) ? query.order : "id";
        var search = (query.search !== undefined) ? query.search : "";

        // Meter o input search com os valores do GET se tiver
        if (query.search !== undefined && query.search.length > 0) {

            $(".search-sm input").val(query.search);
        }

        if (query.limit !== undefined && query.limit.length > 0) {

            $(".tickets-lenght-menu").text(limit);
        }
        //Iniciar a página dos Tickes
        load();

        function load() {
            // Atualizar o url para ter os novos parametros GET
            window.history.replaceState("", "", '/adm/tickets?' + $.param({
                limit: limit,
                order: order,
                page: page,
                search: search
            }));

            $.ajax({
                url: "/api/tickets?page=" + page + "&search=" + search + "&length=" + limit + "&order=" + order,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (!response.success) {

                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });
                        // Não deixar a função executar mais
                        return;
                    }
                    // Inserir as mensagens obtidas pela api na listagem
                    populate(response.data);

                    // Paginação
                    if (response.pagination !== undefined) {

                        let pagination = response.pagination;
                        let page = pagination.page;
                        let pages = Math.ceil(pagination.total / pagination
                            .limit); // Calcular o total de páginas

                        // Adicionar o html dos botões da paginação debaixo da lista
                        $(".pagination").html(pagination_template(page, pages));
                    }
                    // Ativar os listners
                    listners();
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

        function loadClient(idUser) {
            return $.ajax({
                url: "/api/clients/" + idUser,
                type: "GET",
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

                    $(`.ticket_user${response.data.client_data.id}`).html(response.data.client_data.name)

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
        }

        function populate(items) {

            // Limpar a lista de items que temos
            $(".list").html("");

            $.each(items, function(key, item) {
                loadClient(item.user_id)

                let color = "";
                let status = "";
                let icon = "";

                switch (item.status) {
                    case "0":
                        icon = '<i class="mr-1 iconsmind-speach-bubble " style="font-size: 30px"></i>';
                        color = "badge-info"
                        status = "{{ ucfirst($translations["backoffice"]["ticket_status_open"]) }}"
                        break;

                    case "1":
                        icon = '<i class="mr-1 simple-icon-check" style="font-size: 30px"></i>';
                        color = "green"
                        status = "{{ ucfirst($translations["backoffice"]["ticket_status_close"]) }}"
                        break;

                    case "2":
                        icon = '<i class="mr-1 iconsmind-envelope" style="font-size: 30px"></i>';
                        color = "orange"
                        status = "{{ ucfirst($translations["backoffice"]["ticket_status_urgent"]) }}"
                        break;
                }

                let template = `
                    <div id="cardRowContainer">
                        <div class="card test d-flex flex-row mb-3" id="cardRow">
                            <div class="d-flex flex-grow-1 min-width-zero">
                                <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                    <a class="d-flex centerText-max-w-767" href="/adm/tickets/` + item.id +`">
                                        ` + icon + `
                                    </a>
                                    <a class="list-item-heading mb-0 truncate w-25 w-sm-100 "
                                        href="/adm/tickets/` + item.id +`">
                                        ` + item.subject + `
                                    </a>
                                    <p id="ticket_user" class="w-10 w-SM-100 ticket_user`+ item.user_id +` mb-0 text-muted text-small displayNone-max-w-900"></p>
                                    <p id="ticket_subject" class="w-10 w-sm-100 mb-0 text-muted text-small">` + item.ticket_number + `</p>
                                    <div class="w-20 w-xs-100 ">
                                        <button id="` + item.ticket_number +`" data-idTicket ="` + item.id +`"  class="badge badge-pill btn dropdown-toggle bg-primary" data-toggle="dropdown" aria-expanded="false">` + status + `</button>
                                        <div class="dropdown-menu dropdown-menu-status-index" data-ticketNumber="` + item.ticket_number + `" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(97px, 37px, 0px);">
                                            <p class="dropdown-item" data-idstatus="0">{{ ucfirst($translations["backoffice"]["ticket_status_open"]) }}</p>
                                            <p class="dropdown-item" data-idstatus="1">{{ ucfirst($translations["backoffice"]["ticket_status_close"]) }}</p>
                                            <p class="dropdown-item" data-idstatus="2">{{ ucfirst($translations["backoffice"]["ticket_status_urgent"]) }}</p>
                                        </div>
                                    </div>
                                    <p id="ticket_create_date" class="badge badge-light mb-0 text-muted text-small truncate w-10 w-xs-100 displayNone-max-w-1199 displayBlock-max-w-767 centerText-max-w-767"> ` + item.create_date + `</p>
                                    <div class="w-20 w-sm-100 ">
							        	<label class="custom-control custom-checkbox align-self-center float-right ml-2 my-1 mr-3">
						            	    <input type="checkbox" class="custom-control-input">
						                	<span class="custom-control-label"></span>
						             	</label>
                                        <button class="btn btn-outline-danger mb-1 btn-xs m-1 float-right" name="delte_slide_btn " title="apagar" id="delte_slide_btn" onclick="removeTicket(` + item.id + `)"><i class="simple-icon-trash"></i></button>
                                        <a class="btn btn-outline-secondary mb-1 btn-xs m-1 float-right" name="edit_slide_btn" title="editar" id="edit_slide_btn" href="/adm/tickets/` + item.id + `"><i class="simple-icon-pencil"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $(".list").append(template);

                //Caso os items estejam vazios
                if (items === undefined || items.length == 0) {

                    //Na listagem meter uma mensagem a dizer que está vazio
                    $(".list").html(`
                	<h4>{{ ucfirst($translations["backoffice"]["not_found_male"]) }}{{ ucfirst($translations["backoffice"]["tickets"]) }}</h4>
                    <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
                `);
                }
            });

            // Caso o items esteja vazio

            if (items === undefined || items.length == 0) {

                // Na listagem meter uma mensagem a dizer que está vazio
                $(".list").html(`<h4>{{ ucfirst($translations["backoffice"]["not_found_male"]) }}{{ ucfirst($translations["backoffice"]["tickets"]) }}</h4>
                    <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>`);
            }
        }

        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

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
                            url: "/api/tickets_multiple",
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

                                // Redirecionar para a página de index dos tickets
                                window.location.replace("/adm/tickets/");
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

        function removeTicket(id) {
            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_product_remove"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/tickets/" + id,
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

                                // Redirecionar para a página de index dos tickets
                                window.location.replace("/adm/tickets/");
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
            // Dropdown de mudar o numero de items na página
            $(".length-link").off("click");
            $(".length-link").on("click", function() {

                limit = $(this).data("length");
                page = 1;

                $(".tickets-lenght-menu").text(limit);
                load();
            });
            // Dropdown de mudar a ordenação dos items
            $(".order-menu").off("click");
            $(".order-menu").on("click", function() {

                order = $(this).data("order");
                page = 1;

                $(".tickets-order-menu").text($(this).text());
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

            //Ao carregar em qualquer item da dropDown
            $(".dropdown-menu-status-index").on("click", ".dropdown-item", function () {
                //Guarda o texto do item selecionado
                let nameSelectStatus = $(this).text();
                let ticketNumber = $(this).closest(".dropdown-menu-status-index").data("ticketnumber")
                $(`#${ticketNumber}`).html(nameSelectStatus)

                //vai buscar e guarda o id do estado que foi guardado no data-idStatus
                let idStatus = $(this).attr("data-idstatus")

                selectColor(idStatus, ticketNumber)

                //Vai buscar o idOrder atravez do data
                let idTicket = $(`#${ticketNumber}`).data("idticket")

                let dataTicket = {
                    "status" : idStatus
                }
                editStatusTicket(idTicket, dataTicket)
            })
        }

        function selectColor(idStatus, ticketNumber) {
            if(idStatus == 0){
                $(`#${ticketNumber}`).addClass("badge-info").removeClass("orange", "green")
            }else if(idStatus == 1){
                $(`#${ticketNumber}`).addClass("green").removeClass("badge-info", "orange")
            }else if(idStatus == 2){
                $(`#${ticketNumber}`).addClass("orange").removeClass("badge-info", "green")
            }
        }

        function editStatusTicket(idTicket, dataTicket) {
            $.ajax({
                url: "/api/tickets/" + idTicket,
                // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                // De texto, etc e em alguns servidores pode dar erro
                type: "POST",
                data: dataTicket,
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
                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["warning"]) }}',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["ticket_status_changed"]) }}',
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {

                    console.log(textStatus, errorThrown);
                    // @TODO:
                    // Mostar mensagem de erro
                }
            });
        }

        function pagination_template(page, pages) {

            console.log(page);
            console.log(pages);

            // Nav template
            let nav = "";
            let number_of_extra_pagination_button = 4;

            if (page != 1) {

                nav += '<li class="page-item"><a class="page-link" data-page="' + 1 +
                    '"><i class="simple-icon-control-start"></i></a></li>';
                nav += '<li class="page-item"><a class="page-link" data-page="' + (page - 1) +
                    '"><i class="simple-icon-arrow-left"></i></a></li>';
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

                nav += '<li class="page-item"><a class="page-link" data-page="' + (page + 1) +
                    '"><i class="simple-icon-arrow-right"></i></a></li>';
                nav += '<li class="page-item"><a class="page-link" data-page="' + pages +
                    '"><i class="simple-icon-control-end"></i></a></li>';
            }

            return nav;
        }

    </script>
@endsection
