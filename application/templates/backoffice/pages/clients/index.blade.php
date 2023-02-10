@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <h1>{{ ucfirst($translations["backoffice"]["title_list_client"]) }}</h1>
                        <div class="btn-group top-right-button-container">
                            <div class="btn btn-primary btn-lg pl-4 pr-0 check-button">
                                <label class="custom-control custom-checkbox mb-0 d-inline-block">
                                    <input type="checkbox" class="custom-control-input" id="checkAll">
                                    <span class="custom-control-label">&nbsp;</span>
                                </label>
                            </div>
                            <button id="btnGroupDrop1" type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split botaodrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" onclick="deleteMultiple()"> Eliminar selecionados <i class="simple-icon-trash btn-outline-danger"></i></a>
                            </div>
                        </div>

                        <div class="text-zero top-right-button-container">
                            <div class="btn-group">
                                <a href="javascript:void(0)" data-action="newClient" type="button"
                                   class="btn btn-primary top-center-button mr-1 new-item-button"
                                   style="padding: 9px 34px;">{{ ucfirst($translations["backoffice"]["list_product_create"]) }}</a>
                            </div>
                        </div>

                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ ucfirst($translations["backoffice"]["clients"]) }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="mb-2">
                        <div class="collapse d-md-block" id="displayOptions">
                            <div class="d-block d-md-inline-block">
                                <div class="btn-group float-md-left mr-1 mb-1">
                                    <button class="btn btn-outline-dark btn-xs dropdown-toggle clients-order-menu"
                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">{{ ucfirst($translations["backoffice"]["order_by"]) }}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item order-menu" data-order="id">{{ ucfirst($translations["backoffice"]["orderBy_last_inserted"]) }}</a>
                                        <a class="dropdown-item order-menu" data-order="name">{{ ucfirst($translations["backoffice"]["orderBy_name"]) }}</a>
                                        <a class="dropdown-item order-menu" data-order="email">{{ ucfirst($translations["backoffice"]["orderBy_email"]) }}</a>
                                        <a class="dropdown-item order-menu" data-order="isactive">{{ ucfirst($translations["backoffice"]["orderBy_status"]) }}</a>
                                    </div>
                                </div>
                                <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                                    <input placeholder={{ ucfirst($translations["backoffice"]["search"]) }}>
                                </div>
                                <a class="search-button"><i class="simple-icon-magnifier"></i></a>
                            </div>
                            <div class="float-md-right">
                                <span class="text-muted text-small mr-1">{{ ucfirst($translations["backoffice"]["items_per_page"]) }} </span>
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
@endsection
@section('scripts')
    <script>
        let query = parseQueryString();

        var page        = (query.page   !== undefined) ? query.page     : 1;
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

        $('[data-action="newClient"]').on("click", function () {

            let data = {
                draft: 1,
                status: 0
            }
            create(data);
        });

        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        function load() {

            window.history.replaceState("", "", '/adm/clients?' + $.param( { limit: limit, order: order, page: page, search: search } ));

            $.ajax({
                url: "/api/clients?page=" + page + "&search=" + search + "&length=" + limit + "&order=" + order,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (!response.success) {
                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });

                        // Não deixar a função executar mais
                        return;
                    }
                    // Inserir as notícias obtidas pela api na listagem
                    populate(response.data);
                    console.log(response)

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
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });
                }
            });
        }

        function create(data) {

            $.ajax({
                url: "/api/clients",
                type: "POST",
                data: data,
                dataType: "json",
                success: function (response) {
                    if (!response.success) {

                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });

                        // Não deixar a função executar mais
                        return;
                    }

                    // Rederecionar para a noticia "rascunho"
                    window.location.href = "/adm/clients/" + response.data.client_data.id;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });
                }
            })
        }

        function populate(items){
            //Limpar a lista de items
            $(".list").html("");

            $.each(items, function (key, item) {
                let isactive = "";
                let iconUser = "";
                switch(item.isactive){
                    case "0":
                        iconUser = '<i class="simple-icon-user-unfollow iconsListIndex mr-2"></i>'
                        isactive = '<span class="dot red mr-2"></span> {{ ucfirst($translations["backoffice"]["client_status_inactive"]) }}';
                        break;
                    case "1":
                        iconUser = '<i class="simple-icon-user-following iconsListIndex mr-2"></i>'
                        isactive =  '<span class="dot green mr-2"></span> {{ ucfirst($translations["backoffice"]["client_status_active"]) }}';
                        break;
                }

                let template =`
                    <div class="card d-flex flex-row mb-3">
                        <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                            <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                <a class="d-flex linkIcon centerText-max-w-767" href="/adm/clients/` + item.id + `">
                                    ` + iconUser + `
                                </a>
                                <a href="/adm/clients/` + item.id + `" class="w-20 w-sm-100">
                                    <p class="list-item-heading mb-0 truncate centerText-max-w-767">` + item.name + `</p>
                                </a>
                                <p class="mb-0 text-muted text-small w-20 w-sm-100 centerText-max-w-767">` + item.nif + `</p>
                                <p class="mb-0 text-muted text-small w-20 w-sm-100 displayNone-max-w-900 centerText-max-w-767">` + item.phone + `</p>
                                <p class="mb-0 text-muted text-small w-20 w-sm-100 centerText-max-w-767">` + item.email + `</p>
                                <p class="mb-0 text-muted text-small w-10 w-sm-100 centerText-max-w-767">` + isactive + `</p>
                                <div class="w-30 w-sm-100 m-1">
                                    <label class="custom-control custom-checkbox align-self-center float-right ml-2 my-1 mr-3">
                                        <input type="checkbox" name="selected_ids[]" value="` + item.id + `" class="checkbox-allowed custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                    <button class="btn btn-outline-danger mb-1 btn-xs m-1 float-right" name="delte_slide_btn " title="apagar" id="delte_slide_btn" onclick="removeClient(` + item.id + `)"><i class="simple-icon-trash"></i></button>
                                    <a class="btn btn-outline-secondary mb-1 btn-xs m-1 float-right" name="edit_slide_btn" title="editar" id="edit_slide_btn" href="/adm/clients/` + item.id + `"><i class="simple-icon-pencil"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>`;
                $(".list").append(template);
            });
            //Caso a lista esteja vazia
            if(items === undefined || items.length == 0){
                $(".list").html(`
                    <h4>{{ ucfirst($translations["backoffice"]["not_found_male"]) }} {{ $translations["backoffice"]["clients"] }}</h4>
                    <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
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

        function removeClient(id) {
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
                            url: "/api/clients_multiple",
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
         
            console.log(selected);
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
@endsection
