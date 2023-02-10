@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-md-12 mb-8">
                    <div class="col-12">
                        <h1>{{ ucfirst($translations["backoffice"]["title_edit_custom"]) }}</h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/adm/personalization">{{ ucfirst($translations["backoffice"]["custom"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($translations["backoffice"]["title_edit_custom"]) }}</li>
                            </ol>
                        </nav>
                        <div class="btn-group top-right-button-container">
                            <button type="button" href="#" onclick='javascript:window.location.assign("/adm/personalization");' class="btn btn-outline-secondary">{{ ucfirst($translations["backoffice"]["edit_custom_btn_back"]) }}</button>
                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ ucfirst($translations["backoffice"]["languages"]) }}</button>
                            <div class="dropdown-menu dropdown-menu-right p-3" style="width: max-content;">
                                <table class="table table-hover borderless">
                                    <tbody class="languages-list"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="separator mb-5"></div>
                    </div>
                    <form id="personalization-form">
                        <div class="contact-form clearfix">
                            <div class="row">
                                <div class="col-md-12 col-xl-8 col-sm-12 col-xs-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5><i class="simple-icon-book-open mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_custom_informations"]) }}</h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-group has-float-label">
                                                        <input id="title" name="name" type="text" autocomplete="off"
                                                            class="form-control">
                                                        <span>{{ ucfirst($translations["backoffice"]["edit_custom_fill_name"]) }}</span>
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-group has-float-label">
                                                        <input id="title" name="ref" type="text" autocomplete="off"
                                                               class="form-control">
                                                        <span>{{ ucfirst($translations["backoffice"]["edit_custom_fill_ref"]) }}</span>
                                                    </label>
                                                </div>
                                                <div class="col-12 form-group">
                                                    <label>{{ ucfirst($translations["backoffice"]["edit_custom_fill_group"]) }}</label>
                                                    <div id="personalizationGroups" class="listPersonalizationGroups">

                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-group ckeditor has-float-label">
                                                        <textarea name="text" rows="20" class="c-editor w-100"></textarea>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-4 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="col-12">
                                            <div class="card-body">
                                                <h5><i class="simple-icon-basket mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_custom_features"]) }}</h5>
                                                <hr>
                                                <a href="#" onclick='javascript:window.location.assign("/adm/personalization");' class="btn btn-xs btn-outline-secondary mb-1">{{ ucfirst($translations["backoffice"]["edit_custom_btn_back"]) }}</a>
                                                <button type="button" data-action="delete" class="btn btn-xs btn-outline-danger mb-1">{{ ucfirst($translations["backoffice"]["edit_custom_btn_remove"]) }}</button>
                                                <button type="button" data-action="save" class="btn btn-xs btn-outline-info mb-1">{{ ucfirst($translations["backoffice"]["edit_custom_btn_save"]) }}</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="card">
                                        <div class="col-12">
                                            <div class="card-body">
                                                <h5><i class="simple-icon-picture mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_custom_image"]) }} </h5>
                                                <hr>
                                                <div class="slim"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- START SCRIPTS -->
    <script src="/static/backoffice/javascript/jodit_editor_js/jodit.js"></script>
    <script src="/static/backoffice/javascript/jodit_editor_js/app.js"></script>
    <script src="/static/backoffice/javascript/jodit_editor_js/prism.js"></script>
    <link rel="stylesheet" href="/static/backoffice/css/jodit_editor_css/app.css" />
    <link rel="stylesheet" href="/static/backoffice/css/jodit_editor_css/jodit.css" />
    <link rel="stylesheet" href="/static/backoffice/css/jodit_editor_css/prism.css" />

 @endsection

 @section('scripts')

    <script>

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

        // Iniciar o plugin de imagens Slim
        $(".slim").slim({
			
            push: true,
            service: '/api/image/slim',
            label: 'Carregar',
            statusUploadSuccess: 'Guardado!',
            ratio: "1:1",
            
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
                
                folder: 'personalization'
            }
        });

        /*
         *	Extract text from ClassicEditor
         */

        function getDataFromTheEditor() {

            return editors["marker"].getData();
        }


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

        // Precisamos primeiro buscar as linguas que a loja suporta e só depois carregar a noticia

        function init() {

            // Vamos buscar o url pretendido para ver se a página vai editar ou adicionar novo produto
            var page = new RegExp('^/adm/personalization/.*');

            // Vamos buscar o link do site
            var path = window.location.pathname.replace(/\/+$/, '');

            // Predefinir a variavel do wildcard
            var wildcard = null;

            if (page.test(path)) {

                // Definir a wildcard como o último valor do URL /valor1/valor2/valor3 ( nest caso vamos buscar o valor 3)
                wildcard = path.split("/");
                wildcard = wildcard[wildcard.length - 1];

                // Página para editar produto, vamos buscar as informações do mesmo
                load(wildcard);
                listeners()

                // Adicionar o id ao botão de guardar
                $('[data-action="save"]').attr("data-id", wildcard);

            }
        }

        function load(id) {
            $.ajax({
                url: "/api/personalizationItems/" + id,
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
                    if (response.data.text == null) {

                        response.data.text = "";
                    }
                    loadPersonalizationGroup(response.data.id_groups, response.data.lang, response.data)
                    languages(response.data.related, {lang: response.data.lang, status: response.data.status});
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

        function populatePersonalizationItem(item) {


            $.each(item, function(key, valueItem) {
                switch (key) {

                    case "text":
                        editors["text"].setElementValue(valueItem);
                        break;

                    case "id_groups":
                        $.each(valueItem.split(" "), function(key, valuePersonalizationGroup) {
                            $(`.personalizationGroup[data-id="` + valuePersonalizationGroup + `"]`).prop("checked", true);
                        });
                        break;

                    case "photo":

                        if (valueItem != null && valueItem.length > 0) {
                            // Carregar imagem do slide
                            $(".slim").slim('load',  valueItem, { blockPush : true }, function(error, data) { });
                        }
                        break;

                    default:
                        $(`[name="` + key + `"]`).val(valueItem);
                        break;
                }
            });
        }

        function loadPersonalizationGroup(personalizationGroups, lang = "pt", data) {
            $.ajax({
                url: "/api/personalizationByLanguage/" + lang,
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
                    populatePersonalizationGroup(response.data, personalizationGroups)
                    personalizationGroupsListeners();
                    populatePersonalizationItem(data);
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

        function populatePersonalizationGroup(items, personalizationGroups) {
            if (personalizationGroups === null) {

                personalizationGroups = "";
            }

            const selected = personalizationGroups.split(',');

            $.each(items, function(key, item) {

                let template = `<div class="input-group mb-3 col-lg-12">
                                    <div class="input-group-prepend col-lg-12">
                                        <div class="input-group-text col-lg-12 input-personalizationGroup">
                                           <input ` + (selected.includes(item.id) ? "checked" : "") + ` class="mr-2 personalizationGroup" type="checkbox" data-id="` + item.id + `">` + item.name + `
                                        </div>
                                    </div>
                                </div>`

                $('.listPersonalizationGroups').append(template);
            })
        }
        function personalizationGroupsListeners() {

            $('#personalizationGroups input[type="checkbox"]').on("click", function () {

                let original_check = $(this).prop("checked")

                $(this).parents("li").each(function () {

                    let input = $($(this).find("[data-id] input").get(0)).prop("checked", original_check);
                });
            });
        }

        function save(id="", data) {
            // Temos de tirar o estado de rascunho se existir
            data.draft = 0;
            data.id_groups = [];
            console.log(data)

            $("#personalizationGroups input:checked").each(function (key, item) {
                data.id_groups.push($(item).data("id"));
                console.log("personalizationGroups push", data.id_groups)
            })

            data.id_groups = data.id_groups.join(" ");

            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_message_custom_save"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/personalizationItems/" + id,
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

                                // Rederecionar o index das personalizações
                                //window.location.reload;

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
                content: '{{ ucfirst($translations["backoffice"]["confirm_message_custom_remove"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/personalizationItems/" + id,
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
                                window.location.replace("/adm/personalization/");
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
            // Ao clicar no botao de guardar
            $("[data-action='save']").on("click", function() {
                let data = getPageData();

                console.log("data", data)

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
        }

        function getPageData() {

            let data = {};

            // Estamos a utilizar a função serialize para todos os inputs dento de #news-form
            $.each($('#personalization-form').serializeArray(), function () {

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

            return data;
        }

        // Nesta função vamos dar loop nas línguas todas e ver as que a notícia já tem
        function languages(related, selected_language) {

            // Separamos para depois adicionar por ordem de ativo ou não
            let active      = [];
            let non_active  = [];

            console.log("langSelect", selected_language)
            console.log(related)

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

            console.log("active", active);

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

                } else {

                    button = `<a href="/adm/personalization/` + lang.item_id + `" style="min-width: 80px" class="btn btn-info btn-xs float-right">{{ ucfirst($translations["backoffice"]["language_btn_see"]) }}</a>`;
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

        function createAnotherLanguage(lang, name) {

            let id = $("[data-action='save']").data("id");

            $.confirm({
                title: name,
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_create_product_another_language"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/personalizationItems/",
                            // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                            // De texto, etc e em alguns servidores pode dar erro
                            type: "POST",
                            data: {lang: lang, id: id, draft: 0},
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
                                window.location.replace("/adm/personalization/" + response.data.id);
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
