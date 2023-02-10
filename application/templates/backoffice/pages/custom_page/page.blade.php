@extends('layouts.master')
@section('content')
<main class="default-transition pt-5 mb-5 collapsable-main no-load">
	<div class="p-desktop-5">
		<div class="row">
			<div class="col-md-12 mb-8">
				<div class="col-12">
					<h1>{{ ucfirst($translations["backoffice"]["title_edit_page"]) }}</h1>
                    
					<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
						<ol class="breadcrumb pt-0">
							<li class="breadcrumb-item"><a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a></li>
							<li class="breadcrumb-item"><a href="/adm/custom_page">{{ ucfirst($translations["backoffice"]["custom_page_title"]) }}</a></li>
							<li class="breadcrumb-item active" aria-current="page">{{ ucfirst($translations["backoffice"]["title_edit_page"]) }}</li>
						</ol>
					</nav>
                    <div class="btn-group top-right-button-container">                       
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
				<form id="custom_page_form">
					<div class="contact-form clearfix">
						<div class="row">
							<div class="col-md-12 col-xl-8 col-sm-12 col-xs-12 mb-3">
								<div class="card">
									<div class="card-body">
										<h5><i class="simple-icon-notebook mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_product_basic_informations"]) }}</h5>
										<hr>
                                        <div class="row">                                         
                                                <div class="form-group mt-4 col-12"><label class="form-group has-float-label"> <input name="title" id="title_x" type="text" autocomplete="off" class="form-control"> <span>{{ ucfirst($translations["backoffice"]["name_form_pages"]) }}</span> </label> </div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-6">
                                                <h5>{{ ucfirst($translations["backoffice"]["custom_page_image_left"]) }}</h5>
                                                <hr>
                                                <div id="photo"></div>                                                
                                            </div>
                                            <div class="col-6">
                                                <h5>{{ ucfirst($translations["backoffice"]["custom_page_image_right"]) }}</h5>
                                                <hr>
                                                <div id="photo_2"></div>                                                
                                            </div>
                                        </div>                                        
										<div class="row mt-5">
                                                <div class="col-12 mt-3">
                                                    <ul class="card-header pl-0 pb-0 nav nav-tabs step-anchor tproduto">
                                                        <li class="nav-item active pr-2">
                                                            <a id="first-tab" data-toggle="tab" href="#first" role="tab" class="nav-link active pl-0 font-weight-700" aria-controls="first" aria-selected="true">{{ ucfirst($translations["backoffice"]["edit_product_fill_description"]) }} <br><small>Tab principal</small></a>
                                                        </li>                                                  
                                                    </ul>
												<div class="card-body p-0 pt-3">
													<div class="tab-content">
														<div class="tab-pane fade active show" id="first" role="tabpanel" aria-labelledby="first-tab"><label class="form-group ckeditor has-float-label"> <textarea name="details" rows="4" class="c-editor w-100"></textarea> </label> </div>
														<div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab"><label class="form-group ckeditor has-float-label"> <textarea name="policy" rows="4" class="c-editor w-100"></textarea> </label> </div>
													</div>
												</div>
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
                                            <button type="button" data-action="save" class="btn btn-outline-info btn-xs mt-2 mr-2">{{ ucfirst($translations["backoffice"]["edit_product_btn_save"]) }}</button>                                           
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
<div class="modal fade modal-right select-from-library" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{ ucfirst($translations["backoffice"]["product_advanced_new_title"]) }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> 
			</div>
			<div class="modal-body">
				<div id="infoAdvancedProduct">
					<div class="row">
						<div class="col-12 col-xl-12 mt-3 block"><label class="form-group has-float-label"> <input name="advanced_name" type="text" placeholder="XL, branco, etc" autocomplete="off" class="form-control"> <span>{{ ucfirst($translations["backoffice"]["product_advanced_fill_description"]) }}</span> </label></div>
					</div>
					<div class="row">
						<div class="col-12 col-xl-6 mt-3 block"><label class="form-group has-float-label"> <input name="advanced_stock" type="number" autocomplete="off" class="form-control"> <span>{{ ucfirst($translations["backoffice"]["product_advanced_fill_stock"]) }}</span> </label> </div>
						<div class="col-12 col-xl-6 mt-3 block"><label class="form-group has-float-label"> <input name="advanced_current_price" type="number" autocomplete="off" class="form-control"> <span>{{ ucfirst($translations["backoffice"]["product_advanced_fill_price"]) }}</span> </label></div>
					</div>
				</div>
				<hr>
				<div class="list disable-text-selection">
					<div class="row"></div>
				</div>
			</div>
			<div class="modal-footer"> <button type="button" class="btn btn-outline-primary" data-dismiss="modal">{{ ucfirst($translations["backoffice"]["product_advanced_new_btn_close"]) }}</button> <button type="button" class="btn btn-primary" data-dismiss="modal" data-action="saveAdvancedProduct">{{ ucfirst($translations["backoffice"]["product_advanced_new_btn_save"]) }} </button> </div>
		</div>
	</div>
</div>
<div class="modal modal-fullscreen fade" id="editImageModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-fullscreen" role="document">
		<div class="modal-content modal-content-fullscreen">
			<div id="tui-image-editor"></div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
    <!-- START SCRIPTS -->
    <script src="/static/backoffice/javascript/jodit_editor_js/jodit.js"></script>
    <script src="/static/backoffice/javascript/jodit_editor_js/app.js"></script>
    <script src="/static/backoffice/javascript/jodit_editor_js/prism.js"></script>
    <link rel="stylesheet" href="/static/backoffice/css/jodit_editor_css/app.css"/>
    <link rel="stylesheet" href="/static/backoffice/css/jodit_editor_css/jodit.css"/>
    <link rel="stylesheet" href="/static/backoffice/css/jodit_editor_css/prism.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.13.0/Sortable.min.js"></script>
    <link type="text/css" href="//uicdn.toast.com/tui-color-picker/v2.2.6/tui-color-picker.css" rel="stylesheet">
    <link rel="stylesheet" href="https://uicdn.toast.com/tui-image-editor/v3.10.0/tui-image-editor.css">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.3.1/fabric.min.js"></script>
    <script type="text/javascript" src="//uicdn.toast.com/tui.code-snippet/v1.5.0/tui-code-snippet.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>
    <script type="text/javascript" src="//uicdn.toast.com/tui-color-picker/v2.2.6/tui-color-picker.js"></script>
    <script src="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.js"></script>

    <script>
        var editors = [];

        let idsImgAdvancedProduct = [];
        let getSelectedIdsImgAdvancedProduct = [];

        let imageEditorInstance = null;
        let imageThatIsBeingEdited = null;
        let type = null;

        //Iniciar o objeto das linguas disponiveis na loja
        var translations = {};

        // Iniciar o plugin de imagens Slim
        $("#photo").slim({
			
            push: true,
            service: '/api/image/slim',
            label: 'Carregar',
            statusUploadSuccess: 'Guardado!',
            
            buttonCancelLabel: 'Cancelar',
            buttonConfirmLabel: 'Confirmar',
            buttonEditLabel: 'Editar',
            buttonDownloadLabel: 'Download',
            buttonUploadLabel: 'Upload',
            
            ratio: '3:4',  // ratio da imagem
            buttonCancelTitle: 'Cancelar',
            buttonConfirmTitle: 'Confirmar',
            buttonEditTitle: 'Editar',
            buttonDownloadTitle: 'Download',
            buttonUploadTitle: 'Upload',
            buttonRotateTitle: 'Rodar',
            buttonRemoveTitle: 'Remover',
            
            meta: {
                
                folder: 'custom_page'
            }
        });

        $("#photo_2").slim({
			
            push: true,
            service: '/api/image/slim',
            label: 'Carregar',
            statusUploadSuccess: 'Guardado!',
            
            buttonCancelLabel: 'Cancelar',
            buttonConfirmLabel: 'Confirmar',
            buttonEditLabel: 'Editar',
            buttonDownloadLabel: 'Download',
            buttonUploadLabel: 'Upload',
            
            ratio: '3:4',  // ratio da imagem
            buttonCancelTitle: 'Cancelar',
            buttonConfirmTitle: 'Confirmar',
            buttonEditTitle: 'Editar',
            buttonDownloadTitle: 'Download',
            buttonUploadTitle: 'Upload',
            buttonRotateTitle: 'Rodar',
            buttonRemoveTitle: 'Remover',
            
            meta: {
                
                folder: 'custom_page'
            }
        });

        $.ajax({
            url: "/api/translations/",
            dataType: "json",
            success: function (response) {
                if (!response.success) {
                    console.error(response);

                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}'
                    });

                    //Quando dá erro, sai
                    return;
                }

                translations = response.data
                init();
            },
            error: function (jqXHR, textStatus, errorThrown) {

                console.log(textStatus, errorThrown);

                $.alert({
                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                    theme: "supervan",
                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}'
                });
            }
        })

        /*
         *	Init ckeditor
         */

        $('.c-editor').each(function () {

            editors[$(this).attr("name")] = new Jodit(this, {

                textIcons: false,
                iframe: false,
                height: 300,
                toolbarAdaptive: false,
                defaultMode: Jodit.MODE_WYSIWYG,
                language: "pt_br",
                buttons: "source,|,bold,strikethrough,underline,italic,eraser,|,ul,ol,|,outdent,indent,|,font,fontsize,brush,paragraph,|,image,file,video,table,link,|,align,undo,redo,\n,|,hr,symbol,fullsize",

                observer: {
                    timeout: 100
                },
                uploader: {
                    url: '/adm/ckeditor?action=fileUpload',
                },
                commandToHotkeys: {
                    openreplacedialog: 'ctrl+p'
                },
            });
        })

        function init() {


            // Vamos buscar o url pretendido para ver se a página vai editar ou adicionar novo produto
            var page = new RegExp('^/adm/custom_page/.*');
            

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

                    // Listners para os botões de guardar etc
                   
                    listners(wildcard);


                    //Atribuir o id ao campo "save"
                    $('[data-action="save"]').data("id", wildcard)

                    //Atribuir id do produto ao butao saveAttribute
                    $('[data-action="saveAttribute"]').data("idProduct", wildcard)

                    //Atribuir id do produto ao butao saveAttribute
                    $('[data-action="saveDiscount"]').data("idProduct", wildcard)
                }
            }
        }

        //#################################### Produtos ####################################################
        function load(id) {

            $.ajax({
                url: "/api/custom_page/" + id,
                type: "GET",
                dataType: "json",
                success: function (response) {

                    console.log(response);

                    if (!response.success) {

                        // Output do erro
                        console.error(response);

                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}'
                        });

                        // Não deixar a função executar mais
                        return;
                    }

                    type = response.data.type

                    // Procurar todos os elementos por name="" e meter os dados da api
                    $.each(response.data, function (key, value) {

                        if (response.data.details == null) {

                            response.data.details = "";
                        }

                        switch (key) {

                            case "details":
                                if ((typeof value == 'string') || (value instanceof String)) {

                                    editors["details"].setElementValue(value);
                                }
                                break;

                            case "policy":
                                if ((typeof value == 'string') || (value instanceof String)) {

                                    editors["policy"].setElementValue(value);
                                }
                                break;

                            case "title":

                                // Atualizar o select do status
                                $(`#title_x`).val(value);

                                break;

                            case "photo":

                                if (value != null && value.length > 0) {
                                    // Carregar imagem do slide
                                    $("#photo").slim('load',  value, { blockPush : true }, function(error, data) { });
                                }
                                break;

                            case "photo_2":

                                if (value != null && value.length > 0) {
                                    // Carregar imagem do slide
                                    $("#photo_2").slim('load',  value, { blockPush : true }, function(error, data) { });
                                }
                                break;

                            default:
                                $(`[name="` + key + `"]`).val(value);
                                break;
                        }
                    });

                    //Carregar as linguas
                    languages(response.data.related, {lang: response.data.lang, status: response.data.status});

                    //Ficar tipo do produto selecionado
                    $(`.type${response.data.type}`).addClass("active")
                    $(`.type-pane${response.data.type}`).addClass("active show")

                    // Refresh do plugin das etiquetas
                    $('[name="labels"]').tagsinput({maxTags:1});

                    // Fill dos valores iniciais
                    fill();
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

        function save(id = "", data) {

            data.draft = 0;
            data.title = $('#title_x').val();
            data.featured = ($("#featuredSwitch").prop('checked') ? "1" : "0");

            var fd = new FormData();    
            if(data.photo != undefined) {
                fd.append( 'photo', data.photo );
            }         
            if(data.photo_2 != undefined) {
                fd.append( 'photo_2', data.photo_2 );
            }

            fd.append( 'draft', data.draft);
            fd.append( 'details', data.details);
            fd.append( 'title', data.title);
            fd.append( 'policy', data.policy);


            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_product_save"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/custom_page/" + id,
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
                                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                                    });
                                    // Não deixar a função executar mais
                                    return;
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {

                                console.log(textStatus, errorThrown);
                                // @TODO:
                                // Mostar mensagem de erro
                            }
                        });

                    },
                    Não: {}
                }
            });
        }        

        // Obter as informações da página
        function getPageData() {

            let data = {};

            console.log('test', $('#custom_page_form').serializeArray());

            // Estamos a utilizar a função serialize para todos os inputs dento de #custom_page_form
            $.each($('#custom_page_form').serializeArray(), function () {
                data[this.name] = this.value;
            });

            // Adicionar a imagem da página
            let slim_photo = $("#photo").slim('data')[0];
            let slim_photo_2 = $("#photo_2").slim('data')[0];
           
            if (slim_photo.server) {
                
                data.photo = slim_photo.server;
            }
            if (slim_photo_2.server) {
                
                data.photo_2 = slim_photo_2.server;
            }


            if (data["slim[]"] !== undefined) {

                // Eliminar o atributo slim[] das informações da página
                delete data["slim[]"];
            }

            return data;
        }

        //Funcao para remover um produto
        function removeProduct(id) {
            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_product_remove"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/custom_page/" + id,
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
                                window.location.replace("/adm/custom_page/");
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


        //################################################################################################################
        function languages(related, select_language) {

            //Separamos para depois adicionar por ordem de ativo ou nao
            let active = [];
            let non_active = [];

            $.each(translations, function (key, language) {

                if (language.code === select_language.lang) {
                    language.item_id = null;
                    language.status = select_language.status;

                    active.push(language);

                    delete translations[key];
                } else {
                    $.each(related, function (sub_key, active_language) {
                     
                        if (active_language.lang == language.code) {
                            //Guardar o id do produto com a lingua x
                            language.item_id = active_language.id;
                            language.status = active_language.status;

                            active.push(language);

                            delete translations[key];
                        }
                    });
                }
            });

            // linguas que restaram do codigo acima
            $.each(translations, function (key, language) {
                if (language !== undefined) {         
                    non_active.push(language);
                }
            });
     

            //Adicionar primeiro as linguas ativas
            $.each(active, function (key, lang) {

                let button = "";               
                if (lang.item_id == null) {
                    //Se o lang.item_id for nulo, quer dizer que é a noticia que temos actualmente carregada
                    button = `<a href="javascript:void(0)" style="min-width: 80px" class="btn btn-success btn-xs float-right">{{ ucfirst($translations["backoffice"]["language_btn_current"]) }}</a>`;
                    $(".language-selected").append(`
                        ` + lang.name + `
                    `);
                } else {
                    button = `<a href="/adm/custom_page/` + lang.item_id + `" style="min-width: 80px" class="btn btn-info btn-xs float-right">{{ ucfirst($translations["backoffice"]["language_btn_see"]) }}</a>`;
                }

                let status = "";

                switch (lang.status) {
                    case "0":
                        status = '<span class="sub-dot m1-2 red"></span>';
                        break;
                    case "1":
                        status = '<span class="sub-dot m1-2 orange"></span>';
                        break;
                    case  "2":
                        status = '<span class="sub-dot m1-2 green"></span>';
                        break
                }

                $(".languages-list").append(`
                    <tr>
                        <td><span>` + lang.name + `</span> ` + status + `</td>
                        <td></td>
                        <td>` + button + `</td>
                    </tr>
                `);
            })
            //Adicionar as linguas não ativas
            $.each(non_active, function (key, lang) {
                $(".languages-list").append(`
                        <tr>
                            <td class="text-muted">` + lang.name + `</td>
                            <td></td>
                            <td><a href="javascript:void(0)" data-lang="` + lang.code + `" data-lang-name="` + lang.name + `" style="min-width: 80px" class="btn btn-light btn-xs float-right create-other-language-button">{{ ucfirst($translations["backoffice"]["language_btn_create"]) }}</a></td>
                        </tr>
                    `);
            })
        }

        function createAnotherLanguage(lang, name) {
            let id = $("[data-action='save']").data("id");

            $.confirm({
                title: name,
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["language_btn_see"]) }}' ,
                buttons: {
                    Sim: function () {
                        $.ajax({
                            url: "/api/custom_page/",
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
                                    // Não deixar a função executar mais
                                    return;
                                }
                                // Rederecionar para a página da nova noticia
                                window.location.replace("/adm/custom_page/" + response.data.id);
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
            })
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

        function listners(product_id) {

            $('[data-action="save"]').on("click", function () {                

                let data = getPageData();

                // Ao clicar no botao de guardar, vamos buscar o id do produto guardado no elemento
                save($('[data-action="save"]').data("id"), data);
            });

            //guarda tipo de producto (ultimo a ser selecionado)
            $(".typeProduct").on("click", function () {
                type = $(this).data("type");
                console.log("tipo", type)
            })

            $("body").on('click', ".tui-image-editor-save-btn", function () {

                var dataURL = imageEditorInstance.toDataURL();
                var blob = null;

                blob = base64ToBlob(dataURL);
                blob.name = "image.png";

                var fd = new FormData();
                fd.append('fname', 'image.png');
                fd.append('data', blob);

                // Fechar o modal do editor
                $("#editImageModal").modal("hide");

                $.ajax({
                    type: 'POST',
                    url: '/api/image/edit?new_file_name=' + encodeURIComponent(imageThatIsBeingEdited),
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (image_path) {

                        // Alterar a imagem do dropzone
                        setTimeout(function () {

                            console.log($("img[src='" + image_path + "']"));

                            $("img[src='" + image_path + "']").attr("src", image_path + "?nocache=" + (new Date().getTime()));

                        }, 200);
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
                //saveAs(blob, imageThatIsBeingEdited);
            });

            $('.openModal').on("click", function () {
                //limpa os inputs
                clearInputsAdvancedProduct()
                modalAdvancedProducuct(product_id);

                $('[data-action="saveAdvancedProduct"]').attr("data-id", null)

                idsImgAdvancedProduct = []

            });

            //Listener para abrir galeria do produto composto já criado
            $("body").on("click", '.openModalAdvancedProduct', function () {
                //limpa os inputs
                clearInputsAdvancedProduct()
                //Abre o ModalAdvancedProducuct com todas as imagens
                modalAdvancedProducuct(product_id)
                //guarda o id do advancedProduct
                let idAdvancedProduct = $(this).data('id')
                getOneAdvancedProduct(idAdvancedProduct);
                //limpa o array
                idsImgAdvancedProduct = []

                $('[data-action="saveAdvancedProduct"]').attr("data-id", $(this).data("id"))
            });

            //Listener para selecao de imagens
            $("body").on("click", '.imgAdvancedProduct', function () {
                //Verifica se a imagem tem a class imgSelected
                const selected = $(this).hasClass("imgSelected");
                let idImg


                //se tiver vai buscar o id da imagem para o remover do array e remove tambem a class imgSelected
                if (selected) {
                    idImg = $(this).data("id")
                    $(this).removeClass("imgSelected")
                    idsImgAdvancedProduct.splice($.inArray(idImg, idsImgAdvancedProduct), 1)

                    //Se nao tiver vai buscar o id da imagem adiciona ao array e adiciona a class imgSelected
                } else {

                    idImg = $(this).data("id")
                    $(this).addClass("imgSelected")
                    idsImgAdvancedProduct.push(idImg)

                }

            });

            $('[data-action="delete"]').on("click", function () {

                let idProduct = $('[data-action="save"]').data("id");
                console.log(idProduct)
                removeProduct(idProduct);

            });

            $('[data-action="saveAttribute"]').on("click", function () {

                let dataAttribute = getAttributes();

                if (dataAttribute !== false) {

                    //Salva o atributo
                    saveAttributes(dataAttribute);
                }
            });

            $('[data-action="saveDiscount"]').on("click", function () {

                let dataDiscount = getDiscount();

                if (dataDiscount !== false) {

                    //Salva o Desconto
                    saveDiscounts(dataDiscount);
                }
            });

            $('[data-action="saveAdvancedProduct"]').on("click", function () {

                let dataAdvancedProduct = getAdvancedProduct();

                let idAdvancedProduct = $(this).data("id")

                console.log("idAdvanced", idAdvancedProduct)

                //Salva o Desconto
                saveAdvancedProduct(idAdvancedProduct, dataAdvancedProduct);
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


            //Evento onClick no body, quando o click for num elemento com a classe "buttonDeleteAttributes" (elemina atributo do HTML e do arrayAttributes)
            $("body").on("click", '.buttonDeleteAttributes', function () {
                removeAtrribute(this);

            });

            //Evento onClick no body, quando o click for num elemento com a classe "buttonDeleteDiscount" (elemina atributo do HTML e do arrayAttributes)
            $("body").on("click", '.buttonDeleteDiscount', function () {
                removeDiscount(this);

            });

            //Evento onClick no body, quando o click for num elemento com a classe "buttonDeleteAdvancedProduct" (elemina atributo do HTML e do arrayAttributes)
            $("body").on("click", '.buttonDeleteAdvancedProduct', function () {
                removeAdvancedProduct(this);

            });

            //Ao clicar no butao nova lingua
            $("body").on("click", ".create-other-language-button", function () {

                let lang = $(this).data("lang");
                let lang_name = $(this).data("lang_name");

                createAnotherLanguage(lang, lang_name)
            })

            // Slug automatica atraves do input do nome do produto
            $("[name='name']").on("input", function () {

                $("[name='slug']").val(slug($(this).val()));

                fill();
            });

            $("[name='slug']").on("input", function () {

                $("[name='slug']").val(slug($(this).val()));
            });

            // A cada 500ms vamos executar a função fill
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

        // Função para alterar valores dinamicamentes na página
        function fill() {
            $("[data-fill='details']").html($("[name='details']").val().replace(/(<([^>]+)>)/gi, ""));
        }

        function imageEditor(image) {

            // Abrir o modal
            $("#editImageModal").modal("show");

            const FileSaver = require('file-saver'); //to download edited image to local. Use after npm install file-saver
            const blackTheme = require('./js/theme/black-theme.js');
            imageEditorInstance = new tui.ImageEditor(document.querySelector('#tui-image-editor'), {
                includeUI: {
                    loadImage: {
                        path: image,
                        name: image,
                    },
                    theme: blackTheme, // or whiteTheme
                    menuBarPosition: 'bottom',
                },
                cssMaxWidth: 1000,
                cssMaxHeight: 1000,
                selectionStyle: {
                    cornerSize: 20,
                    rotatingPointOffset: 70,
                },
            });

            $('.tui-image-editor-header-buttons .tui-image-editor-download-btn').replaceWith('<button style="background-color: #fff; border: 1px solid #ddd; color: #222;" class="tui-image-editor-save-btn" >{{ ucfirst($translations["backoffice"]["editor_image_save"]) }}</button>');
            $('.tui-image-editor-header-buttons').children().first().replaceWith('<button class="tui-image-editor-close-btn" >{{ ucfirst($translations["backoffice"]["editor_image_cancel"]) }}</button>');


            $(".tui-image-editor-header-logo img").attr("src", "/static/images/criativatek.svg").css("height", "40px");
        }

        function dropzoneGallery(gallery_id, files) {

            // Iniciar o upload de imagens
            $(".dropzone").dropzone({

                addRemoveLinks: false,
                previewTemplate: template(),
                url: "/api/image/dropzone_gallery",
                params: {
                    gallery_id: gallery_id
                },
                success: function (file, response, action) {

                    response = JSON.parse(response);

                    if (response.success) {

                        this.defaultOptions.success(file);

                    } else {
                        console.log(response);
                        this.defaultOptions.error(file, response.message);
                    }
                },
                removedfile: function (file) {

                    if (window.initiating_dropzone) {

                        if (file.previewElement !== undefined && file.previewElement.parentNode != null) {

                            file.previewElement.parentNode.removeChild(file.previewElement);
                        }

                        return false;
                    }

                    var file_id = file.id;

                    if (file.id == undefined) {

                        file.previewElement.parentNode.removeChild(file.previewElement);
                        return true;
                    }

                    $.confirm({
                        title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                        content: '{{ ucfirst($translations["backoffice"]["confirm_delete_file"]) }}',
                        theme: 'supervan',
                        buttons: {
                            yes: {
                                keys: ['enter'],
                                text: "{{ ucfirst($translations["backoffice"]["yes"]) }}",
                                action: function () {

                                    $.ajax({
                                        url: "/api/image/dropzone_gallery/" + file_id,
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

                                    file.previewElement.parentNode.removeChild(file.previewElement);
                                }
                            },
                            no: {
                                keys: ['esc'],
                                text: "{{ ucfirst($translations["backoffice"]["no"]) }}",
                                action: function () {
                                }
                            },
                        }
                    });
                },

                init: function () {

                    let thisDropzone = this;
                    window.dropzone_instance = thisDropzone;

                    let sortable_dropzone = new Sortable($(".dropzone").get(0), {
                        draggable: '.dz-preview',
                        dataIdAttr: "d-id",
                        store: {
                            set: function (sortable) {
                                var order = sortable.toArray();
                                $.ajax({
                                    url: "/api/image/order_gallery?ids=" + order.join(","),
                                    type: "PUT",
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
                            }
                        }
                    });

                    this.on("complete", function (data) {

                        let file = [];

                        if (data.hasOwnProperty('xhr')) {

                            let server_data = JSON.parse(data.xhr.response);

                            if (server_data.data.path != undefined) {

                                setTimeout(() => {

                                    data.previewElement.parentNode.removeChild(data.previewElement);

                                    file = server_data.data;

                                    let mockFile = {
                                        id: file.id,
                                        name: file.name,
                                        path: file.path,
                                        size: file.size
                                    };

                                    let extension = filetype(file.path);

                                    thisDropzone.emit("addedfile", mockFile);
                                    thisDropzone.emit("thumbnail", mockFile, (thumbnail(extension) === false) ? file.path : thumbnail(extension));
                                    thisDropzone.files.push(mockFile);

                                }, 1000);
                            }
                        }
                    });

                    this.on("addedfile", function (data) {

                        $(data.previewElement).attr("d-id", data.id);

                        // Download button
                        $(data.previewElement).find(".download").data("link", data.path);
                        $(data.previewElement).find(".image-editor").data("link", data.path);
                        $(data.previewElement).find(".download").data("name", data.name + "." + data.extension);

                        let extension = filetype(data.path || data.name);
                        let image = thumbnail(extension);

                        if (extension == "image" || extension == "video" || extension == "audio") {

                            $(data.previewElement).find(".play").show();

                            $(data.previewElement).find(".play").on("click", function () {

                                window.open(data.path, '_blank');
                            });

                        } else {

                            $(data.previewElement).find(".play").hide();
                        }

                        $(data.previewElement).find("[data-dz-name]").text(data.name);

                        if (image !== false) {

                            $(data.previewElement).find(".img-thumbnail").attr("src", image);
                            $(data.previewElement).find(".img-thumbnail").css("object-fit", "contain");

                        } else {

                            $(data.previewElement).find(".img-thumbnail").css("object-fit", "cover");
                        }
                    });

                    if (files.length > 0) {

                        $.each(files, function (key, file) {

                            let mockFile = {
                                id: file.id,
                                name: file.name,
                                path: file.path,
                                size: file.size
                            };

                            let extension = filetype(file.path);

                            thisDropzone.emit("addedfile", mockFile);
                            thisDropzone.emit("thumbnail", mockFile, (thumbnail(extension) === false) ? file.path + "?nocache=" + (new Date().getTime()) : thumbnail(extension));
                            thisDropzone.files.push(mockFile);
                        });
                    }

                    /*thisDropzone = this;
                    this.on("processing", function (file) {
                        
                        thisDropzone.options.url = "/adm/gallery?category=" + selected_category;
                    });
                    
                    
                    $.get("/adm/gallery/" + selected_category, function(response) {
                        
                        response = JSON.parse(response);	
                        
                        $.each(response, function(key, value) {
                            
                            var mockFile = {
                                name: "Anonyme",
                                size: 100
                            };
                            
                            thisDropzone.emit( "addedfile", mockFile );
                            thisDropzone.emit( "thumbnail", mockFile, value.photo_path);
                            thisDropzone.files.push( mockFile );
                        });
                    });*/
                }
            });
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

        function deleteFile(id) {

            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                content: '{{ ucfirst($translations["backoffice"]["confirm_delete_file"]) }}',
                theme: 'supervan',
                buttons: {
                    yes: {
                        keys: ['enter'],
                        text: '{{ ucfirst($translations["backoffice"]["yes"]) }}',
                        action: function () {

                            $.destroy('/api/files/' + id);
                        }
                    },
                    no: {
                        keys: ['esc'],
                        text: "{{ ucfirst($translations["backoffice"]["no"]) }}",
                        action: function () {
                        }
                    },
                }
            });
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

        function listToTree(data) {

            const ID_KEY = "id";
            const PARENT_KEY = "parent";
            const CHILDREN_KEY = "children";

            let item, id, parentId;
            let map = {};

            for (var i = 0; i < data.length; i++) {

                if (data[i][ID_KEY]) {

                    map[data[i][ID_KEY]] = data[i];
                    data[i][CHILDREN_KEY] = [];
                }
            }

            for (var i = 0; i < data.length; i++) {

                if (data[i][PARENT_KEY]) {

                    if (map[data[i][PARENT_KEY]]) {

                        map[data[i][PARENT_KEY]][CHILDREN_KEY].push(data[i]);   // Adicionar o filho ao pai
                        data.splice(i, 1);                                    // Remover a categoria do root
                        i--;                                                    // Corrigir a iteração

                    } else {

                        data[i][PARENT_KEY] = 0;
                    }
                }
            }
            ;

            return data;
        }

        function clearInputsAdvancedProduct() {
            $('[name="advanced_name"]').val("")
            $('[name="advanced_stock"]').val("")
            $('[name="advanced_current_price"]').val("")

        }

    </script>
@endsection