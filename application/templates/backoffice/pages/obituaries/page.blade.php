@extends('layouts.master')
@section('content')
<main class="default-transition pt-5 mb-5 collapsable-main no-load">
	<div class="p-desktop-5">
		<div class="row">
			<div class="col-md-12 mb-8">
				<div class="col-12">
					<h1>Editar Obituário</h1>
					<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
						<ol class="breadcrumb pt-0">
							<li class="breadcrumb-item"><a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a></li>
							<li class="breadcrumb-item"><a href="/adm/obituaries">Obituários</a></li>
							<li class="breadcrumb-item active" aria-current="page">Editar obituário</li>
						</ol>
					</nav>
                    <div class="top-right-button-container">
                        <button type="button" href="javascript:void(0)" onclick='javascript:window.location.assign("/adm/obituaries");' class="btn btn-outline-secondary">{{ ucfirst($translations["backoffice"]["edit_custom_btn_back"]) }}</button>
                    </div>
					<div class="separator mb-5"></div>
				</div>
				<form id="obituary-form">
					<div class="contact-form clearfix">
						<div class="row">
							<div class="col-md-12 col-xl-8 col-sm-12 col-xs-12 mb-3">
								<div class="card">
                                    <div class="card-body">
                                        <h5 class="mb-3"><i class="simple-icon-grid mr-2"></i>Dados gerais</h5>
                                            <div class="row mt-5">
											<div class="col-12"><label class="form-group has-float-label"> <input name="name" type="text" autocomplete="off" class="form-control"> <span>Editar obituário</span> </label> </div>
                                            <div class="col-12"><label class="form-group has-float-label"> <input name="location" type="text" autocomplete="off" class="form-control"> <span>Localização</span> </label> </div>
                                            <div class="col-12 col-lg-6"><label class="form-group has-float-label"> <input name="birthdate" type="date" autocomplete="off" class="form-control"> <span>Data de Nascimento</span> </label> </div>
                                            <div class="col-12 col-lg-6"><label class="form-group has-float-label"> <input name="date" type="date" autocomplete="off" class="form-control"> <span>Data de falecimento</span> </label> </div> 
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="card">
									<div class="card-body">
                                        <!-- <ul class="card-header pl-0 pb-0 nav nav-tabs step-anchor tproduto">
                                            <li class="nav-item active pr-2">
                                                <a id="first-tab" data-toggle="tab" href="#first" role="tab" class="nav-link active pl-0 font-weight-700" aria-controls="first" aria-selected="true">{{ ucfirst($translations["backoffice"]["edit_product_fill_description"]) }} <br><small>Tab principal</small></a>
                                            </li>
                                            <li class="nav-item pr-2">
                                                <a data-toggle="tab" href="#second" role="tab" class="nav-link pl-0 font-weight-700" aria-controls="second" aria-selected="false">{{ ucfirst($translations["backoffice"]["edit_product_fill_others"]) }} <br><small>Tab secundário</small></a>
                                            </li>
                                        </ul>
										<div class="row">
											<div class="col-12 mt-3">
												<div class="card-body p-0 pt-3">
													<div class="tab-content">
														<div class="tab-pane fade active show" id="first" role="tabpanel" aria-labelledby="first-tab"><label class="form-group ckeditor has-float-label"> <textarea name="details" rows="4" class="c-editor w-100"></textarea> </label> </div>
														<div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab"><label class="form-group ckeditor has-float-label"> <textarea name="policy" rows="4" class="c-editor w-100"></textarea> </label> </div>
													</div>
												</div>
											</div>
										</div> -->
                                        <h5 class="mb-3"><i class="simple-icon-notebook mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_product_fill_description"]) }}</h5>
                                        <label class="form-group ckeditor has-float-label">
                                            <textarea name="details" rows="20" class="c-editor w-100"></textarea>
                                        </label>
									</div>
								</div>
								<br>

                                <div class="card">
									<div class="card-body">
                                        <h5 class="mb-3"><i class="simple-icon-book-open mr-2"></i>Mais informações</h5>
                                        <ul class="card-header pl-0 pb-0 nav nav-tabs step-anchor tproduto">
                                            <li class="nav-item active pr-2">
                                                <a id="text1_title_tab" data-toggle="tab" href="#text1_title" role="tab" class="nav-link active pl-0 font-weight-700" aria-controls="text1_title" aria-selected="true">Título <br><small>Texto 1</small></a>
                                            </li>
                                            <li class="nav-item pr-2">
                                                <a id="text1_desc_tab" data-toggle="tab" href="#text1_desc" role="tab" class="nav-link pl-0 font-weight-700" aria-controls="text1_desc" aria-selected="false">Descrição <br><small>Texto 1</small></a>
                                            </li>
                                            <li class="nav-item pr-2">
                                                <a id="text2_title_tab" data-toggle="tab" href="#text2_title" role="tab" class="nav-link pl-0 font-weight-700" aria-controls="text2_title" aria-selected="false">Título <br><small>Texto 2</small></a>
                                            </li>
                                            <li class="nav-item pr-2">
                                                <a id="text2_desc_tab" data-toggle="tab" href="#text2_desc" role="tab" class="nav-link pl-0 font-weight-700" aria-controls="text2_desc" aria-selected="false">Descrição <br><small>Texto 2</small></a>
                                            </li>
                                            <li class="nav-item pr-2">
                                                <a id="text3_desc_tab" data-toggle="tab" href="#text3_desc" role="tab" class="nav-link pl-0 font-weight-700" aria-controls="text3_title" aria-selected="false">Título <br><small>Texto 3</small></a>
                                            </li>
                                            <li class="nav-item pr-2">
                                                <a id="text3_desc_tab" data-toggle="tab" href="#text3_desc" role="tab" class="nav-link pl-0 font-weight-700" aria-controls="text3_desc" aria-selected="false">Descrição <br><small>Texto 3</small></a>
                                            </li>
                                        </ul>
										<div class="row">
											<div class="col-12 mt-3">
												<div class="card-body p-0 pt-3">
													<div class="tab-content">
														<div class="tab-pane fade active show" id="text1_title" role="tabpanel" aria-labelledby="text1_title_tab"><label class="form-group ckeditor has-float-label"> <textarea name="text1_title" rows="4" class="c-editor w-100"></textarea> </label> </div>
														<div class="tab-pane fade" id="text1_desc" role="tabpanel" aria-labelledby="text1_desc_tab"><label class="form-group ckeditor has-float-label"> <textarea name="text1_description" rows="4" class="c-editor w-100"></textarea> </label> </div>
                                                        <div class="tab-pane fade" id="text2_title" role="tabpanel" aria-labelledby="text2_title_tab"><label class="form-group ckeditor has-float-label"> <textarea name="text2_title" rows="4" class="c-editor w-100"></textarea> </label> </div>
														<div class="tab-pane fade" id="text2_desc" role="tabpanel" aria-labelledby="text2_desc_tab"><label class="form-group ckeditor has-float-label"> <textarea name="text2_description" rows="4" class="c-editor w-100"></textarea> </label> </div>
                                                        <div class="tab-pane fade" id="text3_title" role="tabpanel" aria-labelledby="text3_title_tab"><label class="form-group ckeditor has-float-label"> <textarea name="text3_title" rows="4" class="c-editor w-100"></textarea> </label> </div>
														<div class="tab-pane fade" id="text3_desc" role="tabpanel" aria-labelledby="text3_desc_tab"><label class="form-group ckeditor has-float-label"> <textarea name="text3_description" rows="4" class="c-editor w-100"></textarea> </label> </div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
						
                                <br>
								<div class="card">
									<div class="card-body">
										<div class="w-100">
											<h5><i class="simple-icon-organization mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_product_seo_tags"]) }}</h5>
											<hr>
											<div class="form-group mt-4"><label class="form-group has-float-label"> <input name="slug" type="text" autocomplete="off" class="form-control"> <span>{{ ucfirst($translations["backoffice"]["edit_product_fill_url_friendly"]) }}</span> </label> </div>
											<div class="form-group mt-4"><label class="form-group has-float-label"> <input type="text" name="keywords" class="form-control"> <span>{{ ucfirst($translations["backoffice"]["edit_product_fill_tags"]) }}</span> </label> </div>
											<div class="row mt-2">
												<div id="seo_wrap" class="widget meta-boxes mt-3 col-12">
													<div class="widget-body">
														<div class="seo-preview">
															<span class="page-title-seo" data-fill="name"></span>
															<div class="page-url-seo ws-nm">
																<p>{{ URL }}{{ $selected_language->code }}/obituaries/<span data-fill="slug"></span></p>
															</div>
															<div class="ws-nm"><span style="color: #70757a;" data-fill="date"></span> <span data-fill="details" class="page-description-seo"></span></div>
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
											<button type="button" data-action="delete" class="btn btn-outline-danger btn-xs mt-2 mr-2">{{ ucfirst($translations["backoffice"]["edit_product_btn_remove"]) }}</button> 
                                            <button type="button" data-action="save" class="btn btn-outline-info btn-xs mt-2 mr-2">{{ ucfirst($translations["backoffice"]["edit_product_btn_save"]) }}</button>
											<div class="form-group mt-3">
												<label>{{ ucfirst($translations["backoffice"]["edit_product_fill_highlight"]) }}</label>
												<div class="custom-switch custom-switch-secondary mb-2 custom-switch-small"> <input class="custom-switch-input" id="featuredSwitch" type="checkbox"> <label rel="tooltip" title="Destacado na página principal" class="custom-switch-btn" for="featuredSwitch"></label> </div>
											</div>
											<div class="form-group mt-4">
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
								<div class="card">
									<div class="card-body">
                                        <h5><i class="simple-icon-picture mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_news_images"]) }}</h5>
                                        <hr>
                                        <div class="slim"></div>
									</div>
								</div>
								<!-- <br>
								<div class="card">
									<div class="col-12">
										<div class="card-body">
                                            <h5 class="mb-3"><i class="simple-icon-chart mr-2"></i>Opções</h5>
											<div class="w-100">
											    <div class="input-group mb-3">
                                                    <label class="form-group has-float-label"> <input placeholder="https://youtube.com/watch?v=dQw4w9WgXcQ" name="youtube" type="text" autocomplete="off" class="form-control"><span>{{ ucfirst($translations["backoffice"]["edit_products_youtube"]) }}</span> </label>
                                                    <div class="input-group-text p-0 pl-1 pr-1">
                                                        <span class="custom-switch custom-switch-secondary custom-switch-small vertical-align-center"> 
                                                            <input class="custom-switch-input" id="act_youtube" type="checkbox"> <label rel="tooltip" title="Ativar" class="custom-switch-btn mt-1" for="act_youtube"></label> 
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <label class="form-group has-float-label"> <input placeholder="https://criativatek.com/docs/ficheiro.pdf" name="docs" type="text" autocomplete="off" class="form-control"><span>Url do ficheiro para download</span> </label>
                                                    <div class="input-group-text p-0 pl-1 pr-1">
                                                        <span class="custom-switch custom-switch-secondary custom-switch-small vertical-align-center"> 
                                                            <input class="custom-switch-input" id="urldownload" type="checkbox"> <label rel="tooltip" title="Ativar" class="custom-switch-btn mt-1" for="urldownload"></label> 
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
										</div>
									</div>
								</div> -->																
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
@endsection

@section('scripts')
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


    <script>
            
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
                
                folder: 'obituaries'
            }
        });


        var editors = [];

        let imageEditorInstance = null;
        let imageThatIsBeingEdited = null;
        let type = null;

        //Iniciar o objeto das linguas disponiveis na loja
        var translations = {};

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
            var page = new RegExp('^/adm/obituaries/.*');

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
                }
            }
        }

        //#################################### Obituários ####################################################
        function load(id) {

            $.ajax({
                url: "/api/obituaries/" + id,
                type: "GET",
                dataType: "json",
                success: function (response) {

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
                            
                            case "text1_title":
                                if ((typeof value == 'string') || (value instanceof String)) {

                                    editors["text1_title"].setElementValue(value);
                                }
                                break;
                            
                            case "text2_title":
                                if ((typeof value == 'string') || (value instanceof String)) {

                                    editors["text2_title"].setElementValue(value);
                                }
                                break;

                            case "text3_title":
                                if ((typeof value == 'string') || (value instanceof String)) {

                                    editors["text3_title"].setElementValue(value);
                                }
                                break;

                            case "text1_description":
                                if ((typeof value == 'string') || (value instanceof String)) {

                                    editors["text1_description"].setElementValue(value);
                                }
                                break;
                            
                            case "text2_description":
                                if ((typeof value == 'string') || (value instanceof String)) {

                                    editors["text2_description"].setElementValue(value);
                                }
                                break;

                            case "text3_description":
                                if ((typeof value == 'string') || (value instanceof String)) {

                                    editors["text3_description"].setElementValue(value);
                                }
                                break;

                            case "featured":
                                $("#featuredSwitch").prop('checked', (value == "1"));
                                break;
                                
                            // case "youtube_active":
                            //     $("#act_youtube").prop('checked', (value == "1"));
                            //     break;

                            case "status":

                                // Atualizar o select do status
                                $(`[name="status"]`).val(value);

                                // Atualizar o botão verde/vermelho/laranja
                                changeState(value);
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

                    //Carregar as linguas
                    languages(response.data.related, {lang: response.data.lang, status: response.data.status});

                    //Ficar tipo do produto selecionado
                    $(`.type${response.data.type}`).addClass("active")
                    $(`.type-pane${response.data.type}`).addClass("active show")                   

                    // Refresh do plugin das tags
                    $('[name="keywords"]').tagsinput('refresh');

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

            data.featured = ($("#featuredSwitch").prop('checked') ? "1" : "0");
            data.draft = 0;
            // data.youtube_active         = ($("#act_youtube").prop('checked') ? "1" : "0");       

            console.log(data)

            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_product_save"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/obituaries/" + id,
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

            console.log('test', $('#obituary-form').serializeArray());

            // Estamos a utilizar a função serialize para todos os inputs dento de #obituary-form
            $.each($('#obituary-form').serializeArray(), function () {

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

        //Funcao para remover um obituário
        function removeObituary(id) {
            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_product_remove"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/obituaries/" + id,
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

                                // Redirecionar para a página de index dos obituários
                                window.location.replace("/adm/obituaries/");
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
                    button = `<a href="/adm/obituaries/` + lang.item_id + `" style="min-width: 80px" class="btn btn-info btn-xs float-right">{{ ucfirst($translations["backoffice"]["language_btn_see"]) }}</a>`;
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
                            url: "/api/obituaries/",
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
                                window.location.replace("/adm/obituaries/" + response.data.id);
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

        function listners(obituary_id) {

            $('[data-action="save"]').on("click", function () {

                let data = getPageData();

                // Ao clicar no botao de guardar, vamos buscar o id do produto guardado no elemento
                save($('[data-action="save"]').data("id"), data);
            });

            $('[data-action="delete"]').on("click", function () {

                let idobituary = $('[data-action="save"]').data("id");
                console.log(idobituary)
                removeObituary(idobituary);

            });               
            
            //Ao clicar no botao nova lingua
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
            $("[data-fill='name']").text($("[name='name']").val());
            $("[data-fill='details']").html($("[name='details']").val().replace(/(<([^>]+)>)/gi, ""));
            $("[data-fill='slug']").text($("[name='slug']").val());
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
                    menuBarPosition: 'right',
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

    </script>
@endsection