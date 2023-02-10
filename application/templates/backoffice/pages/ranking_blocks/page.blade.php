@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-md-12 mb-8">
                    <div class="col-12">
                        <h1 id="title-client">{{ ucfirst($translations["backoffice"]["title_edit_blocks"]) }}</h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/adm/ranking_blocks">{{ ucfirst($translations["backoffice"]["title_ranking_blocks"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" id="breadcrumb_client" aria-current="page">{{ ucfirst($translations["backoffice"]["title_edit_blocks"]) }}
                                </li>
                            </ol>
                        </nav>
                        <div class="separator mb-5"></div>
                    </div>                       
                    <form id="alerts-form" enctype="multipart/form-data">
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
                                                <div class="col-6">                                                    
                                                    <label class="form-group has-float-label">
                                                        <input name="title" id="title_alert" type="text"
                                                            autocomplete="off" class="form-control">
                                                        <span>{{ ucfirst($translations["backoffice"]["blocks_title"]) }}</span>
                                                    </label>                                                    
                                                </div>  
                                                <div class="col-6">                                                    
                                                    <label class="form-group has-float-label">
                                                        <input name="subtitle" id="link_alert" type="text"
                                                            autocomplete="off" class="form-control">
                                                        <span>{{ ucfirst($translations["backoffice"]["blocks_subtitle"]) }}</span>
                                                    </label>                                                    
                                                </div>  
                                                <div class="col-12">                                                    
                                                    <label class="form-group has-float-label">
                                                        <textarea class="form-control" id="description" name="text" rows="3"></textarea>
                                                        <span>{{ ucfirst($translations["backoffice"]["name_form_description"]) }}</span>
                                                    </label>                                                    
                                                </div>                                                                                                                                         
                                            </div>

                                        </div>
                                    </div>
                                    <br>
                                    <div class="card" id="clientsNavTabs">
                                    </div>  
                                </div>
                                <div class="col-md-12 col-lg-4 col-sm-12 col-xs-12" id="clientsCardsStatusActions">
                                    <div class="card">
                                        <div class="col-12">
                                            <div class="card-body">
                                                <a href="javascript:void(0)" onclick='javascript:window.location.assign("/adm/ranking_blocks");' class="btn btn-xs btn-outline-secondary m-1">{{ ucfirst($translations["backoffice"]["edit_custom_btn_back"]) }}</a>
                                                <button type="button" data-action="saveBlock" class="btn btn-outline-info btn-xs m-1 btn-save-client">{{ ucfirst($translations["backoffice"]["edit_client_btn_save"]) }}
                                                </button>   
  
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
    </div>    
</main>
    
    
    
@endsection

@section('scripts')
<script type="text/javascript" >
    
        //Iniciar a pagina
        window.addEventListener("load", function () {           
            
            init();           
        });

        function init() {
            var page = new RegExp('^/adm/ranking_blocks/.*');

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
                url: "/api/ranking_blocks/" + id,
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
                    
                    $.each(response.data, function(key, value) {

                        if (response.data.text == null) {

                            response.data.text = "";
                        }

                        switch (key) {                                                                         
                                                    

                            default:
                                $(`[name="` + key + `"]`).val(value);
                                break;
                        }
                        });
                
                    $("[data-action='saveBlock']").attr("data-pageId", response.data.id)                          
                    
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

    function getPageData() {
        let data = {};

        // Estamos a utilizar a função serialize para todos os inputs dento de #news-form
        $.each($('#alerts-form').serializeArray(), function () {
            data[this.name] = this.value;
        });             

       

        return data;
    }

    function changeState(state) {
            
        // Remover todas as classes
        $(".dot").removeClass("green red orange");
        switch (state) {

            case "0":
                $(".dot").addClass("red");
                break;
            
            case "1":
                $(".dot").addClass("orange");
                break;
            
            case "2":
                $(".dot").addClass("green");
                break;
        }
    }

    function save(id, data) {


        console.log(id, data)
            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_client_save"]) }}',
                buttons: {                    
                    Sim: function () {
                        $.ajax({
                            url: "/api/ranking_blocks/" + id,
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
                            url: "/api/ranking_blocks/" + id,
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
                                window.location.replace("/adm/ranking_blocks/");

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

        // Função para alterar valores dinamicamentes na página
        function fill() {
            
            let date = new Date('29 Feb 2020');
            // split  based on whitespace, then get except the first element
            // and then join again
            $("[data-fill='date']").text(date.toDateString().split(' ').slice(1).join(' ') + " - ");
        }

        function listeners() {

            $(document).on("click", "[data-action='saveBlock']", function () {    
                      
                let data = getPageData();

                if (data !== false) {
                    save($(this).attr("data-pageId"), data);
                }
            })

            $(document).on("click", "[data-action='deletePage']", function () {
                
                remove($(this).attr("data-pageId"));
            })

            setInterval(function () {

                fill();

            }, 100);

        }

</script>