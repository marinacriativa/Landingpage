@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-md-12 mb-8">
                    <div class="col-12">
                        <h1>{{ ucfirst($translations["backoffice"]["edit_job"]) }}</h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/adm/jobs">{{ ucfirst($translations["backoffice"]["jobs"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($translations["backoffice"]["edit_job"]) }}</li>
                            </ol>
                        </nav>
                        <div class="btn-group top-right-button-container">
                            <button type="button" href="javascript:void(0)" onclick='javascript:window.location.assign("/adm/jobs");' class="btn btn-outline-secondary">{{ ucfirst($translations["backoffice"]["edit_custom_btn_back"]) }}</button>
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
                    <form id="jobs-form">
                        <div class="contact-form clearfix">
                            <div class="row">
                                <div class="col-md-12 col-xl-8 col-sm-12 col-xs-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5><i class="simple-icon-book-open mr-2"></i>Conte??do do emprego</h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-group has-float-label">
                                                        <input id="name" name="name" type="text" autocomplete="off"
                                                            class="form-control">
                                                        <span>Nome/Descritivo do emprego</span>
                                                    </label>
                                                </div>
                                                <br>
                                                <div class="col-3">
                                                    <label class="form-group has-float-label">
                                                        <input id="price" name="price" type="text" autocomplete="off"
                                                            class="form-control">
                                                        <span>Sal??rio</span>
                                                    </label>
                                                </div>
                                                <br>
                                                <div class="col-3">                                                 
                                                    <label class="form-group has-float-label">
                                                        <select id="period" name="period" class="form-control">
                                                            <option value="Part Time">Part Time</option>
                                                            <option value="Full Time">Full Time</option>
                                                        </select>
                                                        <span>Per??odo</span>
                                                    </label>
                                                </div>
                                                <br>
                                                <div class="col-3">
                                                    <label class="form-group has-float-label">
                                                        <input id="urgency" name="urgency" type="text" autocomplete="off"
                                                            class="form-control">
                                                        <span>Urg??ncia</span>
                                                    </label>
                                                </div>
                                                <br>
                                                <div class="col-3">
                                                    <label class="form-group has-float-label">
                                                        <input id="experience" name="experience" type="text" autocomplete="off"
                                                            class="form-control">
                                                        <span>Experi??ncia</span>
                                                    </label>
                                                </div>
                                                <br>
                                                <div class="col-6">
                                                    <label class="form-group has-float-label">
                                                        <input id="notes" name="notes" type="text" autocomplete="off"
                                                            class="form-control">
                                                        <span>Notas</span>
                                                    </label>
                                                </div>
                                                <br>
                                                <div class="col-6">
                                                    <label class="form-group has-float-label">
                                                        <input id="location" name="location" type="text" autocomplete="off"
                                                            class="form-control">
                                                        <span>Local</span>
                                                    </label>
                                                </div>
                                                <br>
                                                <div class="col-12">
                                                    <label class="form-group ckeditor has-float-label">
                                                        <textarea name="description" rows="20" class="c-editor w-100"></textarea>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                   
                                    <br>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="w-100">
                                                <h5><i class="simple-icon-organization mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_news_seo_tags"]) }}</h5>
                                                <hr>
                                                <div class="form-group mt-4">
                                                    <label class="form-group has-float-label">
                                                        <input name="slug" type="text" autocomplete="off" class="form-control">
                                                        <span>{{ ucfirst($translations["backoffice"]["edit_news_fill_url_friendly"]) }}</span>
                                                    </label>
                                                </div>
                                                <div class="form-group mt-4">
                                                    <label class="form-group has-float-label">
                                                        <input type="text" name="keywords" class="form-control">
                                                            <span>{{ ucfirst($translations["backoffice"]["edit_news_fill_tags"]) }}</span>
                                                    </label>
                                                </div>
                                                <div class="row mt-2">
                                                    <div id="seo_wrap" class="widget meta-boxes mt-3 col-12">
                                                        <div class="widget-body">
                                                            <div class="seo-preview">
                                                                <span class="page-title-seo" data-fill="name"></span>
                                                                <div class="page-url-seo ws-nm">
                                                                    <p>{{ URL }}{{ $selected_language->code }}/jobs/<span data-fill="slug"></span></p>
                                                                </div>
                                                                <div class="ws-nm">
                                                                    <span style="color: #70757a;" data-fill="date"></span>
                                                                    <span data-fill="details" class="page-description-seo"></span>
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                <button type="button" data-action="delete" class="btn btn-xs btn-outline-danger m-1">{{ ucfirst($translations["backoffice"]["edit_news_btn_remove"]) }}</button>
                                                <a class="btn btn-outline-success btn-xs" href="/api/categories_jobs/cron" target="_blank">Atualizar Filtros</a> 
                                                <button type="button" data-action="save" class="btn btn-xs btn-outline-info m-1">{{ ucfirst($translations["backoffice"]["edit_news_btn_save"]) }}</button>
                                                <div class="form-group mt-3">
                                                    <label>{{ ucfirst($translations["backoffice"]["edit_product_fill_highlight"]) }}</label> 
                                                    <div class="custom-switch custom-switch-secondary mb-2 custom-switch-small"> <input class="custom-switch-input" id="featuredSwitch" type="checkbox"> <label rel="tooltip" title="Destacado na p??gina principal" class="custom-switch-btn" for="featuredSwitch"></label> </div>
                                                </div>
                                                <div class="form-group mt-4"> 
                                                    <label><span class="dot green mr-2"></span> Estado</label>
                                                    <select name="status" class="form-control">
                                                        <option value="1">P??blico</option>
                                                        <option value="0">Privado</option>
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
                                    <br>    
                                    <div class="card">
                                        <div class="col-12">
                                            <div class="card-body">
                                                <h5><i class="simple-icon-list mr-2"></i>{{ ucfirst($translations["backoffice"]["categories"]) }}</h5>
                                                <hr>
                                                <div id="categories"></div>
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

        // Iniciar o plugin de imagens Slim
        $(".slim").slim({
			
            push: true,
            service: '/api/image/slim',
            label: 'Carregar',
            statusUploadSuccess: 'Guardado!',
            
            ratio: '2:1',  // ratio da imagem
            buttonCancelLabel: 'Cancelar',
            buttonConfirmLabel: 'Confirmar',
            buttonEditLabel: 'Editar',
            buttonDownloadLabel: 'Download',
            buttonUploadLabel: 'Upload',
            
            buttonCancelTitle: 'Cancelar',
            buttonConfirmTitle: 'Confirmar',
            buttonEditTitle: 'Editar',
            buttonDownloadTitle: 'Download',
            buttonUploadTitle: 'Upload',
            buttonRotateTitle: 'Rodar',
            buttonRemoveTitle: 'Remover',
            
            meta: {
                
                folder: 'jobs'
            }
        });

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

        // Precisamos primeiro buscar as linguas que a loja suporta e s?? depois carregar a noticia

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

                // Iniciar a p??gina de noticia
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

            // Vamos buscar o url pretendido para ver se a p??gina vai editar ou adicionar novo produto
            var page = new RegExp('^/adm/jobs/.*');

            // Vamos buscar o link do site
            var path = window.location.pathname.replace(/\/+$/, '');

            // Predefinir a variavel do wildcard
            var wildcard = null;

            if (page.test(path)) {

                // Definir a wildcard como o ??ltimo valor do URL /valor1/valor2/valor3 ( nest caso vamos buscar o valor 3)
                wildcard = path.split("/");
                wildcard = wildcard[wildcard.length - 1];
                // Definir o tipo de p??gina:
                if (wildcard == "add") {

                    // P??gina para adicionar produto

                } else {

                    // P??gina para editar produto, vamos buscar as informa????es do mesmo
                    load(wildcard);

                    // Adicionar o id ao bot??o de guardar
                    $('[data-action="save"]').data("id", wildcard);
                }
            }
        }

        function save(id = "", data) {

            // Temos de tirar o estado de rascunho se existir
            data.draft = 0;            
            data.categories = [];
            data.featured = ($("#featuredSwitch").prop('checked') ? "1" : "0");

            // Obter as categorias
            $("#categories input:checked").each(function (key, item) {
                data.categories.push($(item).parent().data("id"));
            });

            data.categories = data.categories.join(",");

            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_message_save_news"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/jobs/" + id,
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

                                    // N??o deixar a fun????o executar mais
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
                    N??o: {}
                }
            });
        }

        function load(id) {

            // Ativar os listners
            listners();

            $.ajax({
                url: "/api/jobs/" + id,
                type: "GET",
                dataType: "json",
                success: function(response) {

                    if (!response.success) {

                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });

                        // N??o deixar a fun????o executar mais
                        return;
                    }

                    // Procurar todos os elementos por name="" e meter os dados da api
                    $.each(response.data, function(key, value) {

                        if (response.data.description == null) {

                            response.data.description = "";
                        }

                        switch (key) {

                            case "description":
                                editors["description"].setElementValue(value);
                                break;
                            
                            case "status":
                                
                                // Atualizar o select do status
                                $(`[name="status"]`).val(value);

                                // Atualizar o bot??o verde/vermelho/laranja
                                changeState(value);
                                break;

                            case "featured":
                                $("#featuredSwitch").prop('checked', (value == "1"));
                                break;    
                                
                            case "photo_path":
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

                    // Carregar as linguas
                    languages(response.data.related, {lang: response.data.lang, status: response.data.status});

                    // Refresh do plugin das tags
                    $('[name="keywords"]').tagsinput('refresh');                   

                    categoriesLoad(response.data.lang, response.data.categories);

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

        //#################################### Categorias ####################################################
        function categoriesLoad(lang, selected_categories) {
            $.ajax({
                url: "/api/categories_jobs/",
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
                        // N??o deixar a fun????o executar mais
                        return;
                    }

                    
                    // Retirar categorias nao desejadas, outras linguas e categorias root
                    response.data = response.data.filter(function (category) {
                        if (category.lang == lang && category.root !== "1" && category.parent !== null) {
                            return true;
                        }
                        return false;
                    });
                    // Vamos transformar a lista de categories numa lista estruturada ( tipo um arvore )
                   
                    let categories = listToTree(response.data);                    
                    
                    $("#categories").html(populateCategories(categories, lang, selected_categories));
                    categoriesListners();
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

        function populateCategories(categories, lang, selected_categories) {
         
            let template = $("<ul class='p-0 cat-element'></ul>");
            if (selected_categories == null) {
                selected_categories = "";
            }
            let selected = selected_categories.split(",");
            $.each(categories, function (key, category) {
                let isFather = (category.root == "1") ? `<span>` + category.name + `</span>` : `<input  ` + (selected.includes(category.id) ? "checked" : "") + ` class="mt-2 mr-2 ml-2" type="checkbox">` + category.name + ``
                let category_template = $(`
                <li class='` + ((category.root == "1") ? "mb-3" : "pl-4") + `' style="min-width: 100%">
                    <div data-id="` + category.id + `" class='category-block'>
                        ` + isFather + `
                    </div>
                </li>
            `);
                if (category.children.length > 0) {
                    // Temos filhos na categoria, vamos chamar a fun????o para adicionar o html
                    // Isto chama-se uma fun????o recursiva ou algo parecido, idk, n??o andei na uni :)
                    category_template.append(populateCategories(category.children, lang, selected_categories));
                }
                template.append(category_template[0].outerHTML);
            });
            return template[0].outerHTML;
        }

        function categoriesListners() {
            $('#categories input[type="checkbox"]').on("click", function () {
                let original_check = $(this).prop("checked")
                $(this).parents("li").each(function () {
                    let input = $($(this).find("[data-id] input").get(0)).prop("checked", original_check);
                    console.log(input);
                });
            });
        }

        // Nesta fun????o vamos dar loop nas l??nguas todas e ver as que a not??cia j?? tem
        function languages(related, selected_language) {

            // Separamos para depois adicionar por ordem de ativo ou n??o
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

                    // Se o lang.item_id for nulo, quer dizer que ?? a noticia que temos atualmente carregada
                    button = `<a href="javascript:void(0)" style="min-width: 80px" class="btn btn-success btn-xs float-right">{{ ucfirst($translations["backoffice"]["language_btn_current"]) }}</a>`;
                    $(".language-selected").append(`
                        ` + lang.name + `
                    `);
                } else {

                    button = `<a href="/adm/jobs/` + lang.item_id + `" style="min-width: 80px" class="btn btn-info btn-xs float-right">{{ ucfirst($translations["backoffice"]["language_btn_see"]) }}</a>`;
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

            // Estamos a utilizar a fun????o serialize para todos os inputs dento de #jobs-form
            $.each($('#jobs-form').serializeArray(), function () {

                data[this.name] = this.value;
            });

            // Adicionar a imagem da p??gina
            let slim_data = $(".slim").slim('data')[0];
            if (slim_data.server) {
                
                data.photo_path = slim_data.server;
            }
            if (data["slim[]"] !== undefined) {
                // Eliminar o atributo slim[] das informa????es da p??gina
                delete data["slim[]"];
            }

            return data;
        }

        function filetype(path) {

            let extension = path.split('.').pop();

            switch (extension) {

                case 'jpg':
                    return 'image';

                case 'jpeg':
                    return 'image';

                case 'gif':
                    return 'image';

                case 'png':
                    return 'image';

                case 'rar':
                    return 'compress';

                case 'bz':
                    return 'compress';

                case 'zip':
                    return 'compress';

                case 'pdf':
                    return 'pdf';

                case 'doc':
                    return 'doc';

                case 'docx':
                    return 'doc';

                case 'mp3':
                    return 'audio';

                case 'ogg':
                    return 'audio';

                case 'mp4':
                    return 'video';

                case 'mkv':
                    return 'video';

                default:
                    return "file";
            }
        }

        function template() {

        return `<div class="dz-preview dz-complete dz-image-preview">
                    <div class="preview-container">
                        <img data-dz-thumbnail="" class="img-thumbnail border-0" style="width: 200px; height: 160px; object-fit: contain !important;">
                        <i class="simple-icon-doc preview-icon" style="visibility: visible;"></i>
                        <i class="simple-icon-volume-2 preview-icon"></i>
                        <i class="simple-icon-film preview-icon"></i>
                        <i class="simple-icon-lock preview-icon" style="visibility: visible;"></i>
                        <div class="dz-error-mark"><span><i></i></span></div>
                        <div class="dz-error-message"><span data-dz-errormessage=""></span></div>
                        <div class="dz-success-mark"><span><i></i></span></div>
                    </div>
                    <div class="dz-details">
                        <span data-dz-name=""></span>
                        <span data-dz-type=""></span>
                        <div class="text-primary text-extra-small" data-dz-size=""></div>
                    </div>
                    <a href="javascript:void(0)" class="play"> <i class="glyph-icon simple-icon-control-play"></i> </a>
                    <a href="javascript:void(0)" class="image-editor"> <i class="glyph-icon simple-icon-pencil"></i> </a>
                    <a href="javascript:void(0)" class="remove" data-dz-remove=""> <i class="glyph-icon simple-icon-trash"></i> </a>
                </div>`;
        }

        function icon(type) {

            switch (type) {

                case "video":
                    return {icon: "simple-icon-film", single: "Video", plural: "Videos"};
                    break;

                case "audio":
                    return {icon: "simple-icon-music-tone-alt", single: "Audio", plural: "Audios"};
                    break;

                case "file":
                    return {icon: "simple-icon-paper-clip", single: "Ficheiro", plural: "Ficheiros"};
                    break;

                case "doc":
                    return {icon: "simple-icon-doc", single: "Documento", plural: "Documentos"};
                    break;

                case "pdf":
                    return {icon: "simple-icon-doc", single: "Pdf", plural: "Pdfs"};
                    break;

                case "compress":
                    return {icon: "simple-icon-layers", single: "Pasta comprimida", plural: "Pastas comprimidas"};
                    break;

                case "image":
                    return {icon: "simple-icon-picture", single: "Imagem", plural: "Imagens"};
                    break;
            }

            return false;
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

                // Vamos buscar o ID ao bot??o de guardar
                let id = $("[data-action='save']").data("id");

                remove(id);
            });

            $("body").off("click", ".image-editor");
            $("body").on("click", ".image-editor", function () {

                imageThatIsBeingEdited = $(this).data("link");

                imageEditor($(this).data("link") + "?nocache=" + (new Date().getTime()));
            });

            $("body").off("click", ".tui-image-editor-close-btn");
            $("body").on("click", ".tui-image-editor-close-btn", function () {

                $("#editImageModal").modal("hide");
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

            // Ao escrever o t??tulo, mudar a slug
            $("[name='name']").on("input", function () {

                $("[name='slug']").val(slug($(this).val()));
                
                // Introduzir as informa????es novas no bloco SEO
                fill();
            });

            // Ao escrever a slug retirar espa??os e caraters especiais
            $("[name='slug']").on("input", function () {

                $("[name='slug']").val(slug($(this).val()));
            });

            // A cada 100ms vamos executar a fun????o fill
            setInterval(function () {

                fill();

            }, 100);
        }

        function base64ToBlob(data) {

            let rImageType = /data:(image\/.+);base64,/;

            var mimeString = '';
            var raw, uInt8Array, i, rawLength;

            raw = data.replace(rImageType, function (header, imageType) {
                mimeString = imageType;

                return '';
            });

            raw = atob(raw);
            rawLength = raw.length;
            uInt8Array = new Uint8Array(rawLength); // eslint-disable-line

            for (i = 0; i < rawLength; i += 1) {
                uInt8Array[i] = raw.charCodeAt(i);
            }

            return new Blob([uInt8Array], {type: mimeString});
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
                            url: "/api/jobs/",
                            // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                            // De texto, etc e em alguns servidores pode dar erro
                            type: "POST",
                            data: {lang: lang, id: id, draft: 0, status: 0, keep_language_group: true},
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

                                    // N??o deixar a fun????o executar mais
                                    return;
                                }

                                // Rederecionar para a p??gina da nova noticia
                                window.location.replace("/adm/jobs/" + response.data.id);
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
                    N??o: {}
                }
            });
        }

        // Eliminar a not??cia
        function remove(id) {

            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_message_news_remove"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/jobs/" + id,
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

                                    // N??o deixar a fun????o executar mais
                                    return;
                                }

                                // Rederecionar para a p??gina de index das not??cias
                                window.location.replace("/adm/jobs/");
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
                    N??o: {}
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

        // Fun????o para alterar valores dinamicamentes na p??gina
        function fill() {

            $("[data-fill='name']").text($("[name='title']").val());
            $("[data-fill='details']").html($("[name='description']").val().replace(/(<([^>]+)>)/gi, ""));
            $("[data-fill='slug']").text($("[name='slug']").val());

            // Data SEO        
        
        }

        // Fun????o para transformar uma string em slug, retirar caraters especiais
        function slug(str) {

            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ?? for n, etc
            var from = "??????????????????????????????????????????????/_,:;";
            var to = "aaaaeeeeiiiioooouuuunc------";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes

            return str;
        }

        function thumbnail(type) {

            switch (type) {

                case "video":
                    return "/static/images/preview/video.png";
                    break;

                case "audio":
                    return "/static/images/preview/audio.png";
                    break;

                case "file":
                    return "/static/images/preview/file.png";
                    break;

                case "doc":
                    return "/static/images/preview/doc.png";
                    break;

                case "pdf":
                    return "/static/images/preview/pdf.png";
                    break;

                case "compress":
                    return "/static/images/preview/compress.png";
                    break;
            }

            return false;
        }

        function listToTree(data) {
            const ID_KEY          = "id";
            const PARENT_KEY      = "parent";
            const CHILDREN_KEY    = "children";
            let item, id, parentId;
            let map = {};
            if(data != null){      // Verificar se existe data para evitar erro
                for (var i = 0; i < data.length; i++ ) {
                    if (data[i][ID_KEY]) {
                        map[data[i][ID_KEY]]    = data[i];
                        data[i][CHILDREN_KEY]   = [];
                    }
                }
                for (var i = 0; i < data.length; i++) {
                    if (data[i][PARENT_KEY]) { 
                        if (map[data[i][PARENT_KEY]]) {
                            map[data[i][PARENT_KEY]][CHILDREN_KEY].push(data[i]);   // Adicionar o filho ao pai
                            data.splice( i, 1 );                                    // Remover a categoria do root
                            i--;                                                    // Corrigir a itera????o
                        } else {
                            data[i][PARENT_KEY] = 0;
                        }
                    }
                }
            }
            return data;
        }        

    </script>
@endsection
