@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-md-12 mb-8">
                    <div class="col-12">
                        <h1 id="title-client">{{ ucfirst($translations["backoffice"]["title_edit_documents"]) }}</h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/adm/documents">{{ ucfirst($translations["backoffice"]["documents"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" id="breadcrumb_client" aria-current="page">{{ ucfirst($translations["backoffice"]["title_edit_documents"]) }}
                                </li>
                            </ol>
                        </nav>
                        <div class="separator mb-5"></div>
                    </div>                       
                    <form id="documents-form" enctype="multipart/form-data">
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
                                                        <input value="" name="name" id="name_page" type="text"
                                                            autocomplete="off" class="form-control" readonly>
                                                        <span>{{ ucfirst($translations["backoffice"]["name_form_documents"]) }}</span>
                                                    </label>                                                    
                                                </div>  
                                                <div class="col-12">
                                                    <input type="file" name="document" id="document">
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
                                                <a href="#" onclick='javascript:window.location.assign("/adm/documents");' class="btn btn-xs btn-outline-secondary m-1">{{ ucfirst($translations["backoffice"]["edit_custom_btn_back"]) }}</a>
                                                <button type="button" data-action="delete" class=" btn btn-outline-danger btn-xs m-1">{{ ucfirst($translations["backoffice"]["edit_client_btn_remove"]) }}</button>
                                                <button type="button" data-action="save" class=" btn btn-outline-info btn-xs m-1 btn-save-client">{{ ucfirst($translations["backoffice"]["edit_client_btn_save"]) }}</button> 
                                                <div id="view_doc">
                                                        
                                                </div>
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
            var page = new RegExp('^/adm/documents/.*');

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
                url: "/api/documents/" + id,
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
                
                    $("[data-action='save']").attr("data-pageId", response.data.id)
                    $("[data-action='delete']").attr("data-pageId", response.data.id) 
                    $("#name_page").val(response.data.name)
                    if(response.data.url != null) {
                        document.querySelector("#view_doc").innerHTML = `                        
                        <a href="`+response.data.url+`" target="_blank"><button type="button"
                                class="btn btn-xs btn-outline-success m-1">{{ ucfirst($translations["backoffice"]["view_document"]) }}
                        </button></a>
                        `; 
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

    function getPageData() {
        let data = {};

        // Estamos a utilizar a função serialize para todos os inputs dento de #news-form
        $.each($('#documents-form').serializeArray(), function () {
            data[this.name] = this.value;
        });     

        console.log(data)
        return data;
    }

    function save(id, data) {
        var fd = new FormData(); 
        fd.append( 'file', $('#document').prop('files')[0] );
        fd.append( 'name', data.name);
        fd.append( 'status', data.status);
        console.log(id, data)
            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_client_save"]) }}',
                buttons: {                    
                    Sim: function () {
                        $.ajax({
                            url: "/api/documents/" + id,
                            // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                            // De texto, etc e em alguns servidores pode dar erro
                            type: "POST",
                            processData: false,
                            contentType: false,
                            data: fd,
                            success: function (response) {
                                if (!response.success) {

                                    // Output do erro
                                    console.error(response);

                                    $.alert({
                                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                        theme: "supervan",
                                        content: response.data,
                                    });

                                    // Não deixar a função executar mais
                                    return;
                                }
                                if(response.data.name != null) {
                                    $('#name_page').val(response.data.name);
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
                            url: "/api/documents/" + id,
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
                                window.location.replace("/adm/documents/");

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

            $(document).on("click", "[data-action='save']", function () {

                let data = getPageData();

                if (data !== false) {
                    save($(this).attr("data-pageId"), data);
                }
            })

            $(document).on("click", "[data-action='delete']", function () {
                
                remove($(this).attr("data-pageId"));
            })

        }

</script>