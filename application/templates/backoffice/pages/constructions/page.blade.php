@extends('layouts.master')
@section('content')
<main class="default-transition pt-5 mb-5 collapsable-main no-load">
	<div class="p-desktop-5">
		<div class="row">
			<div class="col-md-12 mb-8">
				<div class="col-12">
					<h1>{{ ucfirst($translations["backoffice"]["title_edit_construction"]) }}</h1>
					<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
						<ol class="breadcrumb pt-0">
							<li class="breadcrumb-item"><a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a></li>
							<li class="breadcrumb-item"><a href="/adm/constructions">{{ ucfirst($translations["backoffice"]["constructions"]) }}</a></li>
							<li class="breadcrumb-item active" aria-current="page">{{ ucfirst($translations["backoffice"]["title_edit_construction"]) }}</li>
						</ol>
					</nav>
                    <div class="btn-group top-right-button-container">
                        <button type="button" href="javascript:void(0)" onclick='javascript:window.location.assign("/adm/constructions");' class="btn btn-outline-secondary">{{ ucfirst($translations["backoffice"]["edit_custom_btn_back"]) }}</button>
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
				<form id="construction-form">
					<div class="contact-form clearfix">
						<div class="row">
							<div class="col-md-12 col-xl-8 col-sm-12 col-xs-12 mb-3">
								<div class="card">
                                    <div class="card-body">
                                        <h5 class="mb-3"><i class="simple-icon-grid mr-2"></i>Dados gerais</h5>
                                            <div class="row mt-5">
                                            <div class="col-12 col-lg-4"><label class="form-group has-float-label"> <input name="sku" type="text" autocomplete="off" class="form-control"> <span>{{ ucfirst($translations["backoffice"]["edit_product_fill_ref"]) }}</span> </label> </div>
											<div class="col-12 col-lg-8"><label class="form-group has-float-label"> <input name="name" type="text" autocomplete="off" class="form-control"> <span>{{ ucfirst($translations["backoffice"]["edit_construction_fill_name"]) }}</span> </label> </div>
                                            <div class="col-12 col-lg-6"><label class="form-group has-float-label"> <input name="duration" type="text" autocomplete="off" class="form-control"> <span>Duração</span> </label> </div>
                                            <div class="col-12 col-lg-6"><label class="form-group has-float-label"> <input name="price" type="text" autocomplete="off" class="form-control"> <span>{{ ucfirst($translations["backoffice"]["product_advanced_fill_price"]) }}</span> </label> </div> 
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="card">
									<div class="card-body pt-0">
                                        <ul class="card-header pl-0 pb-0 nav nav-tabs step-anchor tproduto">
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
										</div>
									</div>
								</div>
								<br>
								<div class="card">
									<div class="card-body">
										<h5><i class="simple-icon-grid mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_product_fill_gallery"]) }}</h5>
										<hr>
										<div class="row mt-3">
											<div class="col-12">
												<div class="dropzone"></div>
											</div>
										</div>
									</div>
								</div>							
								<br>
                                
                                <div class="card">
									<div class="card-body">
                                    <h5 class="mb-3"><i class="simple-icon-list mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_product_attributes"]) }}</h5>
                                    
										<div class="row mt-2">
											<div class="col-12 config-page">
												<table class="dt-responsive stripe languages-table dataTable no-footer dtr-inline" id="thetable" role="grid" style="width: 0px;">
													<thead class="thead">
														<tr>
                                                            <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-sort="ascending" aria-label="Description: activate to sort column descending">{{ ucfirst($translations["backoffice"]["edit_product_attributes_description"]) }}</th>
                                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-label="Valor: activate to sort column ascending">{{ ucfirst($translations["backoffice"]["edit_product_attributes_value"]) }}</th>
															<th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;"></th>
														</tr>
													</thead>
													<tbody id="tableBodyAttributes" class="sortable">
														<tr id="tableRowAttribute">
															<td class="attributeKey"></td>
															<td class="attributeValue"></td>
															<td><a href="javascript:void(0)" class="btn btn-xs btn-danger float-right buttonDeleteAttributes"><i class="simple-icon-trash"></i></a> </td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="row mt-3">
											<div class="col-12">
												<div class="row">
													<div class="col-12 col-lg-6 mt-3"><label class="form-group has-float-label"> <input name="attribute_description" type="text" autocomplete="off" class="form-control"> <span>{{ ucfirst($translations["backoffice"]["edit_product_attributes_description"]) }}</span> </label> </div>
													<div class="col-12 col-lg-6 mt-3"><label class="form-group has-float-label"> <input name="attribute_value" type="text" autocomplete="off" class="form-control"> <span>{{ ucfirst($translations["backoffice"]["edit_product_attributes_value"]) }}</span> </label> </div>
												</div>                                    
                                                <button type="button" data-action="saveAttribute" class="btn btn-light default col-lg-12"><i class="simple-icon-plus mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_product_attributes_create"]) }} </button> 
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
																<p>{{ URL }}{{ $selected_language->code }}/constructions/<span data-fill="slug"></span></p>
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
												<label><span class="dot green mr-2"></span> {{ ucfirst($translations["backoffice"]["edit_construction_status"]) }}</label>
												<select name="product_condition" class="form-control">
													<option value="0">{{ ucfirst($translations["backoffice"]["construction_in_construction"]) }}</option>
													<option value="1">{{ ucfirst($translations["backoffice"]["construction_completed"]) }}</option>
												</select>
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
								</div>
                                <br>
                                @if(MODULES_CATEGORIES_CONSTRUCTIONS)	
                                <div class="card">
									<div class="col-12">
										<div class="card-body">
											<h5><i class="simple-icon-list mr-2"></i>{{ ucfirst($translations["backoffice"]["categories"]) }}</h5>
											<hr>
											<div id="categories"></div>
										</div>
									</div>
								</div>
								<br>
                                @endif		
                                @if(MODULES_SERVICES)							
                                <div class="card">
									<div class="col-12">
										<div class="card-body">
											<h5><i class="simple-icon-list mr-2"></i>{{ ucfirst($translations["backoffice"]["services"]) }}</h5>
											<hr>
											<div id="services"></div>
										</div>
									</div>
								</div>
                                @endif																
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>    
</main>
<div class="modal fade modal-right select-from-library" id="editAttribute" tabindex="-1" role="dialog" aria-labelledby="editAttribute" aria-hidden="true">
	<div class="modal-dialog" role="attribute">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{ ucfirst($translations["backoffice"]["edit_product_attributes_edit"]) }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> 
			</div>
			<div class="modal-body">
				<div>                
                    <div class="row">
						<div class="col-12 mt-3 block"><label class="form-group has-float-label"> <input name="describe_attr" type="text" autocomplete="off" class="form-control"> <span>Categoria</span> </label> </div>
					</div>

                    <div class="row">
						<div class="col-12 mt-3 block"><label class="form-group has-float-label"> <input name="value_attr" type="text" autocomplete="off" class="form-control"> <span>Valor</span> </label></div>
					</div>                   
				</div>
				<hr>
				<div class="list disable-text-selection">
					<div class="row"></div>
				</div>
			</div>
			<div class="modal-footer"> <button type="button" class="btn btn-outline-primary" data-dismiss="modal">{{ ucfirst($translations["backoffice"]["product_advanced_new_btn_close"]) }}</button> <button type="button" class="btn btn-primary" data-dismiss="modal" data-action="editAttribute">{{ ucfirst($translations["backoffice"]["edit_product_attributes_edit"]) }} </button> </div>
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
            var page = new RegExp('^/adm/constructions/.*');

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
                    
                    loadAttributes(wildcard)

                    // Listners para os botões de guardar etc
                    listners(wildcard);

                    //Atribuir o id ao campo "save"
                    $('[data-action="save"]').data("id", wildcard)

                    //Atribuir id da obra ao butao saveAttribute
                    $('[data-action="saveAttribute"]').data("idConstruction", wildcard)                    
                }
            }
        }

        //#################################### Produtos ####################################################
        function load(id) {

            $.ajax({
                url: "/api/constructions/" + id,
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

                    // Iniciar galeria de imagens
                    dropzoneGallery(response.data.id, response.data.images);

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

                            case "featured":
                                $("#featuredSwitch").prop('checked', (value == "1"));
                                break;

                            case "policy":
                                if ((typeof value == 'string') || (value instanceof String)) {

                                    editors["policy"].setElementValue(value);
                                }
                                break;
                                
                            case "youtube_active":
                                $("#act_youtube").prop('checked', (value == "1"));
                                break;

                            case "status":

                                // Atualizar o select do status
                                $(`[name="status"]`).val(value);

                                // Atualizar o botão verde/vermelho/laranja
                                changeState(value);
                                break;

                            case "photo":

                                // if (value != null && value.length > 0) {
                                //     // Carregar imagem do slide
                                //     $(".slim").slim('load',  value, { blockPush : true }, function(error, data) { });
                                // }
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

                    servicesLoad(response.data.lang, response.data.service);

                    @if(MODULES_CATEGORIES_CONSTRUCTIONS)	

                    categoriesLoad(response.data.lang, response.data.categories);

                    @endif

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
            data.youtube_active         = ($("#act_youtube").prop('checked') ? "1" : "0");
            data.categories = [];
            data.service = [];            
            

            // Obter os serviços
            $("#services input:checked").each(function (key, item) {
                data.service.push($(item).parent().data("id"));
            });

            // Obter as categorias
            $("#categories input:checked").each(function (key, item) {
                data.categories.push($(item).parent().data("id"));
            });

            data.categories = data.categories.join(",");

            data.service = data.service.join(",");
            

            console.log(data)

            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_product_save"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/constructions/" + id,
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

            console.log('test', $('#construction-form').serializeArray());

            // Estamos a utilizar a função serialize para todos os inputs dento de #construction-form
            $.each($('#construction-form').serializeArray(), function () {

                data[this.name] = this.value;
            });

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
                            url: "/api/constructions/" + id,
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
                                window.location.replace("/adm/constructions/");
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

        //#################################### Categorias ####################################################
        function categoriesLoad(lang, selected_categories) {

            $.ajax({
                url: "/api/categories_constructions/",
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

                        // Não deixar a função executar mais
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

                    // Temos filhos na categoria, vamos chamar a função para adicionar o html
                    // Isto chama-se uma função recursiva ou algo parecido, idk, não andei na uni :)

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


        //#################################### Atributos ####################################################
        //Pedido dos atributos de um produto
        function loadAttributes(idConstruction) {
            $.ajax({
                url: "/api/attributes_constructions/constructions/" + idConstruction,
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
                        // Não deixar a função executar mais
                        return;
                    }
                    //Coloca os dados na tabela
                    populateAttributes(response.data)


                    setTimeout(() => {
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
                                    console.log(id)                    
                                    if(ids == '') {
                                        ids = id;
                                    } else {
                                        ids = ids + ',' + id;
                                    }
                                })
                                
                                $.ajax({
                                    url: "/api/attributes_constructions/sortable",
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
                    }, 200)
                    
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

        function populateAttributes(items) {
            //Remove a linha da tabela
            $("#tableBodyAttributes").html("");

            //Por cada item acrescenta uma linha a tabela com os dados fornecidos pela api
            $.each(items, function (key, item) {
                templateAttribute(item)
            })
        }

        function saveAttributes(data) {

            $.ajax({
                url: "/api/attributes_constructions",
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
                    templateAttribute(response.data)
                    //Limpa valores do imput
                    $("[name='attribute_description']").val("");
                    $("[name='attribute_value']").val("");

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });
                }
            });
        }

        function editAttributes(data) {

            $.ajax({
                url: "/api/attributes_constructions/update",
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
                    loadAttributes(response.data.id_construction)
                    //Limpa valores do imput
                    $("[name='describe_attr']").val("");
                    $("[name='value_attr']").val("");

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });
                }
            });
        }

        function getAttributes() {

            //Cria um objeto com os valores dos inputs
            let data = {}
            let description = $("[name='attribute_description']").val();
            let value = $("[name='attribute_value']").val();

            if (description.length == 0) {

                return false;
            }

            if (value.length == 0) {

                return false;
            }

            data = {
                'attribute_key': description,
                'value': value,
                'id_construction': $('[data-action="saveAttribute"]').data("idConstruction")
            }

            return data;
        }

        function getAttributesFromModal() {

            //Cria um objeto com os valores dos inputs
            let data = {}
            let description = $("[name='describe_attr']").val();
            let value = $("[name='value_attr']").val();

            if (description.length == 0) {

                return false;
            }

            if (value.length == 0) {

                return false;
            }

            data = {
                'attribute_key': description,
                'value': value,
                'id': $('[data-action="editAttribute"]').data("id")
            }

            return data;
        }

        function templateAttribute(item) {
            let template = `
                <tr data-id="` + item.id + `">
                    <td>` + item.attribute_key + `</td>
                    <td>` + item.value + `</td>                    
                    <td>                    
                        <a href="javascript:void(0)"
                            class="btn btn-xs btn-danger float-right buttonDeleteAttributes" data-id="` + item.id + `"><i class="simple-icon-trash"></i>
                        </a>                       
                        <a href="javascript:void(0)"
                            class="btn btn-xs btn-primary float-right editAttr" data-id="` + item.id + `"><i class="simple-icon-pencil"></i>
                        </a>
                    </td>
                </tr>
            `;
            $("#tableBodyAttributes").append(template)
        }

        function removeAtrribute(object) {

            let id = $(object).data("id");

            $.ajax({
                url: "/api/attributes_constructions/" + id,
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

                    //Remove a linha do atributo do HTML

                    $(object).closest("tr").remove();
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
       
        //#################################### Serviços ####################################################
        function servicesLoad(lang, selected_services) {

            $.ajax({
                url: "/api/services/",
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

                        // Não deixar a função executar mais
                        return;
                    }

                    // Retirar categorias nao desejadas, outras linguas e categorias root
                    response.data = response.data.filter(function (service) {

                        if (service.banner != null && service.photo != null) {

                            return true;
                        }

                        return false;
                    });


                    // Vamos transformar a lista de services numa lista estruturada ( tipo um arvore )
                    let services = listToTree(response.data);

                    $("#services").html(populateServices(services, lang, selected_services));

                    servicesListners();

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

        function populateServices(services, lang, selected_services) {

            let template = $("<ul class='p-0'></ul>");

            if (selected_services == null) {

                selected_services = "";
            }

            console.log(services);

            let selected = selected_services.split(",");

            $.each(services, function (key, serv) {

                let isFather = (serv.title == null) ? `<span>` + serv.title + `</span>` : `<input  ` + (selected.includes(serv.id) ? "checked" : "") + ` class="mt-2 mr-2 ml-2" type="checkbox">` + serv.title + ``

                let service_template  = $(`
                <li class='pl-4' style="min-width: 100%">
                    <div data-id="` + serv.id + `" class='category-block'>
                        ` + isFather + `

                    </div>
                </li>
            `);

                template.append(service_template[0].outerHTML);
            });

            return template[0].outerHTML;
        }


        function servicesListners () {

            $('#services input[type="checkbox"]').on("click", function () {

                let original_check = $(this).prop("checked")

                $(this).parents("li").each(function () {

                    let input = $($(this).find("[data-id] input").get(0)).prop("checked", original_check);
                    console.log(input);
                });
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
                    button = `<a href="/adm/constructions/` + lang.item_id + `" style="min-width: 80px" class="btn btn-info btn-xs float-right">{{ ucfirst($translations["backoffice"]["language_btn_see"]) }}</a>`;
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
                            url: "/api/constructions/",
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
                                window.location.replace("/adm/constructions/" + response.data.id);
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

        function listners(construction_id) {

            $('[data-action="save"]').on("click", function () {

                let data = getPageData();

                // Ao clicar no botao de guardar, vamos buscar o id do produto guardado no elemento
                save($('[data-action="save"]').data("id"), data);
            });

            $("body").on('click', ".editAttr", function () {
               
               let id = $(this).data("id");

               $.ajax({
                   url: "/api/attributes_constructions/" + id,
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

                           // Não deixar a função executar mais
                           return;
                       }

                       $('[name="describe_attr"]').val(response.data.attribute_key); 
                       $('[name="value_attr"]').val(response.data.value);
                       $('[data-action="editAttribute"]').data("id", response.data.id)

                       $("#editAttribute").modal("show");
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
           
            $("body").off("click", ".image-editor");
            $("body").on("click", ".image-editor", function () {

                imageThatIsBeingEdited = $(this).data("link");

                imageEditor($(this).data("link") + "?nocache=" + (new Date().getTime()));
            });

            $("body").off("click", ".tui-image-editor-close-btn");
            $("body").on("click", ".tui-image-editor-close-btn", function () {

                $("#editImageModal").modal("hide");
            });

            $("body").on("click", '.buttonDeleteAttributes', function () {
                removeAtrribute(this);

            });

            $('[data-action="delete"]').on("click", function () {

                let idConstruction = $('[data-action="save"]').data("id");
                console.log(idConstruction)
                removeProduct(idConstruction);

            });

            $('[data-action="saveAttribute"]').on("click", function () {

                let dataAttribute = getAttributes();

                if (dataAttribute !== false) {

                    //Salva o atributo
                    saveAttributes(dataAttribute);
                }
            });

            $('[data-action="editAttribute"]').on("click", function () {

                let dataAttribute = getAttributesFromModal();

                if (dataAttribute !== false) {

                    //Salva o atributo
                    editAttributes(dataAttribute);
                }
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

        function dropzoneGallery(construction_id, files) {

            // Iniciar o upload de imagens
            $(".dropzone").dropzone({

                addRemoveLinks: false,
                previewTemplate: template(),
                url: "/api/image/dropzone",
                params: {
                    construction_id: construction_id,
                    folder: 'constructions',
                },
                transformFile: function(file, done) {

                    if(file.type != "video/mp4" && file.type != "video/mkv") 
                    {
                        new Compressor(file, {
                            quality: 0.8,
                            maxWidth: 1920,
                            maxHeight: 1920,
                            success(result) {
                                done(result)                                
                            },
                            error(err) {
                                console.log(err.message);
                            },
                        });
                    } else {
                        done(file) 
                    }  
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
                                        url: "/api/image/dropzone/" + file_id + '&isconstruction=true',
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
                                    url: "/api/image/order?ids=" + order.join(",") + "&gallery=constructions_gallery",
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
                            i--;                                                    // Corrigir a iteração

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