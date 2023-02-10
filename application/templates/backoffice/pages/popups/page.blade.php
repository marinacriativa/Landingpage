@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">                       
                        
                        <h1>{{ ucfirst($translations["backoffice"]["title_popup"]) }}</h1>
                        
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ ucfirst($translations["backoffice"]["title_popup"]) }}                                    
                                </li>
                            </ol>
                        </nav>    
                        
                        <button type="button" href="#" onclick='javascript:window.location.assign("/adm/popups");' class="btn btn-outline-secondary">{{ ucfirst($translations["backoffice"]["edit_custom_btn_back"]) }}</button>
                    </div>

                </div>
            </div>


            <form id="popup-form">
                <div class="row">
                    <div class="col-12 card">
                        <div class="card-body">
                            <div class="w-100">
                                <div class="row">
                                    <div class="form-group mt-4 col-6">
                                        <h5><i class="simple-icon-picture mr-2"></i>Informações do popup</h5>
                                        <hr>
                                        <div class="mt-3">
                                            <label class="form-group has-float-label">
                                                <input name="name" type="text" autocomplete="off"
                                                    class="form-control">
                                                <span>{{ ucfirst($translations["backoffice"]["name"]) }}</span>
                                            </label>
                                        </div>                                              
                                        <div class="mt-3">                                                  
                                            <label class="form-group has-float-label">
                                                <input name="start_date" type="date" autocomplete="off"
                                                    class="form-control">
                                                <span>{{ ucfirst($translations["backoffice"]["edit_news_fill_date_start"]) }}</span>
                                            </label>                                                   
                                        </div>  
                                        <div class="mt-3">                                                  
                                            <label class="form-group has-float-label">
                                                <input name="end_date" type="date" autocomplete="off"
                                                    class="form-control">
                                                <span>{{ ucfirst($translations["backoffice"]["edit_news_fill_date_end"]) }}</span>
                                            </label>                                                   
                                        </div>   
                                        <div class="mt-3">
                                            <label class="form-group has-float-label">
                                                <input name="youtube" placeholder="https://youtu.be/2qiiP1fW5ec" data-fill="youtube" type="text" autocomplete="off" class="form-control" id="youtube">
                                                <span>Vídeo URL</span>
                                            </label>
                                        </div> 
                                        <div class="card-body p-0 mt-3">
                                            <div class="tab-content">
                                                <div class="tab-pane fade active show" id="first" role="tabpanel" aria-labelledby="first-tab"><label class="form-group ckeditor has-float-label"> <textarea id="details" name="details" rows="4" class="c-editor w-100"></textarea> </label> </div>                                          
                                            </div>
                                        </div>                                                                  
                                    </div>
                                    <div class="form-group mt-4 col-6">
                                        <div class="form-group mt-3 col-12">
                                            <label>Ativo</label> 
                                            <div class="custom-switch custom-switch-secondary mb-2 custom-switch-small"> <input class="custom-switch-input" id="featuredSwitch" type="checkbox"> <label rel="tooltip" title="Mostrado na página principal" class="custom-switch-btn" for="featuredSwitch"></label> </div>
                                        </div>
                                        <div class="col-12">
                                            <h5><i class="simple-icon-picture mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_news_images"]) }}</h5>
                                            <hr>
                                            <div class="slim" style="width: 370px;"></div>
                                        </div>
                                    </div>                              
                                </div>                            
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="button" data-action="save" class="btn btn-info default mb-1">{{ ucfirst($translations["backoffice"]["edit_product_btn_save"]) }}</button> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#details' ), {
                removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
            })
            .then( newEditor => {
                editor = newEditor;
            } )
            .catch( error => {
                console.error( error );
            } );

            

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
                
                folder: 'news'
            }
        });
        
        init()

        function init() {

            // Vamos buscar o url pretendido para ver se a página vai editar ou adicionar novo produto
            var page = new RegExp('^/adm/popups/.*');

            // Vamos buscar o link do site
            var path = window.location.pathname.replace(/\/+$/, '');

            // Predefinir a variavel do wildcard
            var wildcard = null;

            if (page.test(path)) {

                // Definir a wildcard como o último valor do URL /valor1/valor2/valor3 ( nest caso vamos buscar o valor 3)
                wildcard = path.split("/");
                wildcard = wildcard[wildcard.length - 1];
                // Definir o tipo de página:
                if (wildcard == "add") {

                    // Página para adicionar produto

                } else {

                    // Página para editar produto, vamos buscar as informações do mesmo
                    load(wildcard);

                    // Adicionar o id ao botão de guardar
                    $('[data-action="save"]').data("id", wildcard);
                }
            }
        }

        function save(id = "", data) {    
            
            data.active = ($("#featuredSwitch").prop('checked') ? "1" : "0");

            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_message_save_news"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/popups_update/" + id,
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

   
        function load(id) {

            // Ativar os listners
            listners();

            $.ajax({
                url: "/api/popups/" + id,
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

                    // Procurar todos os elementos por name="" e meter os dados da api
                    $.each(response.data, function(key, value) {

                        if (response.data.text == null) {

                            response.data.text = "";
                        }

                        switch (key) {

                            case "active":
                                //editors["text"].setElementValue(value);
                                $("#featuredSwitch").prop('checked', (value == "1"));
                     
                                break;
                            
                            case "youtube":
                                
                                // Atualizar o select do youtube
                                $(`[name="youtube"]`).val(value);
                                
                                break;

                            case "details":

                                $(`[name="details"]`).val(editor.setData(value));                                
                                break;

                            case "photo":

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

        // Obter as informações da página
        function getPageData() {

            let data = {};

            console.log('test', $('#popup-form').serializeArray());

            // Estamos a utilizar a função serialize para todos os inputs dento de #popup-form
            $.each($('#popup-form').serializeArray(), function () {

                data[this.name] = this.value;
            });

            // Adicionar a imagem da página
            let slim_data = $(".slim").slim('data')[0];

            if (slim_data.server) {
                
                data.photo = slim_data.server;
            }

            if (data["slim[]"] !== undefined) {

                // Eliminar o atributo slim[] das informações da página
                delete data["slim[]"];
            }

            
            data.details = editor.getData();

            return data;
        }

        function listners() {

            // Ao clicar no botao de guardar
            $("[data-action='save']").on("click", function() {
               
                let data = getPageData();

                if (data !== false) {

                    save($(this).data("id"), data);
                }
            });

            // Ao clicar no botao de eliminar
            $("[data-action='delete']").on("click", function() {

                // Vamos buscar o ID ao botão de guardar
                let id = $("[data-action='save']").data("id");

                remove(id);
            });       

         
        }
       
    </script>
@endsection
