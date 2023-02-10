@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-md-12 mb-8">
                    <div class="col-12">
                        <h1 id="title-client">{{ ucfirst($translations["backoffice"]["title_edit_client"]) }}</h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/adm/clients">{{ ucfirst($translations["backoffice"]["clients"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" id="breadcrumb_client" aria-current="page">{{ ucfirst($translations["backoffice"]["title_edit_client"]) }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <form id="clients-form">
                        <div class="contact-form clearfix">
                            <div class="row">
                                <div class="col-md-12 col-lg-8 col-sm-12 col-xs-12 mb-3" id="clintsDivForm">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="mb-0">
                                                <i class="simple-icon-note mr-1"></i>
                                                {{ ucfirst($translations["backoffice"]["form_client_title"]) }}
                                            </h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-group has-float-label">
                                                        <input value="" name="name" type="text"
                                                               autocomplete="off" class="form-control">
                                                        <span>{{ ucfirst($translations["backoffice"]["form_client_fill_name"]) }}</span>
                                                    </label>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label class="form-group has-float-label">
                                                                <input value="" name="email" type="text"
                                                                       autocomplete="off" class="form-control">
                                                                <span>{{ ucfirst($translations["backoffice"]["form_client_fill_email"]) }}</span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label class="form-group has-float-label">
                                                                <input value="" name="phone" type="text"
                                                                       autocomplete="off" class="form-control">
                                                                <span>{{ ucfirst($translations["backoffice"]["form_client_fill_phone"]) }}</span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label class="form-group has-float-label">
                                                                <input value="" name="nif" type="text"
                                                                       autocomplete="off" class="form-control">
                                                                <span>{{ ucfirst($translations["backoffice"]["form_client_fill_nif"]) }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label class="form-group has-float-label">
                                                                <input value="" name="address" type="text"
                                                                       autocomplete="off" class="form-control">
                                                                <span>{{ ucfirst($translations["backoffice"]["form_client_fill_address"]) }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label class="form-group has-float-label">
                                                                <input value="" name="zipCode" type="text"
                                                                       autocomplete="off" class="form-control">
                                                                <span>{{ ucfirst($translations["backoffice"]["form_client_fill_postal_code"]) }}</span>
                                                            </label>

                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label class="form-group has-float-label">
                                                                <input value="" name="city" type="text"
                                                                       autocomplete="off" class="form-control">
                                                                <span>{{ ucfirst($translations["backoffice"]["form_client_fill_city"]) }}</span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label class="form-group has-float-label">
                                                                <input value="" name="dt" type="text"
                                                                       autocomplete="off" class="form-control" disabled>
                                                                <span>{{ ucfirst($translations["backoffice"]["form_client_fill_date"]) }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12  ">
                                                    <label>{{ ucfirst($translations["backoffice"]["form_client_fill_country"]) }}</label>
                                                    <select name="country" class="form-control">

                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <br>
                                    <div class="card" id="clientsNavTabs">
                                        <div class="col-12 pr-3 pl-3">
                                            <ul class="card-header pl-0 pb-0 nav nav-tabs step-anchor tproduto">
                                                <li class="nav-item active pr-2">
                                                    <a id="first-tab" data-toggle="tab" href="#first" role="tab" class="nav-link active pl-0 font-weight-700" aria-controls="first" aria-selected="true">{{ ucfirst($translations["backoffice"]["orders"]) }} <br><small>Lista de encomendas</small></a>
                                                </li>
                                                <li class="nav-item pr-2">
                                                    <a data-toggle="tab" href="#second" role="tab" class="nav-link pl-0 font-weight-700" aria-controls="second" aria-selected="false">{{ ucfirst($translations["backoffice"]["tickets"]) }} <br><small>Lista de tickets</small></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content config-page">
                                                <div class="tab-pane fade active show" id="first" role="tabpanel"
                                                     aria-labelledby="first-tab">
                                                    <h5 class="mb-0 text-muted">
                                                        <i class="simple-icon-basket-loaded"></i>
                                                        {{ ucfirst($translations["backoffice"]["edit_client_table_title_orders"]) }}
                                                    </h5>
                                                    <br>
                                                    <table class="dt-responsive stripe languages-table dataTable no-footer dtr-inline" id="thetable" role="grid" style="width: 0px;">
                                                        <thead class="thead">
                                                            <tr>
                                                                <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-sort="ascending" aria-label="Id: activate to sort column descending">#</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-label="Número: activate to sort column ascending">{{ ucfirst($translations["backoffice"]["edit_client_table_order_fill_number"]) }}</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-label="Estado: activate to sort column ascending">{{ ucfirst($translations["backoffice"]["edit_client_table_order_fill_status"]) }}</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-label="Valor: activate to sort column ascending">{{ ucfirst($translations["backoffice"]["edit_client_table_order_fill_total"]) }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tableOrdersBody">
                                                            <tr>
                                                                <th class="ordersCount" scope="row"></th>
                                                                <td><a href="#" class="btn-link orderNumber"></a></td>
                                                                <td class="orderStatus"></td>
                                                                <td class="orderTotalPrice"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
                                                    <h5 class="mb-0 text-muted">
                                                        <i class="simple-icon-note mr-1"></i>
                                                        {{ ucfirst($translations["backoffice"]["edit_client_table_title_tickets"]) }}
                                                    </h5>
                                                    <br>
                                                    <table class="dt-responsive stripe languages-table dataTable no-footer dtr-inline" id="thetable" role="grid" style="width: 0px;">
                                                        <thead class="thead">
                                                            <tr>
                                                                <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-sort="ascending" aria-label="Número: activate to sort column descending">{{ ucfirst($translations["backoffice"]["edit_client_table_ticket_fill_number"]) }}</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-label="Assunto: activate to sort column ascending">{{ ucfirst($translations["backoffice"]["edit_client_table_ticket_fill_subject"]) }}</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-label="Estado: activate to sort column ascending">{{ ucfirst($translations["backoffice"]["edit_client_table_ticket_fill_status"]) }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tableTicketsBody">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-4 col-sm-12 col-xs-12" id="clientsCardsStatusActions">
                                    <div class="card">
                                        <div class="col-12">
                                            <div class="card-body">
                                                <a href="#" onclick='javascript:window.location.assign("/adm/clients");' class="btn btn-xs btn-outline-secondary m-1">{{ ucfirst($translations["backoffice"]["edit_custom_btn_back"]) }}</a>
                                                <button type="button" data-action="deleteClient"
                                                        class="btn btn-outline-danger mb-1 btn-xs m-1 ml-2">{{ ucfirst($translations["backoffice"]["edit_client_btn_remove"]) }}
                                                </button>
                                                <button type="button" data-action="saveClient"
                                                        class="btn btn-info mb-1 btn-xs m-1 ml-2 btn-save-client">{{ ucfirst($translations["backoffice"]["edit_client_btn_save"]) }}
                                                </button>
                                                <button type="button" data-action="contact"
                                                        class="btn btn-outline-dark btn-xs m-1 ml-2 mb-1" data-toggle="modal"
                                                        data-target="#modalContact">{{ ucfirst($translations["backoffice"]["edit_client_btn_contact"]) }}
                                                </button>
                                                <div class="form-group mt-3">
                                                    <label><span class="dot green mr-2"></span>{{ ucfirst($translations["backoffice"]["edit_client_status"]) }}</label>
                                                    <select name="isactive" class="form-control">
                                                        <option value="1">{{ ucfirst($translations["backoffice"]["client_status_active"]) }}</option>
                                                        <option value="0">{{ ucfirst($translations["backoffice"]["client_status_inactive"]) }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="card">
                                        <div class="col-12">
                                            <div class="card-body">
                                                <h5><i class="simple-icon-basket mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_client_sessions"]) }} </h5>
                                                <hr>
                                                <table class="table table-sm table-borderless">
                                                    <tbody id="tableBodySessions">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="card">
                                        <div class="col-12">
                                            <div class="card-body">
                                                <h5 class="mb-3"><i class="simple-icon-chart mr-2"></i>Opções</h5>
                                                <div class="w-100">
                                                    <div class="form-group mt-4"> <label class="form-group has-float-label"> <input type="text" name="customer_group" class="form-control"> <span>Grupos</span> </label> </div>
                                                </div>
                                            </div>
                                        </div>
								    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ################################# DIV COM MODAL PARA CONTACTO ############################################# -->
        <div class="modal fade" id="modalContact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalContentLabel">{{ ucfirst($translations["backoffice"]["edit_client_form_contact_title"]) }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" style="height: 41vh">
                    <form id="form-contact">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">{{ ucfirst($translations["backoffice"]["edit_client_form_contact_subject"]) }}</label>
                            <input type="text" name="subject" class="form-control" id="recipient-name">
                        </div>
                        <div class="form-group"><label for="message-text" class="col-form-label">{{ ucfirst($translations["backoffice"]["edit_client_form_contact_message"]) }}</label>
                            <textarea class="form-control" name="message" id="message-text"
                                      style="height: 20vh"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ ucfirst($translations["backoffice"]["edit_client_form_contact_btn_close"]) }}</button>
                    <button type="button" class="btn btn-primary send-ticket">{{ ucfirst($translations["backoffice"]["edit_client_form-contact-btn_send"]) }}</button>
                </div>
            </div>
        </div>
        </div>
    </main>
@endsection
@section('scripts')
    <script>
        var editors = [];

        /*----SERELIZE DOS DADOS E REDUCE PARA TRANSFORMAR EM OBJETO
        $("form").on("submit", function (event) {
            event.preventDefault();
            const clientData = $(this).serializeArray()

            const clientObject = clientData.reduce((acc, {name, value}) => {
                return {...acc, [name]: value};
            }, {});
            post(clientObject);
        });
        */

        //Iniciar a pagina
        window.addEventListener("load", function () {
            
            init();
        });
        

        function init() {
            var page = new RegExp('^/adm/clients/.*');

            var path = window.location.pathname.replace(/\/+$/, '');

            var wildcard = null;

            if (page.test(path)) {

                wildcard = path.split("/");
                wildcard = wildcard[wildcard.length - 1];

                listeners();

                // Página para editar produto, vamos buscar as informações do mesmo
                load(wildcard);

            }

        }

        function load(id) {

            $.ajax({
                url: "/api/clients/" + id,
                type: "GET",
                dataType: "json",
                success: function (response) {

                    if (!response.success) {

                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });
                        return;
                    }

                    console.log("data", response)
                    $.each(response.data.client_data, function (key, value) {

                        if (response.data.client_data.text == null) {

                            response.data.client_data.text = "";
                        }

                        switch (key) {
                            case "isactive":
                                $(`[name = "isactive"]`).val(value);
                                console.log("isactve", value)

                                changeStatus(value)
                                break;
                            default:
                                $("[name='" + key + "']").val(value);
                                break;
                        }
                    });
                    sessionsData = response.data.sessions_data
                    console.log("dados da sesao", sessionsData)
                    $("[data-action='saveClient']").attr("data-clientId", id)
                    $("[data-action='deleteClient']").attr("data-clientId", id)
                    $('[name="customer_group"]').tagsinput('refresh');
                    loadOrdersByClient(id);
                    loadTicketsByClient(id)
                    populateSessions(sessionsData)
                    populateCountries(response.data.countries, response.data.client_data.country);
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

        function save(id, data) {
            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_client_save"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/clients/" + id,
                            // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                            // De texto, etc e em alguns servidores pode dar erro
                            type: "POST",
                            data: data,
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

        function remove(id) {
            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_client_remove"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/clients/" + id,
                            // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                            // De texto, etc e em alguns servidores pode dar erro
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
                                // Rederecionar para a página de index das notícias
                                window.location.replace("/adm/clients/");

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

        function populateCountries(countries, selectedCountry) {
            let select = $("[name='country']");
            select.html("");

            $.each(countries, function (key, country) {
                let option = `<option value="` + country.country_code + `">` + country.country_name + `</option>`
                $("[name='country']").append(option)
            })

            select.val(selectedCountry);
        }

        function changeStatus(state) {
            //Remover todas as classes
            $(".dot").removeClass("green red");
            switch (state) {
                case "0":
                    $(".dot").addClass("red");
                    break;
                case  "1":
                    $(".dot").addClass("green");
                    break;
            }

        }

        function loadOrdersByClient(clientId) {

            $.ajax({
                url: "/api/orders/client/" + clientId,
                type: "GET",
                dataType: "json",
                success: function (response) {

                    if (!response.success) {
                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });
                        return;
                    }
                    console.log("RESPONSE", response.data)
                    console.log(response.data)
                    populateOrders(response.data);
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

        function populateOrders(items) {
            $("#tableOrdersBody").html("");

            $.each(items, function (key, item) {
                let templateTable = `
                    <tr>
                        <th class="ordersCount" scope="row">` + item.id + `</th>
                        <td><a href="../orders/show/` + item.id + `" class="btn-link orderNumber">` + item.order_number + `</a></td>
                        <td class="orderStatus">` + item.status + `</td>
                        <td class="orderTotalPrice">` + item.pay_amount + `€</td>
                    </tr>
                `;
                $("#tableOrdersBody").append(templateTable)
            });

            if (items == undefined) {

                $("#tableOrdersBody").append(`
                    <tr>
                        <th>{{ ucfirst($translations["backoffice"]["edit_client_table_orders_empty"]) }}</th>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                `)
            }
        }

        function loadTicketsByClient(clientId) {

            $.ajax({
                url: "/api/tickets/clients/" + clientId,
                type: "GET",
                dataType: "json",
                success: function (response) {

                    if (!response.success) {
                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });
                        return;
                    }
                    console.log("RESPONSE TICKETS", response.data)
                    populateTickets(response.data);

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

        function populateTickets(items) {
            $("#tableTicketsBody").html("");

            $.each(items, function (key, item) {
                let status = ""
                switch(item.status){
                    case "0":
                        status = '{{ ucfirst($translations["backoffice"]["ticket_status_open"]) }}'
                        break
                    case "1":
                        status = '{{ ucfirst($translations["backoffice"]["ticket_status_close"]) }}'
                        break
                    case "2":
                        status = '{{ ucfirst($translations["backoffice"]["ticket_status_urgent"]) }}'
                        break
                }


                let templateTable = `
                    <tr>
                        <th scope="row"><a href="../tickets/` + item.id + `" class="btn-link">` + item.ticket_number + `</a>
                        </th>
                        <td>` + item.subject + `</td>
                        <td>
                            `+ status + `

                        </td>
                    </tr>
                `;
                $("#tableTicketsBody").append(templateTable)
                changeTickets(item.status)
            });

            if (items == undefined) {

                $("#tableTicketsBody").append(`
                    <tr>
                        <th style="width: 40%">{{ ucfirst($translations["backoffice"]["edit_client_table_ticket_empty"]) }}</th>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                `)
            }
        }

        function changeTickets(data) {
            $(".btn-ticket-state").removeClass("btn-outline-success btn-outline-alert");

            switch (data) {
                case "Aberto":
                    $(".btn-ticket-state").addClass("btn-outline-success")
                    break
                case "Fechado":
                    $(".btn-ticket-state").addClass("btn-outline-danger")
                    break


            }
        }

        function populateSessions(items) {
            $("#tableBodySessions").html("");

            $.each(items, function (key, item) {
                let templateTable = `
                    <tr>
                        <td>
                            <span class="font-weight-medium">` + item.agent_os_name + `</span>
                        </td>
                        <td class="text-right">
                            <span class="text-muted">` + item.agent_os_type + `</span>
                        </td>
                        <td>
                            <span class="text-muted" style="word-break: break-all;">` + item.ip + `</span>
                        </td>
                    </tr>
                `;
                $("#tableBodySessions").append(templateTable)
            });

            if (items.length == 0) {

                $("#tableBodySessions").append(`
                    <tr>
                        <td>{{ ucfirst($translations["backoffice"]["edit_client_sessions_empty"]) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                `)
            }
        }

        function getPageData() {

            let data = {};

            // Estamos a utilizar a função serialize para todos os inputs dento de #news-form
            $.each($('#clients-form').serializeArray(), function () {

                data[this.name] = this.value;
            });

            console.log(data)
            return data;
        }

        function getPageDataTicket() {

            let dataTicket = {};

            // Estamos a utilizar a função serialize para todos os inputs dento de #news-form
            $.each($('#form-contact').serializeArray(), function () {

                dataTicket[this.name] = this.value;
            });

            return dataTicket;
        }

        function createTicket(idUser, data) {
            data = {
                "isSupport" : 1,
                "ticket" : data,
                'idUser' : idUser
            }

            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_send_ticket"]) }}'    ,
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/tickets",
                            // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                            // De texto, etc e em alguns servidores pode dar erro
                            type: "POST",
                            data: data,
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
                                location.reload();
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

        function listeners() {

            $(document).on("click", "[data-action='saveClient']", function () {

                let data = getPageData();

                if (data !== false) {
                    save($(this).data("clientid"), data);
                }
            })

            $(document).on("click", "[data-action='deleteClient']", function () {
                
                remove($(this).data("clientid"));
            })

            $(document).on("click", ".send-ticket", function () {

                let dataTicket = getPageDataTicket();

                if (dataTicket !== false) {
                    createTicket($(".btn-save-client").data("clientid"), dataTicket);
                }
            })


        }
    </script>
    