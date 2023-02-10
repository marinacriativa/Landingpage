@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <h1>{{ ucfirst($translations["backoffice"]["banner_title"]) }}</h1>

                        <div class="btn-group top-right-button-container m-2">
                            <div class="btn btn-primary btn-lg pl-4 pr-0 check-button">
                                <label class="custom-control custom-checkbox mb-0 d-inline-block">
                                    <input type="checkbox" class="custom-control-input" id="checkAll">
                                    <span class="custom-control-label">&nbsp;</span>
                                </label>
                            </div>
                            <button id="btnGroupDrop1" type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split botaodrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" onclick="deleteMultiple()"> Eliminar selecionados <i class="simple-icon-trash btn-outline-danger"></i></a>
                            </div>
                        </div>
                        
                        <div class="btn-group top-right-button-container m-2">
                            <a href="javascript:void(0)" data-action="newProduct" type="button" class="btn btn-primary add-new-banners  botaodrop">{{ ucfirst($translations["backoffice"]["banner_btn_create"]) }}</a>
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
                                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle botaodrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span id="c_lang">{{$selected_language->name }}</span> </button>
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
                                    {{ ucfirst($translations["backoffice"]["banner_title"]) }}                                    
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="mb-2">
                        <div class="collapse d-block" id="displayOptions">
                            <div class="d-block d-md-inline-block">
                                <div class="btn-group float-md-left mr-1 mb-1">
                                    <button class="btn btn-outline-dark btn-xs dropdown-toggle clients-order-menu"
                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">{{ ucfirst($translations["backoffice"]["order_by"]) }}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item order-menu" data-order="order_by">{{ ucfirst($translations["backoffice"]["orderBy_last_inserted"]) }}</a>
                                        <a class="dropdown-item order-menu" data-order="title">{{ ucfirst($translations["backoffice"]["orderBy_name"]) }}</a>
                                        <a class="dropdown-item order-menu" data-order="active">{{ ucfirst($translations["backoffice"]["orderBy_status"]) }}</a>
                                    </div>
                                </div>
                                <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                                    <input placeholder={{ ucfirst($translations["backoffice"]["search"]) }}>
                                </div>
                                <a class="search-button"><i class="simple-icon-magnifier"></i></a>
                            </div>
                            <div class="float-md-right">
                                <span class="text-muted text-small mr-1">{{ ucfirst($translations["backoffice"]["items_per_page"]) }} </span>
                                <button class="btn btn-outline-dark btn-xs dropdown-toggle clients-lenght-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 10 </button>
                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                    <a class="dropdown-item length-link" data-length="10">10</a>
                                    <a class="dropdown-item length-link" data-length="50">50</a>
                                    <a class="dropdown-item length-link" data-length="100">100</a>
                                    <a class="dropdown-item length-link" data-length="150">150</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-content" id="big-banners-languages-tabs">
                        
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-12">
                    <nav class="mt-4 mb-3">
                        <ul class="pagination justify-content-center mb-0">
                        </ul>
                    </nav>
                </div>
            </div> -->
            <div class="modal fade modal-right" id="big-banners-modal" tabindex="-1" role="dialog" aria-labelledby="big-banners-modal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body pt-0">
                        <form>
                              
                                <div class=" nav-tabs nav-fill mb-2 border-0" role="tablist">

                                <ul class="card-header p-0 pb-0 nav nav-tabs step-anchor tproduto border-0">
                                    <li class="nav-item active pr-2 w-50">
                                        <a id="first-tab" data-toggle="tab" href="#banners-image" role="tab" class="nav-link active p-1 font-weight-700 active" aria-controls="first" aria-selected="true"> Imagem <br></a>
                                    </li>
                                    <li class="nav-item pr-2 w-50">
                                        <a data-toggle="tab" href="#banners-video" role="tab" class="nav-link p-1 font-weight-700" aria-controls="second" aria-selected="false"> Video <br></a>
                                    </li>
                                </ul>
                                </div>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="banners-image" role="tabpanel">
                                        <div id="banner-image" data-crop="0,0,1350,500"></div>
                                    </div>
                                    <div class="tab-pane fade" id="banners-video" role="tabpanel">
                                        <h6 style="d-block mb-2">Max: 10MB MP4</h6>
                                        <input id="file-input" type="file" accept="video/*" class="form-control">
                                        <video id="video" width="100%" height="300" controls></video>
                                    </div>
                                </div>
                                
                                <div class="my-4">      
                                    <span class="align-self-center my-auto">
                                        Resolução recomendada: 1350 x 500px.
                                    </span>                                    
                                </div>

                                <div class="my-4">      
                                    <span class="align-self-center my-auto">
                                        Ativo : 
                                    </span>
                                    <span class="custom-switch custom-switch-secondary custom-switch-small vertical-align-center float-right "> 
                                        <input name="active" class="custom-switch-input vertical-align-center" id="active" type="checkbox" checked> <label rel="tooltip" title="Ativar / Desativar" class="custom-switch-btn vertical-align-center" for="active"></label> 
                                    </span>
                                </div>

                                <div class="form-group mt-2">
                                    <label class="form-group has-float-label"><input name="title" class="form-control"><span>{{ ucfirst($translations["backoffice"]["banner_fill_title"]) }}</span></label>
                                </div>
                                <div class="form-group">
                                    <label class="form-group has-float-label"><input name="subtitle" class="form-control"><span>{{ ucfirst($translations["backoffice"]["banner_fill_subTitle"]) }}</span></label>
                               </div>
                                <div class="form-group">
                                    <label class="form-group has-float-label"><input name="description" class="form-control"><span>{{ ucfirst($translations["backoffice"]["banner_fill_description"]) }}</span></label>     
                                </div>
                                <div class="form-group">
                                    <label class="form-group has-float-label"><input name="button_text" class="form-control"><span>{{ ucfirst($translations["backoffice"]["banner_fill_btn_text"]) }}</span></label>     
                                </div>
                                <div class="form-group">
                                    <label class="form-group has-float-label"><input name="link" class="form-control"><span>{{ ucfirst($translations["backoffice"]["banner_fill_url"]) }}</span></label> 
                                </div>
                                <div class="form-group">
                                    <label class="form-group has-float-label"><select name="lang" class="form-control"><span>{{ ucfirst($translations["backoffice"]["banner_fill_language"]) }}</span></label>
                                    </select>
                                </div>
                                <fieldset class="form-group">
                                    <div class="row">
                                        <label class="col-form-label col-lg-12 pt-0">{{ ucfirst($translations["backoffice"]["banner_fill_alignment"]) }}</label>
                                        <div class="col-lg-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="align" id="align-left-new" value="left">
                                                <label class="form-check-label" for="align-left-new">{{ ucfirst($translations["backoffice"]["banner_alignment_left"]) }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="align" id="align-center-new" value="center">
                                                <label class="form-check-label" for="align-center-new">{{ ucfirst($translations["backoffice"]["banner_alignment_center"]) }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="align" id="align-right-new" value="right">
                                                <label class="form-check-label" for="align-right-new">{{ ucfirst($translations["backoffice"]["banner_alignment_right"]) }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <div class="row">
                                        <label class="col-form-label col-lg-12 pt-0">{{ ucfirst($translations["backoffice"]["banner_fill_text_color"]) }}</label>
                                        <div class="col-lg-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="color" id="color-white-new" value="white">
                                                <label class="form-check-label" for="color-white-new">{{ ucfirst($translations["backoffice"]["banner_text_color_white"]) }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="color" id="color-black-new" value="black">
                                                <label class="form-check-label" for="color-black-new">{{ ucfirst($translations["backoffice"]["banner_text_color_black"]) }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="color" id="color-darkgrey-new" value="darkgrey">
                                                <label class="form-check-label" for="color-dark-grey-new">{{ ucfirst($translations["backoffice"]["banner_text_color_dark_grey"]) }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">{{ ucfirst($translations["backoffice"]["banner_btn_cancel"]) }}</button>
                            <button type="button" class="btn btn-danger remove-banners btn-sm">{{ ucfirst($translations["backoffice"]["banner_btn_remove"]) }}</button>
                            <button type="button" class="btn btn-primary save-banner btn-sm">{{ ucfirst($translations["backoffice"]["banner_btn_save"]) }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
<script>

let query = parseQueryString();

var page        = (query.page   !== undefined) ? query.page     : 1;
var limit       = (query.limit  !== undefined) ? query.limit    : 10;
var order       = (query.order  !== undefined) ? query.order    : "order_by";
var lang        = (query.lang   !== undefined) ? query.lang     : '';
var search      = (query.search !== undefined) ? query.search   : "";

//Meter o input search com os valores GET se tiver
if (query.search !== undefined && query.search.length > 0) {

    $(".search-sm input").val(query.search);
}

if (query.limit !== undefined && query.limit.length > 0) {
    $(".clients-lenght-menu").text(limit);
} 

banners();     

function deleteMultiple () {
    var selected = [];

    $('.checkbox-allowed:checked').each(function(){
        selected.push($(this).val());
    });

    $.confirm({
        title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
        theme: "supervan",
        content: '{{ ucfirst($translations["backoffice"]["confirm_many_product_remove"]) }}',
        buttons: {

            Sim: function () {
                $.ajax({
                    url: "/api/banners_multiple",
                    type: "POST",
                    data: {selected},
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

                        // Rederecionar para a página de index dos banners
                        banners()
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
    
    console.log(selected);
}       

function cloneBanner(id) {
    $.confirm({
        title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
        theme: "supervan",
        content: '{{ ucfirst($translations["backoffice"]["confirm_product_clone"]) }}',
        buttons: {

            Sim: function () {
                $.ajax({
                    url: "/api/bannersClone",
                    type: "POST",
                    data: {id},
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

                        // Atualizar listagem dos banners
                        banners()
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

function removeBanner(id) {
    $.confirm({
        title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
        theme: "supervan",
        content: '{{ ucfirst($translations["backoffice"]["confirm_message_remove_banner"]) }}',
        buttons: {

            Sim: function () {
                $.ajax({
                    url: "/api/banners/" + id,
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

                        // Atualizar listagem dos banners
                        banners()
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

function banners() {

    var default_language = null;
    var uploaded_video   = null;

    initBanners();

    function slimDefaultConfig(meta) {

        return {
            
            push: true,
            service: '/api/image/slim',
            label: 'Carregar',
            statusUploadSuccess: 'Guardado!',
            
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

            meta : meta
        }
    }

    function initBanners() {

        videoUploadListners();
        
        $("#banner-image").slim(slimDefaultConfig( { folder: 'banners' }, "16:9" ));      

        // Temos de obter as línguas primeiro
        getLanguages(function() {

            // Limpar linguas do modal de editar
            $("#big-banners-modal select").html("");

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
                            ` text-small" id="language-big-banners-tab-` + language.code +
                            `" data-toggle="tab" href="#language-big-banners-` + language.code +
                            `" role="tab" data-name="` + language.name + `" data-code="` + language.code + `">` + language.name + `</a>
                        </li>
                    `);              
                    // Tabs
                    $("#big-banners-languages-tabs").append(`
                    <div class="tab-pane fade ` + ((language.default === "1") ? "active show" : "") +
                        `" id="language-big-banners-` + language.code + `" role="tabpanel">
                        <div class=" list sortable disable-text-selection banners-methods-list" id="language-big-banners-table-` + language.code + `"></div>
                    </div>
                `);

                }
            });
            window.history.replaceState("", "", '/adm/banners?' + $.param( { limit: limit, order: order, page: page, search: search, lang:lang } ));
            $.ajax({
                url: "/api/banners?page=" + page + "&search=" + search + "&length=" + limit + "&order=" + order + "&lang=" + lang,
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

                    // Limpar os items dentro das tabelas
                    $(".banners-methods-list").html("");

                    populatebanners(response.data);

                    // Ativar os listners 
                    listnersbanners();

                    //Paginação
                    /* if (response.pagination !== undefined) {

                        let pagination  = response.pagination;
                        let page        = pagination.page;
                        let pages       = Math.ceil(pagination.total / pagination.limit); //Calcula o total de paginas

                        //Adiciona o html dos botões da paginação debaixo da lista
                        $(".pagination").html(pagination_template(page, pages));
                    } */

                    $( ".sortable" ).sortable({                        
                            cursor: "move",
                            dropOnEmpty: true,
                            tolerance: "pointer",
                            opacity: 0.7,
                            revert: 300,
                            delay: 150,
                            placeholder: "movable-placeholder",
                            start: function(e, ui) {
                                ui.placeholder.height(ui.helper.outerHeight());
                            },
                            stop:function () {
                                var ids = '';
                                $('.ui-sortable-handle').each(function () {                                
                                    id = $(this).attr("data-id");
                                    if(ids == '') {
                                        ids = id;
                                    } else {
                                        ids = ids + ',' + id;
                                    }
                                })
                                $.ajax({
                                    url: "/api/banners/sortable",
                                    type: "POST",
                                    data: {ids: ids},
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
                                    }
                                })
                            }
                        })
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
    }

    function populatebanners(items) {
            
            $.each(items, function (key, item) {
                let is_checked = item.active == 1 ? 'checked' : '';
                let display_midia = '';
                console.log(item)
                if(item.photo != null && item.photo.length != 0) {
                    display_midia = `<div class="background-image" style="background-image: url(`+ item.photo +`)"></div>`;
                } else if (item.video != null && item.video.length != 0) {
                    display_midia = `<div style="width:100px;">
                        <video autoplay muted loop  style="width:100px;">
                            <source src="`+ item.video +`">
                        </video>
                    </div>`;
                } else {
                    display_midia = `<div class="background-image" style="background-image: url('/static/backoffice/images/placeholder.png')"></div>`;
                }

                $(`#language-big-banners-table-` + item.lang).append(`
                <div class="card d-flex flex-row mb-3" data-id="` + item.id + `">
                    <a class="d-flex a-index-img edit-banners" href="javascript:void(0)" data-id="` + item.id + `">
                        `+ display_midia +`                        
                    </a>
                    <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                        <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                            <a href="javascript:void(0)" class="w-20 w-sm-100 truncate edit-banners" data-id="` + item.id + `">
                                <p class="list-item-heading mb-0 truncate">` + item.title + `</p>
                            </a>
                            <p class="mb-0 text-muted text-small w-20 w-sm-100 m-1">` + item.subtitle + `</p>
                            <p class="mb-0 text-muted text-small w-20 w-sm-100 m-1 truncate">` + item.description + `</p>
                            <p class="mb-0 text-muted text-small w-20 w-sm-100 m-1">` + item.button_text + `</p>
                            <div class="w-40 w-sm-100 m-1">
                                <label class="custom-control custom-checkbox align-self-center float-right my-1 mx-2">
                                    <input type="checkbox" name="selected_ids[]" value="` + item.id + `" class="checkbox-allowed custom-control-input">
                                    <span class="custom-control-label"></span>
                                </label>
                                <span class="custom-switch custom-switch-secondary mb-2 custom-switch-small vertical-align-center"> 
                                    <input class="custom-switch-input change_active_status" data-id="` + item.id + `" id="banner-active-` + item.id + `" type="checkbox" name="active" ${is_checked}> 
                                    <label rel="tooltip" title="Desativado / Ativado" class="custom-switch-btn" for="banner-active-` + item.id + `"></label> 
                                </span>
                                <button class="btn btn-outline-danger mb-1 btn-xs m-1 float-right" name="delte_slide_btn " title="apagar" id="delte_slide_btn" onclick="removeBanner(` + item.id + `)"><i class="simple-icon-trash"></i></button>
                                <button class="btn btn-outline-secondary btn-xs m-1 float-right edit-banners" data-id="` + item.id + `" name="edit_slide_btn" title="editar" id="edit_slide_btn"><i class="simple-icon-pencil"></i></button>
                                <a class="btn btn-outline-dark mb-1 btn-xs m-1 float-right" title="copiar" onclick="cloneBanner(` + item.id + `)" data-id="` + item.id + `"><i class="simple-icon-docs"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                `);
            });

            //Caso os items estejam vazios
            if (items === undefined || items.length == 0) {

                //Na listagem meter uma mensagem a dizer que está vazio
                $(`.banners-method-list`).html(`
                	<h4>{{ ucfirst($translations["backoffice"]["not_found_male"]) }} {{ $translations["backoffice"]["banner_title"] }}</h4>
				    <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
                `);
            }  
        } 

        /*
      function populatebanners(items) {

            $.each(items, function(key, banners) {			

                content = banners.photo ? `<img class="card-img-top" src="${banners.photo}" alt="${banners.title}">` : `
                    <video class="card-img-top" controls>
                        <source src="${banners.video}" type="video/mp4">
                    </video>`;
                // Adicionar o banner à lingua correspondente
                $(`#language-big-banners-table-` + banners.lang).append(`
                    <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4 edit-banners" data-id="` + banners.id + `">
                        <div class="card">
                            <div class="position-relative">
                            <a href="javascript:void(0)">		
                                ${content}						
                            </a>
                            <span class="badge badge-pill badge-theme-1 position-absolute badge-top-` + banners.align + ` font-` + banners.color +`">` + banners.button_text + `</span></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <a href="javascript:void(0)">
                                            <p class="list-item-heading pt-1">` + banners.title + `<br><span class="text-small">` + banners.subtitle + `</span></p>
                                        </a>
                                        <footer>
                                            <p class=" text-small mb-0 font-weight-light text-truncate">` + banners.description + `</p>
                                        </footer>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            });
        } */

    $("#checkAll").click(function(){
        $('.checkbox-allowed').not(this).prop('checked', this.checked);
    });

    function listnersbanners() {

        // Ao clicar no adicionar metodo
        $(".add-new-banners").off("click");
        $(".add-new-banners").on("click", function() {

            // Alterar o titulo do modal
           

            cleanEditor();

            $(".remove-banners").hide();

            $("[name='align']").prop('checked', false);

            $("[name='color']").prop('checked', false);

            $("#banner-image").slim('remove');

            // Retirar id do botao
            $(".save-banner").data("id", "");

            $("#big-banners-modal").modal("show");
        });

        //Ao clicar na paginação
       /*  $("body").off("click", ".page-link");
        $("body").on("click", ".page-link", function () {

            //Definir a nova pagina
            page = $(this).data("page");

            // fazer scroll para cima smooth
            window.scroll({top: 0, behavior: "smooth"});

            //Recarregar os dados da api
            initBanners();
        }) */

        //ao mudar lingua
        $(".btns-languages").on("click", function() {
            let text = $(this).attr('data-name');
            $('#c_lang').text(text);           
        });

         // Dropdown de mudar o numero de items na página
         $(".length-link").off("click");
            $(".length-link").on("click", function() {

                limit  = $(this).data("length");
                page   = 1;

                $(".news-lenght-menu").text(limit);
                initBanners();
            });

            // Dropdown de mudar a ordenação dos items
            $(".order-menu").off("click");
            $(".order-menu").on("click", function() {

                order   = $(this).data("order");
                page    = 1;

                $(".clients-order-menu").text($(this).text());
                initBanners();
            });

            $(".search-button").off("click");
            $(".search-button").on("click", function() {

                search = $(".search-sm input").val();
                initBanners();
            });

            $('.search-sm input').unbind( "enterKey" );
            $('.search-sm input').bind("enterKey",function(e) {

                search = $(".search-sm input").val();
                initBanners();
            });

            $('.search-sm input').keyup(function(e) {

                if (e.keyCode == 13) {

                    $(this).trigger("enterKey");
                }
            });

            $(".change_active_status").off("click");
            $(".change_active_status").on("click", function() {

                let id  = $(this).attr("data-id");

                $.ajax({
                    url: "/api/bannersActive/" + id,
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

                            initBanners()

                            // Não deixar a função executar mais
                            return;
                        }                       
                        
                        // Obter dados novos do servidor
                        initBanners();


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

        // Ao clicar no editar
        $(".edit-banners").off("click");
        $(".edit-banners").on("click", function() {

            cleanEditor();

            // Alterar o titulo do modal
          

            let id = $(this).data("id");

            // Adicionar o id ao botao de salvar
            $(".save-banner").data("id", id);

            $(".remove-banners").show();

            // Introduzir os dados no modal
            $.get("/api/banners/" + id, function(response) {
                
                $("[name='align']").prop('checked', false);

                $("[name='color']").prop('checked', false);

                let banner_data = response.data;
                const video = document.getElementById('video');
                const videoSource = document.createElement('source');

                $.each(banner_data, function(key, value) {

                    if (key == "align" ) {

                        $('#align-' + value + '-new').prop('checked', true);

                    } else if (key == "color") {

                        $('#color-' + value + '-new').prop('checked', true);
                        
                    // }else if (key == "is_active_btn_txt") {

                    //     $("#is_active_btn_txt").prop('checked', (value == "1"));

                    }else if (key == "active") {

                        $("#active").prop('checked', (value == "1"));

                    }else {

                        $("#big-banners-modal [name='" + key + "']").val(value);
                    }
                });
             
                if(banner_data.video != null)
                {
                    if (banner_data.video.length > 1 && banner_data.photo.length == 0) {

                        videoSource.setAttribute('src', banner_data.video);
                        video.appendChild(videoSource);
                        video.load();
                        video.play();     
                    


                        $('[href="#banners-image"]').removeClass("active");
                        $('[href="#banners-video"]').addClass("active");
                        $('#banners-image').removeClass("active");
                        
               
                        $('#banners-video').tab('show')
                            
                        

                    } else {

                        if(banner_data.video.length > 1){
                            videoSource.setAttribute('src', "");
                            video.appendChild(videoSource);
                            video.load();
                            video.play();
                        }
                        $('[href="#banners-image"]').addClass("active");
                        $('[href="#banners-video"]').removeClass("active");
                        $('#banners-image').addClass("active");
                        $('#banners-video').removeClass("active");
                    }
                }

                if(response.data.photo){                 
                    $("#banner-image").slim('load', response.data.photo + "?cache=" + new Date().getTime(), { blockPush : true }, function(error, data) { });
                }

                // Abrir o modal de editar
                $("#big-banners-modal").modal("show");
            });
        });

        //Ao clicar no eliminar
        $(".remove-banners").off("click");
        $(".remove-banners").on("click", function() {

            let id = $(".save-banner").data("id");

            removeBanner(id);

            $("#big-banners-modal").modal("hide");


        });

        // Guardar o método de envio
        $(".save-banner").off("click");
        $(".save-banner").on("click", function() {

            // Vereficar se vamos guardar ou editar
            let id = $(this).data("id");
            let data = $("#big-banners-modal form").serialize();
            
            editbanners(id, data);

            cleanEditor();

            $("#big-banners-modal").modal("hide");

            // Retirar o id do data-id para uma proxima ação
            $(this).data("id", "");
        });
    }

    /* function pagination_template(page, pages) {

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
    } */

    // Eliminar a método de envio
    function removebanners(id) {

        $.confirm({
            title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
            theme: "supervan",
            content: '{{ ucfirst($translations["backoffice"]["confirm_message_remove_banner"]) }}',
            buttons: {

                Sim: function() {
                    $.ajax({
                        url: "/api/banners/" + id,
                        // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                        // De texto, etc e em alguns servidores pode dar erro
                        type: "DELETE",
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

                            // Obter dados novos do servidor
                            initBanners();
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

                },
                Não: {}
            }
        });
    }

    function cleanEditor() {

        $("#big-banners-modal form").trigger("reset");
    }

    function editbanners(id = "", data) {

        let slim_data 	        = $("#banner-image").slim('data')[0];
        let photo_path 	        = "";
        let input 		        = document.getElementById('file-input');
        
        if (slim_data.server) {
            
            photo_path = "&photo=" + slim_data.server;
        }
        

        if ($('[href="#banners-video"]').hasClass("active") && uploaded_video !== null && input.value != "") {

            photo_path = "&video=" + uploaded_video + "&photo=";
        }

     
        $.ajax({
            url: "/api/banners/" + id,
            type: "POST",
            data: data + photo_path,
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

                // Obter dados novos do servidor
                initBanners();

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

    function videoUploadListners() {

        const input = document.getElementById('file-input');
        const video = document.getElementById('video');
        const maxFileSize = 10485760; // 10MB
        const videoSource = document.createElement('source');

        input.addEventListener('change', function() {

            const files = this.files || [];

            if (!files.length) return;

            if (files[0].size > maxFileSize) {

                alert("Ficheiro demasiado grande!");
                input.value = "";
                return;
            }
            
            const reader = new FileReader();

            reader.onload = function (e) {
                videoSource.setAttribute('src', e.target.result);
                video.appendChild(videoSource);
                video.load();
                video.play();
            };
            
            reader.onprogress = function (e) {
                console.log('progress: ', Math.round((e.loaded * 100) / e.total));
            };
            
            reader.readAsDataURL(files[0]);

            // Upload do video
            var formData = new FormData();
            formData.append('file', files[0]);

            $.ajax({
                type: "POST",
                url: '/api/image/dropzone?not_product_gallery=true&folder=banners',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                dataType: "json",
                success: function (response) {

                    if (response.success) {

                        uploaded_video = response.data.path;

                    } else {							
                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: response.message,
                        });
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {

                    console.log(thrownError);

                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });
                }
            });
        });
    }
    
    // O callback serve para ser chamado depois de as linguas carregarem
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

};

</script>
@endsection
