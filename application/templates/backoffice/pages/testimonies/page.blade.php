@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-md-12 mb-8">
                    <div class="col-12">
                        <h1 id="title-client">{{ ucfirst($translations["backoffice"]["title_edit_testimonies"]) }}</h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/adm/testimonies">{{ ucfirst($translations["backoffice"]["testimonies"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" id="breadcrumb_client" aria-current="page">{{ ucfirst($translations["backoffice"]["title_edit_testimonies"]) }}
                                </li>
                            </ol>
                        </nav>
                        <div class="separator mb-5"></div>
                    </div>                       
                    <form id="testimonies-form" enctype="multipart/form-data">
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
                                                        <input name="name" id="name_testimonial" type="text"
                                                            autocomplete="off" class="form-control">
                                                        <span>{{ ucfirst($translations["backoffice"]["name_form_testimonies"]) }}</span>
                                                    </label>                                                    
                                                </div>  
                                                <div class="col-6">                                                    
                                                    <label class="form-group has-float-label">
                                                        <input name="job" id="job_testimonial" type="text"
                                                            autocomplete="off" class="form-control">
                                                        <span>{{ ucfirst($translations["backoffice"]["name_form_job"]) }}</span>
                                                    </label>                                                    
                                                </div>  
                                                <div class="col-12">                                                    
                                                    <label class="form-group has-float-label">
                                                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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
                                                <a href="#" onclick='javascript:window.location.assign("/adm/testimonies");' class="btn btn-xs btn-outline-secondary m-1">{{ ucfirst($translations["backoffice"]["edit_news_btn_back"]) }}</a>
                                                <button type="button" data-action="deletePage"
                                                        class="btn btn-outline-danger m-1 btn-xs m-1">{{ ucfirst($translations["backoffice"]["edit_client_btn_remove"]) }}
                                                </button>
                                                <button type="button" data-action="savePage"
                                                        class="btn btn-outline-info m-1 btn-xs m-1 btn-save-client">{{ ucfirst($translations["backoffice"]["edit_client_btn_save"]) }}
                                                </button>                                                
                                                <div class="form-group mt-3">
                                                    <label><span class="dot green mr-2"></span> {{ ucfirst($translations["backoffice"]["edit_product_publication_status"]) }}</label> 
                                                    <select name="status" class="form-control">
                                                        <option value="2">{{ ucfirst($translations["backoffice"]["products_status_published"]) }}</option>
                                                        <option value="1">{{ ucfirst($translations["backoffice"]["products_status_private"]) }}</option>
                                                        <option value="0">{{ ucfirst($translations["backoffice"]["products_status_draft"]) }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>  
                                    <div class="card">
                                        <div class="col-12">
                                            <div class="card-body">
                                                <h5><i class="simple-icon-picture mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_news_images"]) }}</h5>
                                                <hr>
                                                <div class="slim"></div>
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
             // Iniciar o plugin de imagens Slim
             $(".slim").slim({
                
                push: true,
                service: '/api/image/slim',
                label: 'Carregar',
                statusUploadSuccess: 'Guardado!',
                
                buttonCancelLabel: 'Cancelar',
                buttonConfirmLabel: 'Confirmar',
                buttonEditLabel: 'Editar',
                buttonDownloadLabel: 'Download',
                buttonUploadLabel: 'Upload',
                
                ratio: '1:1',  // ratio da imagem
                buttonCancelTitle: 'Cancelar',
                buttonConfirmTitle: 'Confirmar',
                buttonEditTitle: 'Editar',
                buttonDownloadTitle: 'Download',
                buttonUploadTitle: 'Upload',
                buttonRotateTitle: 'Rodar',
                buttonRemoveTitle: 'Remover',
                
                meta: {
                    
                    folder: 'testimonies'
                }
            });
            
            init();           
        });

        function init() {
            var page = new RegExp('^/adm/testimonies/.*');

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
                url: "/api/testimonies/" + id,
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

                            case "name":

                                $(`[name="name"]`).val(value);
                                break;

                            case "job":

                                $(`[name="job"]`).val(value);
                                break;

                            case "description":

                                $(`[name="description"]`).val(value);
                                break;
                            
                            case "status":
                                
                                // Atualizar o select do status
                                $(`[name="status"]`).val(value);

                                // Atualizar o botão verde/vermelho/laranja
                                changeState(value);
                                break;

                            case "url":

                                if (value != null && value.length > 0) {
                                    // Carregar imagem do slide
                                    $(".slim").slim('load',  value, { blockPush : true }, function(error, data) { });
                                }
                                break;

                            default:
                                $(`[name="` + key + `"]`).val(value);
                                break;
                        }
                        });
                
                    $("[data-action='savePage']").attr("data-pageId", response.data.id)
                    $("[data-action='deletePage']").attr("data-pageId", response.data.id)                              
                    
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

         // Adicionar a imagem da página
         let slim_data = $(".slim").slim('data')[0];

        if (slim_data.server) {
            
            data.url = slim_data.server;
        }

        if (data["slim[]"] !== undefined) {

            // Eliminar o atributo slim[] das informações da página
            delete data["slim[]"];
        }

        // Estamos a utilizar a função serialize para todos os inputs dento de #news-form
        $.each($('#testimonies-form').serializeArray(), function () {
            data[this.name] = this.value;
        });     

        data.job = $(`[name="job"]`).val();
        

       

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

        data.draft = 0;


        console.log(id, data)
            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_client_save"]) }}',
                buttons: {                    
                    Sim: function () {
                        $.ajax({
                            url: "/api/testimonies/" + id,
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
                            url: "/api/testimonies/" + id,
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
                                window.location.replace("/adm/testimonies/");

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

            $(document).on("click", "[data-action='savePage']", function () {

                let data = getPageData();

                if (data !== false) {
                    save($(this).attr("data-pageId"), data);
                }
            })

            $(document).on("click", "[data-action='deletePage']", function () {
                
                remove($(this).attr("data-pageId"));
            })

        }

</script>