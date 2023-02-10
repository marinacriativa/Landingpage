<h4 class="w-100"><?php echo e(ucfirst($translations["backoffice"]["shipping_title"])); ?>

    <div class="btn-group top-right-button-container">
        <a href="#" class="btn btn-xs btn-outline-secondary add-new-shipping"><?php echo e(ucfirst($translations["backoffice"]["shipping_btn_create"])); ?></a>
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
                <ul class="nav nav-tabs" id="shipping-languages-list" role="tablist"></ul>
            </div>
        <?php endif; ?>
    </div>
</h4>
<hr>
<div class="row mt-2">
    <div class="col-12">
        
        <div class="tab-content" id="shipping-languages-tabs">
        </div>
    </div>
</div>

<div class="modal fade modal-fullscreen-sm-down rounded-modal modal-small" id="shipping-editor" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header draggable">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="white"
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6 mx-auto">
                    <form>
                        <div class="form-group has-float-label col mb-4">
                            <label class="ml-3"><?php echo e(ucfirst($translations["backoffice"]["shipping_fill_name"])); ?></label>
                            <input name="title" type="text" autocomplete="off" class="form-control">
                        </div>
                        <div class="form-group has-float-label col mb-4">
                            <label class="ml-3"><?php echo e(ucfirst($translations["backoffice"]["shipping_fill_description"])); ?></label>
                            <input name="subtitle" type="text" autocomplete="off" class="form-control">
                        </div>
                        <div class="form-group has-float-label col mb-4">
                            <label class="ml-3"><?php echo e(ucfirst($translations["backoffice"]["shipping_fill_price"])); ?></label>
                            <input name="price" type="number" min="0" autocomplete="off" class="form-control">
                        </div>
                        
                        <div class="form-group has-float-label col mb-4">
                            <label class="ml-3"><?php echo e(ucfirst($translations["backoffice"]["shipping_fill_language"])); ?></label>
                            <select name="lang" class="form-control">
                            </select>
                        </div>
                </div>
                <div class="col-md-6 mx-auto">
                    <h4>Custo de frete do cliente</h4>
                    <label class="col-form-label">Onde irá aplicar o desconto?</label>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gridRadios1"
                                id="gridRadio" value="option1">
                            <label class="form-check-label" for="gridRadio">
                                Transporte grátis acima de um certo valor
                            </label><br>
                            <small>Os itens são enviados gratuitamente quando o valor do pedido ultrapassa um certo valor</small>
                            <div class="form-group has-float-label col mb-2 mt-2">
                                <label class="ml-3"><?php echo e(ucfirst($translations["backoffice"]["shipping_fill_price"])); ?></label>
                                <input name="price_limit" type="number" min="0" autocomplete="off" class="form-control p-2">
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gridRadios1"
                                id="gridRadio1" value="option2">
                            <label class="form-check-label" for="gridRadio1">
                                Transporte gratuito
                            </label><br>
                            <small>Todos os itens são enviados gratuitamente</small>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gridRadios1"
                                id="gridRadio2" value="option3">
                            <label class="form-check-label" for="gridRadio3">
                                Com base no valor do pedido
                            </label><br>
                            <small>A taxa de frete depende do valor do pedido</small>

                            <div class="my-2 priceform">
                                
                                </div>
                            
                            <div class="ml-auto mr-0 ">
                                <a href="javascript:void(0)" class="btn mb-1 btn-xs m-1 add-new-price"><i class="simple-icon-plus"></i></a>
                                <span class="align-self-center"> ADICIONAR OUTROS VALORES </span>
                            </div>

                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gridRadios1"
                                id="gridRadio2" value="option3">
                            <label class="form-check-label" for="gridRadio3">
                                Taxa fixa
                            </label><br>
                            <small>O envio dos itens é cobrado a uma taxa fixa</small>
                        </div>
                    </div>
                </div>
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm" data-dismiss="modal"><?php echo e(ucfirst($translations["backoffice"]["shipping_btn_cancel"])); ?></button>
                <button type="button" class="btn btn-primary btn-sm save-shipping-method" data-id=""><?php echo e(ucfirst($translations["backoffice"]["shipping_btn_save"])); ?></button>
            </div>
        </div>
    </div>
</div>


<script>

    function shipping() {

        var default_language = null;

        initShipping();

        function initShipping() {

            // Temos de obter as línguas primeiro
            getLanguages(function() {

                // Limpar linguas do modal de editar
                $("#shipping-editor select").html("");
                $("#shipping-languages-list").html("");
                $("#shipping-languages-tabs").html("");
                
 

                // Por cada lingua que tivermos temos de adicionar uma tab
                $.each(window.LANGUAGES, function(key, language) {

                    // Introduzir as linguas no modal de editar
                    $("#shipping-editor select").append(`<option value="` + language.code + `">` +
                        language.name + `</option>`);

                    // Vereficar se é a lingua default ou não
                    (language.default === "1") ? default_language = language.code: null;

                    // Nav links
                    if ($("#shipping-languages-list").find(".nav-item").length < window.LANGUAGES
                        .length) {

                        $("#shipping-languages-list").append(`
                        <li>
                            <a class="nav-link ` + ((language.default === "1") ? "active" : "") +
                            ` text-small" id="language-shipping-tab-` + language.code +
                            `" data-toggle="tab" href="#language-shipping-` + language.code +
                            `" role="tab">` + language.name + `</a>
                        </li>
                    `);

                        // Tabs
                        $("#shipping-languages-tabs").append(`
                        <div class="tab-pane fade ` + ((language.default === "1") ? "active show" : "") +
                            `" id="language-shipping-` + language.code + `" role="tabpanel">
                            <div class="table-responsive">
                                <table class="dt-responsive stripe languages-table dataTable no-footer dtr-inline thetable" id="thetable` + language.code + `" role="grid" style="width: 0px;">
                                    <thead class="thead">
                                        <tr>
                                            <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-sort="ascending" aria-label="Nome: activate to sort column descending"><?php echo e(ucfirst($translations["backoffice"]["shipping_fill_name"])); ?></th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-label="Código: activate to sort column ascending"><?php echo e(ucfirst($translations["backoffice"]["shipping_fill_description"])); ?></th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-label="Autor: activate to sort column ascending"><?php echo e(ucfirst($translations["backoffice"]["shipping_fill_price"])); ?></th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-label="Autor: activate to sort column ascending">#</th>
                                        </tr>
                                    </thead>
                                    <tbody class="shipping-methods-list" id="language-shipping-table-` + language.code + `"></tbody>
                                </table>
                            </div>
                        </div>
                    `);
                    }

                });

                $.ajax({
                    url: "/api/shipping/",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {

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
                        $(".shipping-methods-list").html("");

                        populateShipping(response.data);

                        // Ativar os listners 
                        listnersShipping();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

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

        function populateShipping(items) {

            $.each(items, function(key, shipping) {

                // Adicionar o metodo de envio à lingua correspondente
                $(`#language-shipping-table-` + shipping.lang).append(`
                <tr role="row" class="odd"  data-id="` + shipping.id + `">
                    <th >` + shipping.title + `</th>
                    <td class="w-50">` + shipping.subtitle + `</td>
                    <td >` + Number(shipping.price).toFixed(2) + `€</td>
                    <td>
                        <a href="javascript:void(0)" style="margin-left: 4px;" class="btn btn-outline-danger mb-1 btn-xs m-1 float-right remove-shipping"><i class="simple-icon-trash"></i></a>
                        <a href="javascript:void(0)" class="btn btn-outline-secondary mb-1 btn-xs m-1 float-right edit-shipping"><i class="simple-icon-pencil"></i></a>
                    </td>
                </tr>
            `);

             $(document).ready( function () {
                    $('#thetable'+ shipping.lang ).DataTable();
                       } );

            });
        }

let valorid = 1; 

        function listnersShipping() {


             // Ao clicar no adicionar outros valores
            $(".add-new-price").off("click");
            $(".add-new-price").on("click", function() {
                
                // Adiciomar novo campo
                $(".priceform").append(`
                <div id="v` + valorid + `" class="my-2 "> 
                    <small>Para pedidos com valor abaixo de </small> 
                    <input name="pricelow" type="number" min="0" autocomplete="off" class="form-control w-10 display-IF p-0"> 
                    <small> e acima de </small> 
                    <input name="pricehigh" type="number" min="0" autocomplete="off" class="form-control w-10 display-IF p-0">
                    <small> a combrança é de </small> 
                    <input name="pricefee" type="number" min="0" autocomplete="off" class="form-control w-10 display-IF p-0"> 
                    <a href="#" onclick="$('.priceform #v`+ valorid +`').html('');" class="btn mb-1 btn-xs m-1 delete-price"> 
                        <i class="simple-icon-close"></i> 
                    </a> 
                 </div>`);
            valorid++;
                
            });


            // Ao clicar no adicionar metodo
            $(".add-new-shipping").off("click");
            $(".add-new-shipping").on("click", function() {

                // Alterar o titulo do modal
                $("#shipping-editor .modal-title").text("<?php echo e(ucfirst($translations["backoffice"]["shipping_create_title"])); ?>");

                cleanEditor();

                $("#shipping-editor").modal("show");
            });

            // Ao clicar no editar
            $(".edit-shipping").off("click");
            $(".edit-shipping").on("click", function() {

                cleanEditor();

                // Alterar o titulo do modal
                $("#shipping-editor .modal-title").text("<?php echo e(ucfirst($translations["backoffice"]["shipping_edit_title"])); ?>");

                let id = $(this).closest("tr").data("id");

                // Adicionar o id ao botao de salvar
                $(".save-shipping-method").data("id", id);

                // Introduzir os dados no modal
                $.get("/api/shipping/" + id, function(response) {

                    $.each(response.data, function(key, value) {

                        $("#shipping-editor [name='" + key + "']").val(value);
                    });

                    // Abrir o modal de editar
                    $("#shipping-editor").modal("show");
                });
            });

            //Ao clicar no eliminar
            $(".remove-shipping").off("click");
            $(".remove-shipping").on("click", function() {

                let id = $(this).closest("tr").data("id");

                removeShipping(id);

            });







            // Guardar o método de envio
            $(".save-shipping-method").off("click");
            $(".save-shipping-method").on("click", function() {

                // Vereficar se vamos guardar ou editar
                let id = $(this).data("id");
                let data = $("#shipping-editor form").serialize();

                editShipping(id, data);

                cleanEditor();

                $("#shipping-editor").modal("hide");

                // Retirar o id do data-id para uma proxima ação
                $(this).data("id", "");
            });
        }

        // Eliminar a método de envio
        function removeShipping(id) {

            $.confirm({
                title: '<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>',
                theme: "supervan",
                content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_message_remove_shipping"])); ?>',
                buttons: {

                    Sim: function() {
                        $.ajax({
                            url: "/api/shipping/" + id,
                            // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                            // De texto, etc e em alguns servidores pode dar erro
                            type: "DELETE",
                            dataType: "json",
                            success: function(response) {

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
                                initShipping();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {

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

        function cleanEditor() {

            $("#shipping-editor form").trigger("reset");
        }

        function editShipping(id = "", data) {

            console.log(data);

            $.ajax({
                url: "/api/shipping/" + id,
                type: "POST",
                data: data,
                dataType: "json",
                success: function(response) {

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
                    initShipping();

                },
                error: function(jqXHR, textStatus, errorThrown) {

                    console.log(textStatus, errorThrown);

                    $.alert({
                        title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                        theme: "supervan",
                        content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                    });
                }
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
                    error: function(jqXHR, textStatus, errorThrown) {

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
<?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/pages/config/items/shipping.blade.php ENDPATH**/ ?>