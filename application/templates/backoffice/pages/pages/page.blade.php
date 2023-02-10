@extends('layouts.master') 
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-md-12 mb-8">
                    <div class="col-12">
                        <h1 id="title-client">{{ ucfirst($translations["backoffice"]["title_edit_page"]) }}</h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/adm/pages">{{ ucfirst($translations["backoffice"]["pages"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" id="breadcrumb_client" aria-current="page">{{ ucfirst($translations["backoffice"]["title_edit_page"]) }}
                                </li>
                            </ol>
                        </nav>
                        <div class="btn-group top-right-button-container">
                            <button type="button" href="#" onclick='javascript:window.location.assign("/adm/pages");' class="btn btn-outline-secondary">{{ ucfirst($translations["backoffice"]["edit_custom_btn_back"]) }}</button>
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
                    <form id="pages-form">
                        <div class="contact-form clearfix">
                            <div class="row">
                                <div class="col-md-12 col-lg-8 col-sm-12 col-xs-12 mb-3" id="clintsDivForm">
                                    <!-- <div class="card">
                                        <div class="card-body">
                                            <h5 class="mb-0">
                                                <i class="simple-icon-note mr-1"></i>
                                                {{ ucfirst($translations["backoffice"]["form_client_title"]) }}
                                            </h5>
                                            <hr>

                                            <div class="row">
                                                 
                                                <div class="col-6">                                                    
                                                    <label class="form-group has-float-label">                                                        
                                                        <input value="" name="url" id="url_page" type="text"
                                                            autocomplete="off" class="form-control">
                                                        <span>{{ ucfirst($translations["backoffice"]["url_form_pages"]) }}</span>
                                                    </label>
                                                </div>   
                                                <div class="col-6" id="url_page_copy">                                                    
                                                    
                                                </div>                                         
                                                

                                            </div>

                                        </div>
                                    </div>
                                    <br> -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="w-100">
                                                <h5><i class="simple-icon-organization mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_news_seo_tags"]) }}</h5>
                                                <hr>
                                                <div class="form-group mt-4">
                                                    <label class="form-group has-float-label">
                                                        <input data-fill="name" name="name" id="name_page" type="text"
                                                               autocomplete="off" class="form-control">
                                                        <span>{{ ucfirst($translations["backoffice"]["name_form_pages"]) }}</span>
                                                    </label>
                                                </div> 
                                                <div class="form-group mt-4">
                                                    <label class="form-group has-float-label">
                                                        <input name="url" data-fill="url" type="text" autocomplete="off" class="form-control" id="url_page">
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
                                                                    <p>{{ URL }}<span id="current_lang"></span>/pages/<span data-fill="slug"></span></p>
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
                                <div class="col-md-12 col-lg-4 col-sm-12 col-xs-12" id="clientsCardsStatusActions">
                                    <div class="card">
                                        <div class="col-12">
                                            <div class="card-body">
                                                <button type="button" data-action="deletePage" class=" btn btn-outline-danger btn-xs mr-2 mb-2">{{ ucfirst($translations["backoffice"]["edit_product_btn_remove"]) }}</button>
                                                <button type="button" data-action="savePage" class=" btn btn-outline-info btn-xs mr-2 mb-2">{{ ucfirst($translations["backoffice"]["edit_product_btn_save"]) }}</button> 
                                                <div id="msg-to-display-edit-btn" style="margin-top: 15px;">
                                                    <p>Para editar o conteúdo, insira um url e guarde essa página.</p>
                                                </div>
                                                <a id="btn_edit_content" href="/adm/editor/{{$id}}" target="_blank" style="display: none;">
                                                    <button type="button" class="btn btn-xs btn-outline-success mb-1">
                                                        {{ ucfirst($translations["backoffice"]["insert_content_or_edit"]) }}
                                                    </button>
                                                </a>
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
                                    <br>
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mb-3" id="clintsDivForm">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h5 class="mb-0">
                                                        <i class="simple-icon-note mr-1"></i>
                                                        {{ ucfirst($translations["backoffice"]["page_content"]) }}
                                                    </h5>
                                                </div>
                                                <div class="col-6">
                                                    <a style="min-width: 80px" class="refrech-iframe btn btn-light btn-xs float-right">Atualizar</a>
                                                </div>
                                            </div>                                          
                                           
                                            <hr>

                                            <div class="row">
                                                <div class="col-12" id="iframe_page" style="min-height: 800px;">
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
    
        var translations = {};
        //Iniciar a pagina
        window.addEventListener("load", function () {

            // Precisamos primeiro buscar as linguas que a loja suporta e só depois carregar a noticia

        // Iniciar o objecto das linguas que a loja tem

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
            
        });


        

        function clipboardF (copyText) {
            if(navigator.clipboard) {
                navigator.clipboard.writeText(copyText).then(function() {
                    alert("link copiado com sucesso.");
                })
                .catch(() => {
                    alert("algo deu errado.");
                });
            }else{
                alert(copyText);
            }
        }

        

        function init() {
            var page = new RegExp('^/adm/pages/.*');

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
            url: "/api/pages/" + id,
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
            
                $("[data-action='savePage']").attr("data-pageId", response.data.id)
                $("[data-action='deletePage']").attr("data-pageId", response.data.id) 
                $("#name_page").val(response.data.name)
                $("#url_page").val(response.data.url)
                $("[name='keywords']").val(response.data.keywords)  
                document.querySelector('#current_lang').innerHTML = response.data.lang;
                document.querySelector('#iframe_page').innerHTML = `
                    <iframe width="100%" id="the_content" height="100%" src="{{ URL }}`+ response.data.lang +`/pages/` + response.data.url +`?iframe=`+ response.data.lang +`" title="`+ response.data.name +`" style="border:none;"></iframe>
                `;

                
                if(response.data.url != null) {
                    showEditBtn();
                }
                            
                // Carregar as linguas
                languages(response.data.related, {lang: response.data.lang, status: response.data.status});

                // Refresh do plugin das tags
                $('[name="keywords"]').tagsinput('refresh');
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

    function showEditBtn () {
        document.getElementById('msg-to-display-edit-btn').style.display = 'none';
        document.getElementById('btn_edit_content').style.display = 'block';
    }

    function getPageData() {
        let data = {};

        // Estamos a utilizar a função serialize para todos os inputs dento de #news-form
        $.each($('#pages-form').serializeArray(), function () {

            data[this.name] = this.value;
        });

        console.log(data)
        return data;
    }

    function save(id, data) {
        // Temos de tirar o estado de rascunho se existir
        if(data.url == "") {
            $.alert({
                title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                theme: "supervan",
                content: 'Para salvar, é necessário ter um url único.',
            });
            return;
        }
        data.draft = 0;
        console.log(id, data)
            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_client_save"]) }}',
                buttons: {                    
                    Sim: function () {
                        $.ajax({
                            url: "/api/pages/" + id,
                            // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                            // De texto, etc e em alguns servidores pode dar erro
                            type: "POST",
                            data: data,
                            dataType: "json",
                            success: function (response) {
                                if (!response.success) {

                                    // Output do erro
                                    console.error(response);

                                    let content_msg = response.data.msg != null ? response.data.msg  : '{{ ucfirst($translations["backoffice"]["error_console"]) }}';

                                    $.alert({
                                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                        theme: "supervan",
                                        content: content_msg,
                                    });

                                    // Não deixar a função executar mais
                                    return;
                                }

                                if(response.data.url != '' && response.data.url != null) {
                                    showEditBtn();
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {

                                console.log(textStatus, errorThrown), jqXHR;

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
                            url: "/api/pages/" + id,
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
                                window.location.replace("/adm/pages/");

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

        function createAnotherLanguage(lang, name) {

            let id = $("[data-action='savePage']").attr("data-pageId");
            console.log(id)
            $.confirm({
                title: name,
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_create_product_another_language"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/pages/",
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
                                window.location.replace("/adm/pages/" + response.data.id);
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

                    button = `<a href="/adm/pages/` + lang.item_id + `" style="min-width: 80px" class="btn btn-info btn-xs float-right">{{ ucfirst($translations["backoffice"]["language_btn_see"]) }}</a>`;
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

         // Função para alterar valores dinamicamentes na página
         function fill() {
            $("[data-fill='name']").text($("[name='name']").val());            
            $("[data-fill='url']").val(slug($("[name='name']").val()));
            $("[data-fill='slug']").text(slug($("[name='url']").val()));

            
            // Data SEO

            let date = new Date('29 Feb 2020');
            // split  based on whitespace, then get except the first element
            // and then join again
            $("[data-fill='date']").text(date.toDateString().split(' ').slice(1).join(' ') + " - ");
        }

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

        function refreshIframe(id) {
            $.ajax({
                url: "/api/pages/" + id,
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
                    let language = response.data.lang;
                    document.querySelector('#iframe_page').innerHTML = `
                        <iframe width="100%" id="the_content" height="100%" src="{{ URL }}`+ language +`/pages/` + response.data.url +`?iframe=`+ language +`" title="`+ response.data.name +`" style="border:none;"></iframe>
                    `;
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


            // Ao clicar no botao de criar nova lingua
            $("body").on("click", ".create-other-language-button", function() {

                let lang        = $(this).data("lang");
                let lang_name   = $(this).data("lang-name");

                createAnotherLanguage(lang, lang_name)

            });    
            
            $('.refrech-iframe').click(function(){
               // document.getElementById('the_content').contentDocument.location.reload(true);
                var page = new RegExp('^/adm/pages/.*');

                var path = window.location.pathname.replace(/\/+$/, '');

                var wildcard = null;

                if (page.test(path)) {

                    wildcard = path.split("/");
                    wildcard = wildcard[wildcard.length - 1];
                    // Página para editar produto, vamos buscar as informações do mesmo
                    refreshIframe(wildcard)

                }
            });

            // A cada 100ms vamos executar a função fill
            setInterval(function () {

                fill();

            }, 100);

        }

</script>