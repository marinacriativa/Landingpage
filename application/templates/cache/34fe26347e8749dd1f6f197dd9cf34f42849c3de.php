<h4 class="inline"><?php echo e(ucfirst($translations["backoffice"]["categories"])); ?></h4>
<hr>
<div id="categories_galleries"></div>

<script>

// A função categories é apenas chamada quando clicamos na tab categories
function categories_galleries() {

    categoriesInit();

    function categoriesInit() {

        $.ajax({
            url: "/api/categories_galleries/",
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

                // Vamos transformar a lista de categories numa lista estruturada ( tipo um arvore )
                let categories = listToTree(response.data);

                $("#categories_galleries").html(populateCategories(categories));

                $( ".sortable" ).sortable({
                    items: '> li',
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
                        $('.sortable li').each(function () {
                            id = $(this).attr("data-id");
                            if(ids == '') {
                                ids = id;
                            } else {
                                ids = ids + ',' + id;
                            }
                        })
                        $.ajax({
                            url: "/api/order_categories/",
                            type: "POST",
                            data: {ids: ids},
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
                            }
                        })
                    }
                }).disableSelection();

                // Ativar os listners 
                categoriesListners();
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

    function populateCategories(categories) {

        let template = $("<ul class='sortable p-0'></ul>");

        $.each(categories, function(key, category) {
            let element = category.children.length == 0 ? 'child-element' : 'parent-element';
            let category_template = $(`
                <li data-id="` + category.id + `" class='` + ((category.root == "1") ? "mb-5" : "pl-5") + ` ${element}'>
                    <div data-id="` + category.id + `" class='category-block'>
                        <span>` + category.name + `</span> 
                        <a class="category-action add"><i class='simple-icon-plus float-right mr-3 mt-1'></i></a>
                        ` + ((category.root == "1") ? "" : "<a class='category-action edit'><i class='simple-icon-pencil float-right mr-3 mt-1'></i></a>") + `
                        ` + ((category.root == "1") ? "" : "<a class='category-action remove'><i class='simple-icon-close float-right mr-3 mt-1'></i></a>") + `
                    </div>
                </li>
            `);

            if (category.children.length > 0) {

                // Temos filhos na categoria, vamos chamar a função para adicionar o html
                // Isto chama-se uma função recursiva ou algo parecido, idk, não andei na uni :)

                category_template.append(populateCategories(category.children));
            }

            template.append(category_template[0].outerHTML);
        });
        return template[0].outerHTML;
    }

    function categoriesListners() {

        // Ao clicar no botão remover
        $(".category-action.remove i").off("click");
        $(".category-action.remove i").on("click", function() {

            let id = $(this).closest(".category-block").data("id");

            deleteCategory(id)
        });

        // Ao clicar no botão editar
        $(".category-action.edit i").off("click");
        $(".category-action.edit i").on("click", function() {

            let id          = $(this).closest(".category-block").data("id");
            let old_name    = $(this).closest(".category-block").find("span").text();

            editCategory(id, old_name);
        });

        // Ao clicar no botão adicionar
        $(".category-action.add i").off("click");
        $(".category-action.add i").on("click", function() {

            let id = $(this).closest(".category-block").data("id");

            addCategory(id);
        });
    }

    function addCategory(parent_id) {

        $.confirm({

            title: "<?php echo e(ucfirst($translations["backoffice"]["categories_create_title"])); ?>",
            theme: "supervan",
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label><?php echo e(ucfirst($translations["backoffice"]["categories_fill_name"])); ?></label>' +
            '<input type="text" placeholder="<?php echo e(ucfirst($translations["backoffice"]["categories_placeholder_name"])); ?>" class="name form-control" required />' +
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: '<?php echo e(ucfirst($translations["backoffice"]["categories_btn_save"])); ?>',
                    action: function () {

                        var name = this.$content.find('.name').val();

                        if (!name) {

                            $.alert({
                                title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                theme: "supervan",
                                content: '<?php echo e(ucfirst($translations["backoffice"]["error_message_categories_fill_name_invalid"])); ?>',
                            });

                            return false;
                        }

                        $.ajax({
                            url: "/api/categories_galleries/",
                            type: "POST",
                            data: {name: name, root: "0", parent: parent_id},
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

                                // Recarregar as categorias atraves da database
                                categoriesInit();
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
                },
                Cancelar: function () {

                    //Fechar o modal
                },
            },
            onContentReady: function () {

                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {

                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

    function editCategory(id, old_name) {

        $.confirm({

            title: "<?php echo e(ucfirst($translations["backoffice"]["categories_edit_title"])); ?>",
            theme: "supervan",
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label><?php echo e(ucfirst($translations["backoffice"]["categories_fill_name"])); ?></label>' +
            '<input type="text" placeholder="<?php echo e(ucfirst($translations["backoffice"]["categories_placeholder_name"])); ?>" value="' + old_name + '" class="name form-control" required />' +
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: '<?php echo e(ucfirst($translations["backoffice"]["categories_btn_save"])); ?>',
                    action: function () {

                        var name = this.$content.find('.name').val();

                        if (!name) {

                            $.alert({
                                title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                theme: "supervan",
                                content: '<?php echo e(ucfirst($translations["backoffice"]["error_message_categories_fill_name_invalid"])); ?>',
                            });

                            return false;
                        }

                        $.ajax({
                            url: "/api/categories_galleries/" + id + "?name=" + name,
                            type: "PUT",
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

                                // Recarregar as categorias atraves da database
                                categoriesInit();
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
                },
                Cancelar: function () {

                    //Fechar o modal
                },
            },
            onContentReady: function () {

                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {

                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

    function deleteCategory(id) {

        $.confirm({
            title: "<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>",
            theme: "supervan",
            content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_message_category_remove"])); ?>',
            buttons: {

                Sim: function () {
                    $.ajax({
                        url: "/api/categories_galleries/" + id,
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

                            // Recarregar as categorias atraves da database
                            categoriesInit();
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

    function listToTree(data) {

        const ID_KEY          = "id";
        const PARENT_KEY      = "parent";
        const CHILDREN_KEY    = "children";

        let item, id, parentId;
        let map = {};

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
        };
        
        return data;
    }
}
</script><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/pages/config/items/categories_galleries.blade.php ENDPATH**/ ?>