@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-md-12 mb-8">
                    <div class="col-12">
                        <h1>{{ ucfirst($translations["backoffice"]["title_edit_schedule"]) }}</h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/adm/schedule">{{ ucfirst($translations["backoffice"]["schedule"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($translations["backoffice"]["title_edit_schedule"]) }}</li>
                            </ol>
                        </nav>
                        <div class="btn-group top-right-button-container">
                            <button type="button" href="javascript:void(0)" onclick='javascript:window.location.assign("/adm/schedule");' class="btn btn-outline-secondary">{{ ucfirst($translations["backoffice"]["edit_custom_btn_back"]) }}</button>
                            @php 
                                $countLangs = 0;
                            @endphp
                            @if(count($languages) > 1)
                                @foreach ($languages as $langs)
                                    @if($langs->active == 1)
                                        @php 
                                            $countLangs ++;
                                        @endphp
                                    @endif
                                @endforeach
                            @endif
                            @if($countLangs > 1)
                                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle dropdown-menu-status-index language-selected" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu dropdown-menu-right p-3" style="width: max-content;">
                                    <table class="table table-hover borderless">
                                        <tbody class="languages-list"></tbody>
                                    </table>
                                </div>
                            @endif
                        </div>		
                        <div class="separator mb-5"></div>
                    </div>
                    <form id="news-form">
                        <div class="contact-form clearfix">
                            <div class="row">
                                <div class="col-md-12 col-xl-8 col-sm-12 col-xs-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5><i class="simple-icon-book-open mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_schedule_content"]) }}</h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-group has-float-label">
                                                        <input name="title" type="text" autocomplete="off"
                                                            class="form-control">
                                                        <span>{{ ucfirst($translations["backoffice"]["edit_schedule_fill_name"]) }}</span>
                                                    </label>
                                                </div>
                                                <br>                                                
                                                <div class="col-12">
                                                    <label class="form-group has-float-label">
                                                        <input name="text" type="text" autocomplete="off"
                                                            class="form-control">
                                                        <span>{{ ucfirst($translations["backoffice"]["edit_schedule_fill_text"]) }}</span>
                                                    </label>
                                                </div>
                                                <br>    
                                                <div class="col-12">                                                  
                                                    <label class="form-group has-float-label">
                                                        <input name="date_end" type="date" autocomplete="off"
                                                            class="form-control">
                                                        <span>{{ ucfirst($translations["backoffice"]["edit_news_fill_date_end"]) }}</span>
                                                    </label>                                                   
                                                </div>                                          
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                                                      
                                </div>
                                <div class="col-md-12 col-xl-4 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="col-12">
                                            <div class="card-body">
                                                <button type="button" data-action="delete" class="btn btn-xs btn-outline-danger m-1">{{ ucfirst($translations["backoffice"]["edit_news_btn_remove"]) }}</button>
                                                <button type="button" data-action="save" class="btn btn-xs btn-outline-info m-1">{{ ucfirst($translations["backoffice"]["edit_news_btn_save"]) }}</button>
                                                <div class="form-group mt-3">
                                                    <label>{{ ucfirst($translations["backoffice"]["edit_product_fill_highlight"]) }}</label> 
                                                    <div class="custom-switch custom-switch-secondary mb-2 custom-switch-small"> <input class="custom-switch-input" id="featuredSwitch" type="checkbox"> <label rel="tooltip" title="Destacado na página principal" class="custom-switch-btn" for="featuredSwitch"></label> </div>
                                                </div>
                                                <div class="form-group mt-4"> 
                                                    <label><span class="dot green mr-2"></span> {{ ucfirst($translations["backoffice"]["edit_schedule_status"]) }}</label>
                                                    <select name="status" class="form-control">
                                                        <option value="2">{{ ucfirst($translations["backoffice"]["news_status_published"]) }}</option>
                                                        <option value="1">{{ ucfirst($translations["backoffice"]["news_status_private"]) }}</option>
                                                        <option value="0">{{ ucfirst($translations["backoffice"]["news_status_draft"]) }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <div class="modal modal-fullscreen fade" id="editImageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fullscreen" role="document">
            <div class="modal-content modal-content-fullscreen">
                <div id="tui-image-editor"></div>
            </div>
        </div>
    </div>
    <!-- START SCRIPTS -->
    <!-- START SCRIPTS -->
    <script src="/static/backoffice/javascript/jodit_editor_js/jodit.js"></script>
    <script src="/static/backoffice/javascript/jodit_editor_js/app.js"></script>
    <script src="/static/backoffice/javascript/jodit_editor_js/prism.js"></script>
    <script src="/static/backoffice/javascript/compressor.js"></script>
    <link rel="stylesheet" href="/static/backoffice/css/jodit_editor_css/app.css"/>
    <link rel="stylesheet" href="/static/backoffice/css/jodit_editor_css/jodit.css"/>
    <link rel="stylesheet" href="/static/backoffice/css/jodit_editor_css/prism.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.13.0/Sortable.min.js"></script>
    <link type="text/css" href="//uicdn.toast.com/tui-color-picker/v2.2.6/tui-color-picker.css" rel="stylesheet">
    <link rel="stylesheet" href="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.css">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.3.1/fabric.min.js"></script>
    <script type="text/javascript" src="//uicdn.toast.com/tui.code-snippet/v1.5.0/tui-code-snippet.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>
    <script type="text/javascript" src="//uicdn.toast.com/tui-color-picker/v2.2.6/tui-color-picker.js"></script>
    <script src="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/exif-js"></script>
    

 @endsection

 @section('scripts')

    <script>

        var editors = [];

        let idsImgAdvancedProduct = [];
        let getSelectedIdsImgAdvancedProduct = [];

        let imageEditorInstance = null;
        let imageThatIsBeingEdited = null;
        let type = null;
        /*
         *	Init ckeditor
        */
        var editors = [];
        $('.c-editor').each(function() {

            editors[ $(this).attr("name") ] = new Jodit(this, {

                textIcons:          false,
                iframe:             false,
                toolbarAdaptive:    false,
                height:             400,
                language:           "pt_br",
                defaultMode:        Jodit.MODE_WYSIWYG,

                buttons:            "source,|,paragraph,bold,strikethrough,underline,italic,eraser,|,ul,ol,|,outdent,indent,|,font,fontsize,brush,paragraph,|,image,file,video,table,link,|,align,undo,redo,\n,|,hr,symbol,fullsize",
                
                observer: {
                    timeout: 100
                },
                uploader: {
                    url: '/adm/ckeditor?action=fileUpload',
                },
                commandToHotkeys: {
                    'openreplacedialog': 'ctrl+p'
                },
            });
        });      

        /*
         *	Extract text from ClassicEditor
         */

        function getDataFromTheEditor() {

            return editors["marker"].getData();
        }

        // Precisamos primeiro buscar as linguas que a loja suporta e só depois carregar a noticia

        // Iniciar o objecto das linguas que a loja tem
        var translations = {};

        $.ajax({
            url: "/api/translations/",
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

                    // Deu erro, nao vamos executar mais
                    return;
                }

                translations = response.data;

                // Iniciar a página de noticia
                init();
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

        function init() {

            // Vamos buscar o url pretendido para ver se a página vai editar ou adicionar novo produto
            var page = new RegExp('^/adm/schedule/.*');

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

            // Temos de tirar o estado de rascunho se existir
            data.draft = 0;            
            data.featured = ($("#featuredSwitch").prop('checked') ? "1" : "0");

            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_message_save_news"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/schedule/" + id,
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
                url: "/api/schedule/" + id,
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
                            
                            case "status":
                                
                                // Atualizar o select do status
                                $(`[name="status"]`).val(value);

                                // Atualizar o botão verde/vermelho/laranja
                                changeState(value);
                                break;

                            case "featured":
                                $("#featuredSwitch").prop('checked', (value == "1"));
                                break;    
                                

                            default:
                                $(`[name="` + key + `"]`).val(value);
                                break;
                        }
                    });

                    // Carregar as linguas
                    languages(response.data.related, {lang: response.data.lang, status: response.data.status});

                    // Refresh do plugin das tags
                    $('[name="keywords"]').tagsinput('refresh');

                    // Iniciar galeria de imagens
                    dropzoneGallery(response.data.id, response.data.images);

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

        // Nesta função vamos dar loop nas línguas todas e ver as que a notícia já tem
        function languages(related, selected_language) {

            // Separamos para depois adicionar por ordem de ativo ou não
            let active      = [];
            let non_active  = [];

            console.log(selected_language)

            $.each(translations, function(key, language) {

                if (language.code === selected_language.lang) {

                    language.item_id    = null;
                    language.status     = selected_language.status;

                    active.push(language);

                    delete translations[key];

                } else {

                    // Dar loop em todas as noticias que a noticia suporta
                    $.each(related, function(sub_key, active_language) {

                        if (active_language.lang == language.code) {

                            // Guardar o id da noticia com a lingua x
                            language.item_id = active_language.id;
                            language.status  = active_language.status;

                            active.push(language);

                            delete translations[key];
                        }
                    })
                }
            });

            console.log(translations);

            // Estas foram as linguas que restaram do codigo em cima
            $.each(translations, function(key, language) {

                if (language !== undefined) {

                    non_active.push(language);
                }
            });


            // Adicionar primeiro as linguas ativas
            $.each(active, function(key, lang) {

                let button = "";

                if (lang.item_id == null) {

                    // Se o lang.item_id for nulo, quer dizer que é a noticia que temos atualmente carregada
                    button = `<a href="javascript:void(0)" style="min-width: 80px" class="btn btn-success btn-xs float-right">{{ ucfirst($translations["backoffice"]["language_btn_current"]) }}</a>`;
                    $(".language-selected").append(`
                        ` + lang.name + `
                    `);
                } else {

                    button = `<a href="/adm/schedule/` + lang.item_id + `" style="min-width: 80px" class="btn btn-info btn-xs float-right">{{ ucfirst($translations["backoffice"]["language_btn_see"]) }}</a>`;
                }

                let status = "";

                switch (lang.status) {

                    case "0":
                        status = '<span class="sub-dot ml-2 red"></span>';
                        break;
                    case "1":
                        status = '<span class="sub-dot ml-2 orange"></span>';
                        break;
                    case "2":
                        status = '<span class="sub-dot ml-2 green"></span>';
                        break;
                }

                $(".languages-list").append(`
                <tr>
                    <td><span>` + lang.name + `</span> ` + status + `</td>
                    <td></td>
                    <td>` + button + `</td>
                </tr>`);

            });

            // Adicionar as linguas nao ativas
            $.each(non_active, function(key, lang) {

                $(".languages-list").append(`
                <tr>
                    <td class="text-muted">` + lang.name + `</td>
                    <td></td>
                    <td><a href="javascript:void(0)" data-lang="` + lang.code + `" data-lang-name="` + lang.name + `" style="min-width: 80px" class="btn btn-light btn-xs float-right create-other-language-button">{{ ucfirst($translations["backoffice"]["language_btn_create"]) }}</a></td>
                </tr>`);
            });
        }

        function getPageData() {

            let data = {};

            // Estamos a utilizar a função serialize para todos os inputs dento de #news-form
            $.each($('#news-form').serializeArray(), function () {

                data[this.name] = this.value;
            });

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

            // Ao clicar no botao de criar nova lingua
            $("body").on("click", ".create-other-language-button", function() {

                let lang        = $(this).data("lang");
                let lang_name   = $(this).data("lang-name");

                createAnotherLanguage(lang, lang_name)
            });           

            // Ao mudar o estado do produto
            $("[name='status']").on("change", function () {
                
                changeState(this.value);
            });

            // Ao escrever o título, mudar a slug
            $("[name='title']").on("input", function () {

                $("[name='slug']").val(slug($(this).val()));
                
                // Introduzir as informações novas no bloco SEO
                fill();
            });


            // A cada 100ms vamos executar a função fill
            setInterval(function () {

                fill();

            }, 100);
        }


        function createAnotherLanguage(lang, name) {

            let id = $("[data-action='save']").data("id");

            $.confirm({
                title: name,
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_create_product_another_language"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/schedule/",
                            // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                            // De texto, etc e em alguns servidores pode dar erro
                            type: "POST",
                            data: {lang: lang, id: id, draft: 0, status: 0},
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

                                // Rederecionar para a página da nova noticia
                                window.location.replace("/adm/schedule/" + response.data.id);
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

        // Eliminar a notícia
        function remove(id) {

            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_message_news_remove"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/schedule/" + id,
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
                                window.location.replace("/adm/schedule/");
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

        // Se o item estiver publicado metemos bolinha verde
        // Se tiver privado metemos bolinha laranja
        // Se tiver desativado metemos vermelho
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

        // Função para alterar valores dinamicamentes na página
        function fill() {

            $("[data-fill='name']").text($("[name='title']").val());
            $("[data-fill='details']").html($("[name='text']").val().replace(/(<([^>]+)>)/gi, ""));

        }      
    

    </script>
@endsection
