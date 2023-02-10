@extends('layouts.master')
@section('content')
<main class="default-transition pt-5 mb-5 collapsable-main no-load">
	<div class="p-desktop-5">
		<div class="row">
			<div class="col-md-12 mb-8">
				<div class="col-12">
					<h1>{{ ucfirst($translations["backoffice"]["title_edit_custom_info"]) }}</h1>
                    
					<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
						<ol class="breadcrumb pt-0">
							<li class="breadcrumb-item"><a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a></li>
							<li class="breadcrumb-item"><a href="/adm/custom_info">{{ ucfirst($translations["backoffice"]["custom_info_title"]) }}</a></li>
							<li class="breadcrumb-item active" aria-current="page">{{ ucfirst($translations["backoffice"]["title_edit_custom_info"]) }}</li>
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
				<form id="custom_info_form">
					<div class="contact-form clearfix">
						<div class="row">
							<div class="col-md-12 col-xl-8 col-sm-12 col-xs-12 mb-3">
								<div class="card">
									<div class="card-body">
										<h5><i class="simple-icon-notebook mr-2"></i>{{ ucfirst($translations["backoffice"]["edit_product_basic_informations"]) }}</h5>
										<hr>                                                                                                                     
										<div class="row mt-5">
                                                <div class="col-12 mt-3">
                                                    <ul class="card-header pl-0 pb-0 nav nav-tabs step-anchor tproduto">
                                                        <li class="nav-item active pr-2">
                                                            <a id="first-tab" data-toggle="tab" href="#first" role="tab" class="nav-link active pl-0 font-weight-700" aria-controls="first" aria-selected="true">{{ ucfirst($translations["backoffice"]["edit_custom_info_fill_description_1"]) }} <br><small>Tab principal</small></a>
                                                        </li>                                                  
                                                    </ul>
												<div class="card-body p-0 pt-3">
													<div class="tab-content">
														<div class="tab-pane fade active show" id="first" role="tabpanel" aria-labelledby="first-tab"><label class="form-group ckeditor has-float-label"> <textarea name="info_1" rows="4" class="c-editor w-100"></textarea> </label> </div>
														<div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab"><label class="form-group ckeditor has-float-label"> <textarea name="policy" rows="4" class="c-editor w-100"></textarea> </label> </div>
													</div>
												</div>
											</div>
										</div>
                                        <div class="row mt-5">
                                                <div class="col-12 mt-3">
                                                    <ul class="card-header pl-0 pb-0 nav nav-tabs step-anchor tproduto">
                                                        <li class="nav-item active pr-2">
                                                            <a id="first-tab" data-toggle="tab" href="#first" role="tab" class="nav-link active pl-0 font-weight-700" aria-controls="first" aria-selected="true">{{ ucfirst($translations["backoffice"]["edit_custom_info_fill_description_2"]) }} <br><small>Tab principal</small></a>
                                                        </li>                                                  
                                                    </ul>
												<div class="card-body p-0 pt-3">
													<div class="tab-content">
														<div class="tab-pane fade active show" id="first" role="tabpanel" aria-labelledby="first-tab"><label class="form-group ckeditor has-float-label"> <textarea name="info_2" rows="4" class="c-editor w-100"></textarea> </label> </div>
														<div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab"><label class="form-group ckeditor has-float-label"> <textarea name="policy" rows="4" class="c-editor w-100"></textarea> </label> </div>
													</div>
												</div>
											</div>
										</div>
                                        <div class="row mt-5">
                                                <div class="col-12 mt-3">
                                                    <ul class="card-header pl-0 pb-0 nav nav-tabs step-anchor tproduto">
                                                        <li class="nav-item active pr-2">
                                                            <a id="first-tab" data-toggle="tab" href="#first" role="tab" class="nav-link active pl-0 font-weight-700" aria-controls="first" aria-selected="true">{{ ucfirst($translations["backoffice"]["edit_custom_info_fill_description_3"]) }} <br><small>Tab principal</small></a>
                                                        </li>                                                  
                                                    </ul>
												<div class="card-body p-0 pt-3">
													<div class="tab-content">
														<div class="tab-pane fade active show" id="first" role="tabpanel" aria-labelledby="first-tab"><label class="form-group ckeditor has-float-label"> <textarea name="info_3" rows="4" class="c-editor w-100"></textarea> </label> </div>
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
            var page = new RegExp('^/adm/custom_info/.*');
            

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

        //#################################### Produtos ####################################################
        function load(id) {

            $.ajax({
                url: "/api/custom_info/" + id,
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

                        switch (key) {

                            case "info_1":
                                if ((typeof value == 'string') || (value instanceof String)) {

                                    editors["info_1"].setElementValue(value);
                                }
                                break;

                            case "info_2":
                                if ((typeof value == 'string') || (value instanceof String)) {

                                    editors["info_2"].setElementValue(value);
                                }
                                break;

                            case "info_3":

                                if ((typeof value == 'string') || (value instanceof String)) {

                                    editors["info_3"].setElementValue(value);
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

            var fd = new FormData();    

            fd.append( 'info_1', data.info_1);
            fd.append( 'info_2', data.info_2);
            fd.append( 'info_3', data.info_3);


            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_product_save"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/custom_info/" + id,
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

            console.log('test', $('#custom_info_form').serializeArray());

            // Estamos a utilizar a função serialize para todos os inputs dento de #custom_info_form
            $.each($('#custom_info_form').serializeArray(), function () {
                data[this.name] = this.value;
            });  

            return data;
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
                    button = `<a href="/adm/custom_info/` + lang.item_id + `" style="min-width: 80px" class="btn btn-info btn-xs float-right">{{ ucfirst($translations["backoffice"]["language_btn_see"]) }}</a>`;
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
                            url: "/api/custom_info/",
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
                                window.location.replace("/adm/custom_info/" + response.data.id);
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


        function listners(product_id) {

            $('[data-action="save"]').on("click", function () {                

                let data = getPageData();

                // Ao clicar no botao de guardar, vamos buscar o id do produto guardado no elemento
                save($('[data-action="save"]').data("id"), data);
            });

            //Ao clicar no butao nova lingua
            $("body").on("click", ".create-other-language-button", function () {

                let lang = $(this).data("lang");
                let lang_name = $(this).data("lang_name");

                createAnotherLanguage(lang, lang_name)
            })


            // A cada 500ms vamos executar a função fill
            setInterval(function () {

                fill();

            }, 100);
        }


        // Função para alterar valores dinamicamentes na página
        function fill() {
            $("[data-fill='info_1']").html($("[name='info_1']").val().replace(/(<([^>]+)>)/gi, ""));
            $("[data-fill='info_2']").html($("[name='info_2']").val().replace(/(<([^>]+)>)/gi, ""));
            $("[data-fill='info_3']").html($("[name='info_3']").val().replace(/(<([^>]+)>)/gi, ""));
        }


    </script>
@endsection