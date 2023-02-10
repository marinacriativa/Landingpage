@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <h1>{{ ucfirst($translations["backoffice"]["title_ranking_blocks"]) }}</h1>
                        
                        <div class="btn-group top-right-button-container m-2">                          
                            @php 
                                $countLangs = 0;
                                $c_lang = isset($_GET["lang"]) ? $_GET["lang"] : $selected_language->code;
                            @endphp
                            @if(count($languages) > 1)
                                @foreach ($languages as $langs)
                                    @if($langs->active == 1)
                                        @php                                             
                                            $countLangs ++;
                                        @endphp
                                        @if($c_lang == $langs->code)
                                            @php   
                                                $c_lang = $langs->name;
                                            @endphp
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                            @if($countLangs > 1)
                                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle botaodrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span id="c_lang">{{$c_lang}}</span></button>
                                <div class="dropdown-menu dropdown-menu-right p-3" style="width: max-content;">
                                    <ul class="nav nav-tabs" id="big-banners-languages-list" role="tablist"></ul>
                                </div>
                            @endif
                        </div>	

                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ ucfirst($translations["backoffice"]["title_ranking_blocks"]) }}                                    
                                </li>
                            </ol>
                        </nav>
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

        var lang        = (query.lang   !== undefined) ? query.lang     : '{{$selected_language->code}}';


        load();

        //Evento onClick butao Registar novo produto
        $('[data-action="newPage"]').on("click", function () {

        let data = {
            draft: 1,
            status: 0
        }
        create(data);
        });

        function create(data) {

        $.ajax({
            url: "/api/ranking_blocks",
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
                window.location.href = "/adm/ranking_blocks/" + response.data.id;
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

        function load() {

            window.history.replaceState("", "", '/adm/ranking_blocks?' + $.param( { lang: lang } ));

            $.ajax({
                url: "/api/ranking_blocks?lang=" + lang,
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
                    

                    //inicia os listeners
                    listeners();

                    getLanguages(function() {
                        // Por cada lingua que tivermos temos de adicionar uma tab
                        $.each(window.LANGUAGES, function(key, language) {

                            // Introduzir as linguas no modal de editar
                            $("#big-banners-modal select").append(`<option value="` + language.code + `">` + language.name + `</option>`);

                            // Verificar se é a lingua default ou não
                            (language.default === "1") ? default_language = language.code: null;

                            // Nav links
                            if ($("#big-banners-languages-list").find(".nav-item").length < window.LANGUAGES.length) {

                                $("#big-banners-languages-list").append(`
                                    <li class="nav-item w-100 bg-white p-0">
                                        <a class="btn btn-outline-primary mb-1 btn-xs w-100 btns-languages ` + ((language.default === "1") ? "active" : "") +
                                        `" href="/adm/ranking_blocks?lang=` + language.code +`">` + language.name + `</a>  
                                    </li>
                                `);            
                                

                            }
                        });
                    });
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

        /* <p class="mb-0 text-muted text-small w-20 w-sm-100 centerText-max-w-767" id="url_link">` + item.url + `</p>    */
        function populate(items){
            //Limpar a lista de items
            $(".list").html("");

            let status = "";         

            

            $.each(items, function (key, item) {
                switch (item.status) {
                    case "0":
                        status = '<span class="dot red mr-2"></span> {{ ucfirst($translations["backoffice"]["products_status_draft"]) }}';
                        break;
                    case "1":
                        status = '<span class="dot orange mr-2"></span> {{ ucfirst($translations["backoffice"]["products_status_private"]) }}';
                        break;
                    case "2":
                        status = '<span class="dot green mr-2"></span> {{ ucfirst($translations["backoffice"]["products_status_published"]) }}';
                        break;
                }
                let is_checked = item.active == 1 ? 'checked' : '';
                let template =`
  
            <div class="card d-flex flex-row mb-3">                
                <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                    <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                        <a href="/adm/ranking_blocks/` + item.id + `" class="w-40 w-sm-100 truncate">
                            <p class="list-item-heading mb-0 truncate">` + item.name + `</p>
                        </a>                     
                        
                        <div class="w-40 w-sm-100 m-1">		
                            <span class="custom-switch custom-switch-secondary mb-2 custom-switch-small vertical-align-center"> 
                                <input class="custom-switch-input change_active_status" data-id="` + item.id + `" id="blocks-active-` + item.id + `" type="checkbox" name="active" ${is_checked}> 
                                <label rel="tooltip" title="Desativado / Ativado" class="custom-switch-btn" for="blocks-active-` + item.id + `"></label> 
                            </span>											
                            <a class="btn btn-outline-secondary mb-1 btn-xs m-1 float-right" name="edit_slide_btn" title="editar" id="edit_slide_btn" href="/adm/ranking_blocks/` + item.id + `"><i class="simple-icon-pencil"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            `;
                $(".list").append(template);
            });
            //Caso a lista esteja vazia
            if(items === undefined || items.length == 0){
                $(".list").html(`
                    <h4>{{ ucfirst($translations["backoffice"]["not_found_male"]) }} {{ $translations["backoffice"]["title_ranking_blocks"] }}</h4>
                    <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
                `);
            }
        }

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

        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });        


        function removeAlert(id) {
            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_product_remove"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/ranking_blocks/" + id,
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

                                // Redirecionar para a página de index dos alertas
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
            
            $(".change_active_status").off("click");
            $(".change_active_status").on("click", function() {

                let id  = $(this).attr("data-id");

                $.ajax({
                    url: "/api/blocksActive/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {

                        if (!response.success) {

                            // Output do erro
                            console.error(response);

                            $.alert({
                                title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                theme: "supervan",
                                content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                            });

                            load()

                            // Não deixar a função executar mais
                            return;
                        }                       
                        
                        // Obter dados novos do servidor
                        load();


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
                
            });

            // Dropdown de mudar a ordenação dos items
            $(".order-menu").off("click");
            $(".order-menu").on("click", function() {

                order   = $(this).data("order");
                page    = 1;

                $(".clients-order-menu").text($(this).text());
                load();
            });
        }

        function getLanguages(callback) {

            // Vereficar se já carregamos as línguas
            if (window.LANGUAGES !== undefined) {

                callback();

            } else {

                $.ajax({
                    url: "/api/translations/",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {

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

                        window.LANGUAGES = response.data;

                        // Chamar o callback
                        callback();

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
        }
    </script>
@endsection


