<h4 class="w-100"><?php echo e(ucfirst($translations["backoffice"]["orderStatus_title"])); ?>

    <div class="btn-group top-right-button-container">
        <a href="#" class="btn btn-xs btn-outline-secondary add-new-status"><?php echo e(ucfirst($translations["backoffice"]["orderStatus_btn_create"])); ?></a>
        <?php 
            $countLangs = 0;
        ?>
        <?php if(count($languages) > 1): ?>
            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($langs->active == 1): ?>
                    <?php 
                        $countLangs ++;
                    ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <?php if($countLangs > 1): ?>
            <button id="btnGroupDrop1" type="button" class="btn btn-xs btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(ucfirst($translations["backoffice"]["languages"])); ?></button>
            <div class="dropdown-menu dropdown-menu-right p-3" style="width: max-content;">
                <ul class="nav nav-tabs" id="status-languages-list" role="tablist"></ul>
            </div>
        <?php endif; ?>
    </div>
</h4>
<hr>
<div class="row mt-2">
    <div class="col-12">
        <div class="tab-content" id="status-languages-tabs">
        </div>
    </div>
</div>

<div class="modal fade modal-fullscreen-sm-down rounded-modal modal-small" id="status-editor" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header draggable">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="white" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 mx-auto">
                    <form>
                        <div class="row">
                            <div class="form-group col mb-6">
                                <label><?php echo e(ucfirst($translations["backoffice"]["orderStatus_fill_name"])); ?></label>
                                <input name="name" type="text" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group col mb-6">
                                <label><?php echo e(ucfirst($translations["backoffice"]["orderStatus_fill_language"])); ?></label>
                                <select name="lang" class="form-control">
                                </select>
                            </div>
                        </div>
                        <label class="form-group ckeditor has-float-label"><?php echo e(ucfirst($translations["backoffice"]["orderStatus_fill_email_content"])); ?>

                            <textarea name="email" rows="4" id="editor-emails" class="c-editor w-100"></textarea>
                        </label>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm" data-dismiss="modal"><?php echo e(ucfirst($translations["backoffice"]["orderStatus_btn_cancel"])); ?></button>
                <button type="button" class="btn btn-primary btn-sm save-status" data-id=""><?php echo e(ucfirst($translations["backoffice"]["orderStatus_btn_save"])); ?></button>
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

    function orderStatus() {
        var default_language = null;

        editors[$("#editor-emails").attr("name")] = new Jodit("#editor-emails", {

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

        initStatus();

        function initStatus() {
            console.log("editors", editors)

            // Temos de obter as línguas primeiro
            getLanguages(function () {

                // Limpar linguas do modal de editar
                $("#status-editor select").html("");
                $("#status-languages-list").html("");
                 $("#status-languages-tabs").html("");
                 
                 

                // Por cada lingua que tivermos temos de adicionar uma tab
                $.each(window.LANGUAGES, function (key, language) {

                    // Introduzir as linguas no modal de editar
                    $("#status-editor select").append(`<option value="` + language.code + `">` +
                        language.name + `</option>`);

                    // Vereficar se é a lingua default ou não
                    (language.default === "1") ? default_language = language.code : null;

                    // Nav links
                    if ($("#status-languages-list").find(".nav-item").length < window.LANGUAGES
                        .length) {

                        $("#status-languages-list").append(`
                        <li>
                            <a class="nav-link ` + ((language.default === "1") ? "active" : "") +
                            `  text-small" id="language-status-tab-` + language.code +
                            `" data-toggle="tab" href="#language-status-` + language.code +
                            `" role="tab">` + language.name + `</a>
                        </li>
                    `);

                        // Tabs
                        $("#status-languages-tabs").append(`
                        <div class="tab-pane fade ` + ((language.default === "1") ? "active show" : "") +
                            `" id="language-status-` + language.code + `" role="tabpanel">
                            <table class="dt-responsive stripe languages-table dataTable no-footer dtr-inline" id="thetable3` + language.code + `" role="grid" style="width: 0px;">
                                <thead class="thead">
                                    <tr>
                                        <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-sort="ascending" aria-label="Nome: activate to sort column descending"><?php echo e(ucfirst($translations["backoffice"]["orderStatus_fill_name"])); ?></th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-label="Autor: activate to sort column ascending">#</th>
                                    </tr>
                                </thead>
                                <tbody class="order-status-list" id="language-status-table-` + language.code + `"></tbody>
                            </table>
                        </div>
                    `);
                    }

                });

                $.ajax({
                    url: "/api/orderStatus/",
                    type: "GET",
                    dataType: "json",
                    success: function (response) {

                        if (!response.success) {

                            // Output do erro
                            console.error(response);

                            $.alert({
                                title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                theme: "supervan",
                                content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                            });

                            // Não deixar a função executar mais
                            return;
                        }

                        // Limpar os items dentro das tabelas
                        $(".order-status-list").html("");

                        populateStatus(response.data);
                        listners()


                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                        console.log(textStatus, errorThrown);

                        $.alert({
                            title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                            theme: "supervan",
                            content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                        });
                    }
                });

            });
        }

        function populateStatus(items) {
            let noPredefined = ""
            $.each(items, function (key, status) {

                if (status.predefined != 1)
                    noPredefined = `<a href="javascript:void(0)" style="margin-left: 4px;" class="btn btn-outline-danger mb-1 btn-xs m-1 float-right remove-status"><i class="simple-icon-trash"></i></a>
                            <a href="javascript:void(0)" class="btn btn-outline-secondary mb-1 btn-xs m-1 float-right edit-status"><i class="simple-icon-pencil"></i></a>`
                else {

                    noPredefined = `<a class="btn btn-light mb-1 btn-xs m-1 float-right disabled" disabled><i class="simple-icon-star" disabled></i></a>
                                    <a href="javascript:void(0)" class="btn btn-outline-secondary mb-1 btn-xs m-1 float-right edit-status"><i class="simple-icon-pencil"></i></a>`
                }

                // Adicionar o metodo de envio à lingua correspondente
                $(`#language-status-table-` + status.lang).append(`
                    <tr data-id="` + status.id + `">
                        <td class="" scope="col">` + status.name + `</td>
                        <td>
                            ` + noPredefined + `
                        </td>
                    </tr>
                `);

                  $(document).ready( function () {
                    $('#thetable3'+ status.lang).DataTable();
                       } );

            });
        }

        function editStatus(id = "", data) {
            $.ajax({
                url: "/api/orderStatus/" + id,
                type: "POST",
                data: data,
                dataType: "json",
                success: function (response) {

                    if (!response.success) {

                        // Output do erro
                        console.error(response);

                        $.alert({
                            title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                            theme: "supervan",
                            content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                        });

                        // Não deixar a função executar mais
                        return;
                    }

                    // Obter dados novos do servidor
                    initStatus();

                },
                error: function (jqXHR, textStatus, errorThrown) {

                    console.log(textStatus, errorThrown);

                    $.alert({
                        title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                        theme: "supervan",
                        content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                    });
                }
            });
        }

        // Eliminar a método de envio
        function removeStatus(id) {

            $.confirm({
                title: '<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>',
                theme: "supervan",
                content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_message_remove_orderStatus"])); ?>',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/orderStatus/" + id,
                            // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                            // De texto, etc e em alguns servidores pode dar erro
                            type: "DELETE",
                            dataType: "json",
                            success: function (response) {

                                if (!response.success) {

                                    // Output do erro
                                    console.error(response);

                                    $.alert({
                                        title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                        theme: "supervan",
                                        content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                                    });

                                    // Não deixar a função executar mais
                                    return;
                                }

                                // Obter dados novos do servidor
                                initStatus();
                            },
                            error: function (jqXHR, textStatus, errorThrown) {

                                console.log(textStatus, errorThrown);

                                $.alert({
                                    title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                    theme: "supervan",
                                    content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
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
            $(".add-new-status").off("click");
            $(".add-new-status").on("click", function () {

                // Alterar o titulo do modal
                $("#status-editor .modal-title").text("Novo estado");

                cleanEditor();
                $("#status-editor [name='name']").prop("disabled", false);
                $("#status-editor [name='lang']").prop("disabled", false);

                $(".save-status").removeClass("edit");

                $("#status-editor").modal("show");
            });

            // Ao clicar no editar
            $(".edit-status").off("click");
            $(".edit-status").on("click", function () {

                cleanEditor();

                // Alterar o titulo do modal
                $("#status-editor .modal-title").text("Editar estado");

                let id = $(this).closest("tr").data("id");

                // Adicionar o id ao botao de salvar
                $(".save-status").data("id", id);

                // Introduzir os dados no modal
                $.get("/api/orderStatus/" + id, function (response) {

                    $.each(response.data, function (key, value) {

                        console.log(response.data);

                        if (response.data.predefined == 1 && key == "lang") {
                            $("#status-editor [name='" + key + "']").val(value);
                            $("#status-editor [name='" + key + "']").prop("disabled", true);
                        } else if (key == "email") {
                            editors.email.value = value;
                        } else {
                            $("#status-editor [name='" + key + "']").val(value);
                            $("#status-editor [name='" + key + "']").prop("disabled", false);
                        }

                    });

                    //adicionar class edit aoo butao save do modal
                    $(".save-status").addClass("edit");
                    // Abrir o modal de editar
                    $("#status-editor").modal("show");
                });
            });

            //Ao clicar no eliminar
            $(".remove-status").off("click");
            $(".remove-status").on("click", function () {

                let id = $(this).closest("tr").data("id");

                removeStatus(id);

            });

            // Guardar o método de envio
            $(".save-status").off("click");
            $(".save-status").on("click", function () {

                // Verificar se vamos guardar ou editar
                let id = $(".edit").data("id");
                let data = $("#status-editor form").serialize();
                console.log(id)

                editStatus(id, data);

                cleanEditor();

                $("#status-editor").modal("hide");

                // Retirar o id do data-id para uma proxima ação
                $(this).data("id", "");
            });
        }

        function cleanEditor() {

            $("#status-editor form").trigger("reset");
            editors["email"].setEditorValue("")
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
                                title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                theme: "supervan",
                                content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
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
                            title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                            theme: "supervan",
                            content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                        });
                    }
                });
            }
        }

        	

    };

</script>
<?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/pages/config/items/orderStatus.blade.php ENDPATH**/ ?>