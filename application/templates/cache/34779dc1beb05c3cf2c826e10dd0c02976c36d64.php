
<?php $__env->startSection('content'); ?>
<main class="default-transition pt-5 mb-5 collapsable-main no-load">
	<div class="p-desktop-5">
		<div class="row">
			<div class="col-md-12 mb-8">
				<div class="col-12">
					<h1><?php echo e(ucfirst($translations["backoffice"]["title_edit_filters"])); ?></h1>
                    
					<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
						<ol class="breadcrumb pt-0">
							<li class="breadcrumb-item"><a href="/adm"><?php echo e(ucfirst($translations["backoffice"]["store"])); ?></a></li>
							<li class="breadcrumb-item"><a href="/adm/filters"><?php echo e(ucfirst($translations["backoffice"]["filters"])); ?></a></li>
							<li class="breadcrumb-item active" aria-current="page"><?php echo e(ucfirst($translations["backoffice"]["title_edit_filters"])); ?></li>
						</ol>
					</nav>
                    <div class="btn-group top-right-button-container">
                        <button type="button" href="javascript:void(0)" onclick='javascript:window.location.assign("/adm/filters");' class="btn btn-outline-secondary"><?php echo e(ucfirst($translations["backoffice"]["edit_custom_btn_back"])); ?></button>
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
                    </div>
					<div class="separator mb-5"></div>
				</div>
				<form id="filter-form">
					<div class="contact-form clearfix">
						<div class="row">
							<div class="col-md-12 col-xl-8 col-sm-12 col-xs-12 mb-3">
								<div class="card">
									<div class="card-body">
										<h5><i class="simple-icon-notebook mr-2"></i><?php echo e(ucfirst($translations["backoffice"]["edit_product_basic_informations"])); ?></h5>
										<hr>
                                        <div class="row">                                         
                                            <div class="form-group mt-4 col-6"><label class="form-group has-float-label"> <input name="name" id="name_x" type="text" autocomplete="off" class="form-control"> <span><?php echo e(ucfirst($translations["backoffice"]["filters_title"])); ?></span> </label> </div>
                                            <?php if($countLangs > 1): ?>                                                   
                                                <div class="form-group mt-4 col-3">                                                    
                                                    <select name="lang" class="form-control">
                                                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option class="options_langs" value="<?php echo e($langs->code); ?>" selected="false"><?php echo e($langs->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            <?php endif; ?> 
                                            <div class="form-group mt-4 col-3">
                                                <button type="button" data-action="add" class="btn btn-outline-info btn-xs mt-2 mr-2">Adicionar Opção</button> 
                                            </div>                                            
                                        </div>                                                                 
										
                                        <br>
                                        <div class="row">
                                            <div class="col-12" id="categories">
                                                
                                            </div>
                                        </div>
									</div>
								</div>								
                            </div>
							<div class="col-md-12 col-xl-4 col-sm-12 col-xs-12">
								<div class="card">
									<div class="col-12">
										<div class="card-body">
											<button type="button" data-action="delete" class="btn btn-outline-danger btn-xs mt-2 mr-2"><?php echo e(ucfirst($translations["backoffice"]["edit_product_btn_remove"])); ?></button> 
                                            <button type="button" data-action="save-filter" class="btn btn-outline-info btn-xs mt-2 mr-2"><?php echo e(ucfirst($translations["backoffice"]["edit_product_btn_save"])); ?></button> 
                                            <div class="form-group mt-3">
                                                <label>Multipla seleção</label> 
												<div class="custom-switch custom-switch-secondary mb-2 custom-switch-small"> <input class="custom-switch-input" id="featuredSwitch" type="checkbox"> <label rel="tooltip" title="Pode ter mais de um item selecionado" class="custom-switch-btn" for="featuredSwitch"></label> </div>
											</div>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>

        var filter_id = 0;

        init();

        function init() {


        // Vamos buscar o url pretendido para ver se a página vai editar ou adicionar novo produto
        var page = new RegExp('^/adm/filters/.*');


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

                filter_id = wildcard;


                //Atribuir o id ao campo "save"
                $('[data-action="save-filter"]').data("id", wildcard)

            }
        }
    }

    function load(id) {

        $.ajax({
            url: "/api/filters/" + id,
            type: "GET",
            dataType: "json",
            success: function (response) {

                console.log('a');

                if (!response.success) {

                    // Output do erro
                    console.error(response);

                    $.alert({
                        title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                        theme: "supervan",
                        content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>'
                    });

                    // Não deixar a função executar mais
                    return;
                }

                // Procurar todos os elementos por name="" e meter os dados da api
                $.each(response.data, function (key, value) {

                    switch (key) {
                        case "is_multiple":

                            $("#featuredSwitch").prop('checked', (value == "1"));

                            break;

                        case "lang":                          

                            $('[name="lang"]').val(value);

                            break;

                        default:

                            $(`[name="` + key + `"]`).val(value);

                            break;
                    }                  

                });


                categoriesInit()                

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

    // Obter as informações da página
    function getPageData() {

        let data = {};

        console.log('test', $('#filter-form').serializeArray());

        // Estamos a utilizar a função serialize para todos os inputs dento de #filter-form
        $.each($('#filter-form').serializeArray(), function () {
            data[this.name] = this.value;
        });

        return data;
    }

    function save(id = "", data) {

        data.is_multiple = ($("#featuredSwitch").prop('checked') ? "1" : "0");

        $.confirm({
            title: '<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>',
            theme: "supervan",
            content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_product_save"])); ?>',
            buttons: {

                Sim: function () {
                    $.ajax({
                        url: "/api/filters/" + id,
                        type: "POST",
                        data: data,
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
    
    function removeFilter(id) {
            $.confirm({
                title: '<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>',
                theme: "supervan",
                content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_product_remove"])); ?>',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/filters/" + id,
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

                                // Redirecionar para a página de index dos filtros
                                window.location.replace("/adm/filters/");
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
    
    //filter items

    function categoriesInit() {

        $.ajax({
            url: "/api/filter_items/" + filter_id,
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

                $("#categories").html(populateCategories(categories));

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
                                url: "/api/order_filter_items",
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
                    })


                // Ativar os listners 
                listners();
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

        let template = $("<ul class='p-0 sortable'></ul>");

        $.each(categories, function(key, category) {
            let category_template = $(`
                <li data-id="` + category.id + `" class=' all-scroll mb-5")'>
                    <div data-id="` + category.id + `" class='category-block'>
                        <span>` + category.name + `</span>   
                        ` + ((category.root == "1") ? "" : "<a class='category-action edit'><i class='simple-icon-pencil float-right mr-3 mt-1'></i></a>") + `
                        ` + ((category.root == "1") ? "" : "<a class='category-action remove'><i class='simple-icon-close float-right mr-3 mt-1'></i></a>") + `
                    </div>
                </li>
            `);

            template.append(category_template[0].outerHTML);
        });

        return template[0].outerHTML;
    }

    function addCategory(filter_id) {

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
                            url: "/api/filter_items/" + filter_id,
                            type: "POST",
                            data: {name: name},
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
                        url: "/api/filter_items/" + id,
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
                            url: "/api/filter_items/" + id + "?name=" + name,
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

    function listners() {

        $("body").off('click', "[data-action='save-filter']");
        $("body").on('click', "[data-action='save-filter']", function () {           

            let data = getPageData();

            // Ao clicar no botao de guardar, vamos buscar o id do produto guardado no elemento
            save($('[data-action="save-filter"]').data("id"), data);
        });

        $("body").off('click', "[data-action='delete']");
        $("body").on('click', "[data-action='delete']", function () { 

            let idFilter = $('[data-action="save-filter"]').data("id");

            removeFilter(idFilter);

        });

        // Ao clicar no botão remover
        $("body").off('click', ".category-action.remove i");
        $("body").on('click', ".category-action.remove i", function () { 

            let id = $(this).closest(".category-block").data("id");

            deleteCategory(id)
        });

        // Ao clicar no botão editar
        $("body").off('click', ".category-action.edit i");
        $("body").on('click', ".category-action.edit i", function () { 

            let id          = $(this).closest(".category-block").data("id");
            let old_name    = $(this).closest(".category-block").find("span").text();

            editCategory(id, old_name);
        });

        // Ao clicar no botão adicionar
        $("body").off('click', "[data-action='add']");
        $("body").on('click', "[data-action='add']", function () { 
            addCategory(filter_id);
        });
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/pages/filters/page.blade.php ENDPATH**/ ?>