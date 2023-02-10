@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-md-12 mb-8">
                    <div class="col-12">
                        <h1>{{ ucfirst($translations["backoffice"]["title_edit_recruitments"]) }}</h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/adm/recruitments">{{ ucfirst($translations["backoffice"]["recruitments"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($translations["backoffice"]["title_edit_recruitments"]) }}</li>
                            </ol>
                        </nav>
                        <div class="btn-group top-right-button-container">
                            <button type="button" href="javascript:void(0)" onclick='javascript:window.location.assign("/adm/recruitments");' class="btn btn-outline-secondary">{{ ucfirst($translations["backoffice"]["edit_custom_btn_back"]) }}</button>
                        </div>		
                        <div class="separator mb-5"></div>
                    </div>
                    <form id="news-form">
                        <div class="contact-form clearfix">
                            <div class="row">
                                <div class="col-md-12 col-xl-8 col-sm-12 col-xs-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-group has-float-label">
                                                        <input id="title" name="title" type="text" autocomplete="off"
                                                            class="form-control">
                                                        <span>{{ ucfirst($translations["backoffice"]["edit_recruitment_fill_name"]) }}</span>
                                                    </label>
                                                </div>
                                                <br>
                                                <div class="col-12">
                                                    <label class="form-group has-float-label">
                                                        <input name="date" type="date" autocomplete="off"
                                                            class="form-control">
                                                        <span>{{ ucfirst($translations["backoffice"]["edit_news_fill_date"]) }}</span>
                                                    </label>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-group ckeditor has-float-label">
                                                        <textarea name="text" rows="20" class="c-editor w-100"></textarea>
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
                                                                    <p>{{ URL }}{{ $selected_language->code }}/blog/<span data-fill="slug"></span></p>
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
                                                <button type="button" data-action="save" class="btn btn-xs btn-outline-info m-1">{{ ucfirst($translations["backoffice"]["edit_news_btn_save"]) }}</button>
                                                <div class="form-group mt-4"> 
                                                    <label><span class="dot green mr-2"></span> {{ ucfirst($translations["backoffice"]["edit_recruitment_status"]) }}</label>
                                                    <select name="status" class="form-control">
                                                        <option value="2">{{ ucfirst($translations["backoffice"]["news_status_published"]) }}</option>
                                                        <option value="1">{{ ucfirst($translations["backoffice"]["news_status_private"]) }}</option>
                                                        <option value="0">{{ ucfirst($translations["backoffice"]["news_status_draft"]) }}</option>
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
                
                folder: 'recruitments'
            }
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
            var page = new RegExp('^/adm/recruitments/.*');

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
                            url: "/api/recruitments/" + id,
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
                url: "/api/recruitments/" + id,
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

                            case "text":
                                editors["text"].setElementValue(value);
                                break;
                            
                            case "status":
                                
                                // Atualizar o select do status
                                $(`[name="status"]`).val(value);

                                // Atualizar o botão verde/vermelho/laranja
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

                    button = `<a href="/adm/recruitments/` + lang.item_id + `" style="min-width: 80px" class="btn btn-info btn-xs float-right">{{ ucfirst($translations["backoffice"]["language_btn_see"]) }}</a>`;
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

            // Ao escrever a slug retirar espaços e caraters especiais
            $("[name='slug']").on("input", function () {

                $("[name='slug']").val(slug($(this).val()));
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
                            url: "/api/recruitments/",
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
                                window.location.replace("/adm/recruitments/" + response.data.id);
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
                            url: "/api/recruitments/" + id,
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
                                window.location.replace("/adm/recruitments/");
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
            $("[data-fill='slug']").text($("[name='slug']").val());

            // Data SEO

            let date = new Date('29 Feb 2020');
            // split  based on whitespace, then get except the first element
            // and then join again
            $("[data-fill='date']").text(date.toDateString().split(' ').slice(1).join(' ') + " - ");
        }

        // Função para transformar uma string em slug, retirar caraters especiais
        function slug(str) {

            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
            var to = "aaaaeeeeiiiioooouuuunc------";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes

            return str;
        }

    </script>
@endsection
