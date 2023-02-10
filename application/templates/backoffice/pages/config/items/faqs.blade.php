<h4 class="w-100">{{ ucfirst($translations["backoffice"]["faqs_title"]) }}

<div class="btn-group top-right-button-container">
        <a href="#" class="btn btn-xs btn-outline-secondary add-new-faq">{{ ucfirst($translations["backoffice"]["faqs_btn_create"]) }}</a>
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
            <button id="btnGroupDrop1" type="button" class="btn btn-xs btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ ucfirst($translations["backoffice"]["languages"]) }}</button>
            <div class="dropdown-menu dropdown-menu-right p-3" style="width: max-content;">
                <ul class="nav nav-tabs" id="faqs-languages-list" role="tablist"></ul>
            </div>
        @endif
    </div>

</h4>
<hr>
<div class="row mt-2">
    <div class="col-12">
        <div class="tab-content" id="faqs-languages-tabs">
        </div>
    </div>
</div>

<div class="modal fade modal-right" id="faqs-modal" tabindex="-1" role="dialog" aria-labelledby="faqs-modal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header draggable">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="white"
                                                                                                  aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 mx-auto">
                    <form>
                        <div class="row">
                            <div class="form-group col mb-6">
                                <label>{{ ucfirst($translations["backoffice"]["faqs_fill_title"]) }}</label>
                                <input id="titleFaq" name="title" type="text" autocomplete="off" class="form-control" placeholder="Como registar?">
                            </div>
                        </div>
                        <div class="form-group mb-6">
                            <label>{{ ucfirst($translations["backoffice"]["faqs_fill_language"]) }}</label>
                            <select name="lang" class="form-control">
                            </select>
                        </div>
                        <label class="form-group ckeditor has-float-label">{{ ucfirst($translations["backoffice"]["faqs_fill_description"]) }}
                            <textarea name="details" rows="4" id="editor-details" class="c-editor w-100"></textarea>
                        </label>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">{{ ucfirst($translations["backoffice"]["faqs_btn_cancel"]) }}</button>
                <button type="button" class="btn btn-primary btn-sm save-faqs" data-id="">{{ ucfirst($translations["backoffice"]["faqs_btn_save"]) }}</button>
            </div>
        </div>
    </div>
</div>

<script src="/static/backoffice/javascript/jodit_editor_js/jodit.js"></script>
<script src="/static/backoffice/javascript/jodit_editor_js/app.js"></script>
<script src="/static/backoffice/javascript/jodit_editor_js/prism.js"></script>
<link rel="stylesheet" href="/static/backoffice/css/jodit_editor_css/app.css"/>
<link rel="stylesheet" href="/static/backoffice/css/jodit_editor_css/jodit.css"/>
<link rel="stylesheet" href="/static/backoffice/css/jodit_editor_css/prism.css"/>

<script>
    var editors = [];

    function faqs() {
        var default_language = null;

        editors[$("#editor-details").attr("name")] = new Jodit("#editor-details", {

            textIcons: false,
            iframe: false,
            toolbarAdaptive: false,
            height: 400,
            language: "pt_br",
            defaultMode: Jodit.MODE_WYSIWYG,

            buttons: "source,|,paragraph,bold,strikethrough,underline,italic,eraser,|,ul,ol,|,outdent,indent,|,font,fontsize,brush,paragraph,|,image,file,video,table,link,|,align,undo,redo,\n,|,hr,symbol,fullsize",

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

        initFaqs();

        function initFaqs() {
            console.log("editors", editors)

            // Temos de obter as línguas primeiro
            getLanguages(function () {

                // Limpar linguas do modal de editar
                $("#faqs-modal select").html("");
                $("#faqs-languages-list").html("");
                 $("#faqs-languages-tabs").html("");

                // Por cada lingua que tivermos temos de adicionar uma tab
                $.each(window.LANGUAGES, function (key, language) {

                    // Introduzir as linguas no modal de editar
                    $("#faqs-modal select").append(`<option value="` + language.code + `">` +
                        language.name + `</option>`);

                    // Vereficar se é a lingua default ou não
                    (language.default === "1") ? default_language = language.code : null;

                    // Nav links
                    if ($("#faqs-languages-list").find(".nav-item").length < window.LANGUAGES
                        .length) {

                        $("#faqs-languages-list").append(`
                        <li>
                            <a class="nav-link ` + ((language.default === "1") ? "active" : "") +
                            ` text-small" id="language-faqs-tab-` + language.code +
                            `" data-toggle="tab" href="#language-faqs-` + language.code +
                            `" role="tab">` + language.name + `</a>
                        </li>
                    `);

                        // Tabs
                        $("#faqs-languages-tabs").append(`
                        <div class="tab-pane fade ` + ((language.default === "1") ? "active show" : "") +
                            `" id="language-faqs-` + language.code + `" role="tabpanel">

                            <div class="row">
                                <div class="col-12" id="accordion">
                                    <div class="faqs-list" id="language-faqs-list-` + language.code + `">

                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                    }

                });

                $.ajax({
                    url: "/api/faqs/",
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

                        // Limpar os items dentro das tabelas
                        $(".faqs-list").html("");

                        populateFaqs(response.data);
                        listners()
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
        }

        function populateFaqs(items) {
            $.each(items, function (key, faq) {
                
                // Adicionar o metodo de envio à lingua correspondente
                $(`#language-faqs-list-` + faq.lang).append(`
                    <div class="card d-flex mb-3" style="background: #f6f6f6;">
                        <div class="d-flex flex-grow-1 min-width-zero collapsed" data-toggle="collapse" data-target="#collapse`+ faq.id +`" aria-expanded="false" aria-controls="collapse` + faq.id +`">
                            <button class="btn btn-empty list-item-heading text-left text-one font-black">` + faq.title +`</button>
                            <div class="marginIconsFaqs">
                                	<button type="button" class="btn btn-outline-danger mb-1 btn-xs m-1 float-right remove-faq" name="delte_slide_btn " title="apagar" id="delte_slide_btn" data-id="` + faq.id +`"><i class="simple-icon-trash"></i></button>
                                    <button type="button" class="btn btn-outline-secondary mb-1 btn-xs m-1 float-right edit-faq" name="edit_slide_btn" title="editar" id="edit_slide_btn" data-id="` + faq.id +`"><i class="simple-icon-pencil"></i></button>
                            </div>
                        </div>
                        <div id="collapse` + faq.id +`" class="collapse" data-parent="#accordion">
                            <div class="card-body accordion-content">
                                ` + faq.details +`
                            </div>
                        </div>
                    </div>
                `);
            });
        }

        function editFaq(id = "", data) {
            $.ajax({
                url: "/api/faqs/" + id,
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

                    // Obter dados novos do servidor
                    initFaqs();

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

        // Eliminar a método de envio
        function removeFaq(id) {

            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_message_remove_faq"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/faqs/" + id,
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

                                // Obter dados novos do servidor
                                initFaqs();
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

        function listners() {

            // Ao clicar no adicionar metodo
            $(".add-new-faq").off("click");
            $(".add-new-faq").on("click", function () {
                cleanEditor();

                // Alterar o titulo do modal
                $("#faqs-modal .modal-title").text("Nova FAQ");

                $(".save-faqs").removeData("id");


                $(".save-faqs").removeClass("edit");

                $("#faqs-modal").modal("show");
            });

            // Ao clicar no editar
            $(".edit-faq").off("click");
            $(".edit-faq").on("click", function () {

                cleanEditor();

                // Alterar o titulo do modal
                $("#faqs-modal .modal-title").text("Editar estado");

                let id = $(this).data("id");

                // Adicionar o id ao botao de salvar
                $(".save-faqs").data("id", id);

                // Introduzir os dados no modal
                $.get("/api/faqs/" + id, function (response) {

                    $.each(response.data, function (key, value) {

                        if (key == "details") {
                            editors.details.value = value;
                        } else {
                            $("[name='" + key + "']").val(value);
                        }
                    });

                    //adicionar class edit aoo butao save do modal
                    $(".save-faqs").addClass("edit");
                    // Abrir o modal de editar
                    $("#faqs-modal").modal("show");
                });
            });

            //Ao clicar no eliminar
            $(".remove-faq").off("click");
            $(".remove-faq").on("click", function () {

                let id = $(this).data("id");

                removeFaq(id);

            });

            // Guardar o método de envio
            $(".save-faqs").off("click");
            $(".save-faqs").on("click", function () {

                // Vereficar se vamos guardar ou editar
                let id = $(".edit").data("id");
                let data = $("#faqs-modal form").serialize();
                console.log(id)

                editFaq(id, data);

                cleanEditor();

                $("#faqs-modal").modal("hide");

                // Retirar o id do data-id para uma proxima ação
                $(this).data("id", "");
            });
        }

        function cleanEditor() {

            $("#editor-details form").trigger("reset");
            editors["details"].setEditorValue("")
            $("#titleFaq").val("")
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

                        window.LANGUAGES = response.data;

                        // Chamar o callback
                        callback();

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

    };

</script>
