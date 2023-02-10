@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-md-12 mb-8">
                    <div class="col-12 divTitleTicket">
                        <h1></h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">Loja</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/adm/tickets">Tickets</a>
                                </li>
                            </ol>
                        </nav>
                        <div class="separator mb-5"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xl-8 col-sm-12 col-xs-12 mb-3">
                            <div class="card">
                                <div class="col-12">
                                    <div class="card-body">
                                            <h5><i class="simple-icon-bubbles mr-2"></i>{{ ucfirst($translations["backoffice"]["title_tickets_messages"]) }} </h5>
                                        <hr>
                                        <div class="messages_content">
                                        </div>

                                        <div class="input-group">
                                            <input class="flex-grow-1 input-chat inputMessage" type="text" placeholder="Digite a mensagem">
                                            <div class="btn-chat input-group-append">
                                                <button type="button" class="btn btn-outline-primary icon-button large btn-clip"><i
                                                            class="simple-icon-paper-clip"></i></button>
                                                <button type="button" data-action="sendMessage" class="btn btn-primary icon-button large "><i
                                                            class="simple-icon-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-4 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="col-12">
                                    <div class="card-body">
                                        <a href="#" onclick='javascript:window.location.assign("/adm/tickets");' class="btn btn-xs btn-outline-secondary m-1">{{ ucfirst($translations["backoffice"]["edit_news_btn_back"]) }}</a>
                                        <button type="button" data-action="delete" class="btn btn-outline-danger btn-xs m-1">
                                            {{ ucfirst($translations["backoffice"]["tickets_btn_remove"]) }}
                                        </button>
                                        <div class="form-group mt-4">
                                            <label>{{ ucfirst($translations["backoffice"]["tickets_status"]) }}</label>
                                            <select name="statusTicket" class="form-control selectStatus">
                                                <option value="0">{{ ucfirst($translations["backoffice"]["ticket_status_open"]) }}</option>
                                                <option value="1">{{ ucfirst($translations["backoffice"]["ticket_status_close"]) }}</option>
                                                <option value="2">{{ ucfirst($translations["backoffice"]["ticket_status_urgent"]) }}</option>
                                            </select>
                                        </div>
                                        <!-- Opcao de mostrar dados do cliente -->
{{--                                        <h5><i class="simple-icon-user mr-2"></i>Dados Cliente</h5>--}}
{{--                                        <div class="col-12 info-client">--}}

{{--                                        </div>--}}
{{--                                        <a class="btn btn-info btn-info-client default mb-1">Dados--}}
{{--                                            do cliente--}}
{{--                                        </a>--}}
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="col-12">
                                    <div class="card-body">
                                        <h5><i class="simple-icon-user mr-2"></i>{{ ucfirst($translations["backoffice"]["tickets_info_client"]) }}</h5>
                                        <div class="col-12 info-client">

                                        </div>
                                        <a class="btn btn-outline-info btn-info-client btn-xs mb-1">{{ ucfirst($translations["backoffice"]["tickets_btn_info_client"]) }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        init();

        async function init() {
            // Vamos buscar o url pretendido para ver se a página vai editar ou adicionar novo produto
            var page = new RegExp('^/adm/orders/.*');

            // Vamos buscar o link do site
            var path = window.location.pathname.replace(/\/+$/, '');

            // Predefinir a variavel do wildcard
            var wildcard = null;

            // Definir a wildcard como o último valor do URL /valor1/valor2/valor3 ( nest caso vamos buscar o valor 3)
            wildcard = path.split("/");
            wildcard = wildcard[wildcard.length - 1];

            $('[data-action="sendMessage"]').attr("data-idticket", wildcard)

            listeners();

            const {data: ticketData} = await loadTicket(wildcard)
            const {data: userData} = await loadUserTicket(ticketData.user_id)
            console.log(userData)
            populateInfoTicket(ticketData)
            isClose(ticketData.status)
            const {data: messageData} = await loadMessages(wildcard)
            populateMessages(messageData, ticketData.isSupport, ticketData.user_id, userData.client_data.name)
            populateInfoClient(userData.client_data)

        }

        function loadMessages(idTicket) {
            return $.ajax({
                url: "/api/tickets/messages/" + idTicket,
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

        function populateMessages(items, isSupport, idUser, name) {
            console.log("Popular mensagens: ", isSupport)

            $(".messages_content").html("")

            $.each(items, function (key, item) {
                let templateSender = `
	            <div class="card d-inline-block mb-3 float-left mr-2 w-90">
	                <div class="position-absolute pt-1 pr-2 r-0">
	                    <span class="text-extra-small text-muted">` + item.date + `</span>
	                </div>
	                <div class="d-flex flex-row">
	                    <div class="d-flex flex-grow-1 min-width-zero">
	                        <div class="m-2 pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
	                            <div class="min-width-zero">
	                                <p class="mb-0 truncate list-item-heading">` + name + `</p>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <hr class="mb-0">
	                <div class="card-body">
	                    <div class="chat-text-left">
	                        <p class="mb-0 text-semi-muted">
	                            ` + item.message + `
	                        </p>
	                    </div>
	                </div>
                    <button class="float-right" type="button" data-action="deleteMessage" data-idTicket="` + item.id + `"><i class="btn btn-xs btn-danger simple-icon-trash list-item-heading"></i></button>
	            </div>
	            <div class="clearfix"></div>
	        `
                let templateMe = `
	            <div class="card d-inline-block mb-3 float-right  mr-2 w-90">
	                <div class="position-absolute pt-1 pr-2 r-0">
	                    <span class="text-extra-small text-muted">` + item.date + `</span>
	                </div>
	                <div class="d-flex flex-row">
	                    <div class="d-flex flex-grow-1 min-width-zero">
	                        <div class="m-2 pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
	                            <div class="min-width-zero">
	                                <p class="mb-0 truncate list-item-heading">{{ ucfirst($translations["backoffice"]["support"]) }}</p>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <hr class="mb-0">
	                <div class="card-body">
	                    <div class="chat-text-left">
	                        <p class="mb-0 text-semi-muted">
	                            ` + item.message + `
	                        </p>
	                    </div>
	                </div>
                    <button class="float-right" type="button" data-action="deleteMessage" data-idTicket="` + item.id + `"><i class="btn btn-xs btn-danger simple-icon-trash list-item-heading"></i></button>
	            </div>
	            <div class="clearfix"></div>
	        `
                if (item.id_sender === idUser && isSupport == 0) {
                    $(".messages_content").append(templateSender);
                } else {
                    $(".messages_content").append(templateMe);
                }
            })

            //Caso os items estejam vazios
            if (items === undefined || items.length == 0) {

                //Na listagem meter uma mensagem a dizer que está vazio
                $(".list").html(`
                	<h4>{{ ucfirst($translations["backoffice"]["empty_conversation"]) }}</h4>
                    <p>{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
                `);
            }
        }

        function loadTicket(idTicket) {
            return $.ajax({
                url: "/api/tickets/" + idTicket,
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
        function isClose(status) {
            if(status == 1){
                $(".inputMessage").prop("disabled", true)
            }else{
                $(".inputMessage").prop("disabled", false)
            }
        }

        function populateInfoTicket(item, name) {
            $(".divTitleTicket h1").html(item.ticket_number);

            console.log(item.user_id)

            $(".btn-info-client").attr("href", "/adm/clients/" + item.user_id)

            $(`[name="statusTicket"]`).val(item.status);
        }

        function loadUserTicket(idUser) {
            return $.ajax({
                url: "/api/users/" + idUser,
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
                    console.log("cliente", response.data)
                    return response.data;

                    // $(".div-name").append(`<p class="list-item-heading mb-1 truncate">` + response.data.name + `</p>`)

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
        
        function populateInfoClient(dataClient) {
            console.log("dados do ciente", dataClient);
            $(".info-client").html("")
            let template3 = `
            <br>
            <ul class="list-group">
                <li class="list-group-item text-center">{{ ucfirst($translations["backoffice"]["ticket_client_name"]) }} <span class="text-muted">`+ dataClient.name +`</span></li>
                <li class="list-group-item text-center">{{ ucfirst($translations["backoffice"]["ticket_client_email"]) }} <span class="text-muted">`+ dataClient.email +`</span></li>
                <li class="list-group-item text-center ">{{ ucfirst($translations["backoffice"]["ticket_client_phone"]) }} <span class="text-muted">`+ dataClient.phone +`</span></li>
            </ul>
            <br>
            `

            $(".info-client").append(template3)

        }

        function formatDateToDatabese(){
            const today = new Date();

            const day = String(today.getDate()).padStart(2, '0');
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const year = today.getFullYear();

            const hours = String(today.getHours()).padStart(2, '0');
            const minutes = String(today.getMinutes()).padStart(2, '0');
            const seconds = String(today.getSeconds()).padStart(2, '0');

            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }

        function listeners() {
            $('[data-action="sendMessage"]').on("click", async function () {

                let date = formatDateToDatabese()
                let dataMessage = getMessage();
                dataMessage.date = date;
                console.log(dataMessage)
                populateSentMessage(dataMessage)
                saveMessage(dataMessage)
            });

            $('[data-action="delete"]').on("click", function () {
                let idTicket = $('[data-action="sendMessage"]').data("idticket")
                removeTicket(idTicket)

            });

            $("body").on("click", '[data-action="deleteMessage"]', function () {
                removeMessage(this);
            });

            $(".selectStatus").on("change", function () {
                let idTicket = $('[data-action="sendMessage"]').data("idticket")
                let data = {
                    "status" : $(this).val(),
                }
                editStatus(idTicket, data)
            });
        }

        function editStatus(idTicket, data) {
            $.ajax({
                url: "/api/tickets/" + idTicket,
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

        function removeTicket(id) {
            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}!',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_message_remove_ticket"]) }}',
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

                                    return;
                                }
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

        function getMessage() {
            //Cria um objeto com os valores dos inputs
            let dataMessage = {}

            let message = $(".inputMessage").val();
            if (message.length > 0) {
                dataMessage = {
                    'id_ticket': $('[data-action="sendMessage"]').data('idticket'),
                    'id_sender': "6",
                    'message': message,
                }
                return dataMessage;
            }
            console.log("ERRO: dados do desconto em branco")

        }

        function saveMessage(dataMessage) {

            $.ajax({
                url: "/api/tickets/messages",
                type: "POST",
                data: dataMessage,
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
                    console.log("Resposta", response)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });
                }
            });

        }

        function populateSentMessage(item) {
            let templateMe = `
	            <div class="card d-inline-block mb-3 float-right w-90 mr-2">
	                <div class="position-absolute pt-1 pr-2 r-0">
	                    <span class="text-extra-small text-muted">` + item.date + `</span>
	                </div>
	                <div class="d-flex flex-row">
	                    <div class="d-flex flex-grow-1 min-width-zero">
	                        <div class="m-2 pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
	                            <div class="min-width-zero">
	                                <p class="mb-0 truncate list-item-heading">{{ ucfirst($translations["backoffice"]["support"]) }}</p>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <hr class="mb-0">
	                <div class="card-body">
	                    <div class="chat-text-left">
	                        <p class="mb-0 text-semi-muted">
	                            ` + item.message + `
	                        </p>
	                    </div>
	                </div>
                    <button class="float-right" type="button" data-action="deleteMessage" data-idTicket="` + item.id + `"><i class="btn btn-xs btn-danger simple-icon-trash list-item-heading"></i></button>
	            </div>
	            <div class="clearfix"></div>
	        `
            $(".messages_content").append(templateMe);
            $(".inputMessage").val("")
        }

        function removeMessage(object) {

            let id = $(object).data("idticket");

            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}!',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_remove_message"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/tickets/message/" + id,
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

                                    return;
                                }

                                $(object).closest(".card").remove();

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
    </script>
@endsection