<h4 class="inline">{{ ucfirst($translations["backoffice"]["menu_manager"]) }}</h4>
<hr>
<div id="menu_manager"></div>
<script>

// A função menus é apenas chamada quando clicamos na tab menus
function menu_manager() {

    menusInit();

    function menusInit() {

        $.ajax({
            url: "/api/menus/",
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

                // Vamos transformar a lista de menus numa lista estruturada ( tipo um arvore )
                let menus = listToTree(response.data);

                $("#menu_manager").html(populateMenus(menus));

                // Ativar os listners 
                menusListners();
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

    function populateMenus(menus) {

        let template = $("<ul class='p-0'></ul>");

        $.each(menus, function(key, menu) {

            let menu_template = $(`
                <li class='` + ((menu.root == "1") ? "mb-5" : "pl-5") + `'>
                    <div data-id="` + menu.id + `" class='menu-block'>
                        <span>` + menu.name + ` </span> <em>` + menu.url + `</em>
                        <a class="menu-action add"><i class='simple-icon-plus float-right mr-3 mt-1'></i></a>
                        ` + ((menu.root == "1") ? "" : "<a class='menu-action edit'><i class='simple-icon-pencil float-right mr-3 mt-1'></i></a>") + `
                        ` + ((menu.root == "1") ? "" : "<a class='menu-action remove'><i class='simple-icon-close float-right mr-3 mt-1'></i></a>") + `
                    </div>
                </li>
            `);

            if (menu.children.length > 0) {

                // Temos filhos na menu, vamos chamar a função para adicionar o html
                // Isto chama-se uma função recursiva ou algo parecido, idk, não andei na uni :)

                menu_template.append(populateMenus(menu.children));
            }

            template.append(menu_template[0].outerHTML);
        });

        return template[0].outerHTML;
    }

    function menusListners() {

        // Ao clicar no botão remover
        $(".menu-action.remove i").off("click");
        $(".menu-action.remove i").on("click", function() {

            let id = $(this).closest(".menu-block").data("id");

            deleteMenu(id)
        });

        // Ao clicar no botão editar
        $(".menu-action.edit i").off("click");
        $(".menu-action.edit i").on("click", function() {

            let id          = $(this).closest(".menu-block").data("id");
            let old_name    = $(this).closest(".menu-block").find("span").text();
            let old_url     = $(this).closest(".menu-block").find("em").text();
            let oldtab      = $(this).closest(".menu-block").find("input[id='newtab']:checked").length > 0;
            
            editMenu(id, old_name, old_url, oldtab);
        });

        // Ao clicar no botão adicionar
        $(".menu-action.add i").off("click");
        $(".menu-action.add i").on("click", function() {

            let id = $(this).closest(".menu-block").data("id");

            addMenu(id);
        });
    }

    function addMenu(parent_id) {

        $.confirm({

            title: "{{ ucfirst($translations["backoffice"]["menus_create_title"]) }}",
            theme: "supervan",
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label>{{ ucfirst($translations["backoffice"]["menus_fill_name"]) }}</label>' +
            '<input type="text" placeholder="{{ ucfirst($translations["backoffice"]["menus_placeholder_name"]) }}" class="name form-control" required /> <br>' +
            '<label>{{ ucfirst($translations["backoffice"]["url_fill_name"]) }}</label>' +
            '<input type="text" placeholder="{{ ucfirst($translations["backoffice"]["menus_placeholder_url"]) }}" class="url form-control" required /> <br>' +
            '<input type="checkbox" id="newtab" name="newtab"> ' +
            '<label>{{ ucfirst($translations["backoffice"]["newtab"]) }}</label>' +
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: '{{ ucfirst($translations["backoffice"]["menus_btn_save"]) }}',
                    action: function () {

                        var name = this.$content.find('.name').val();
                        var url = this.$content.find('.url').val();
                        var newtab = this.$content.find("input[id='newtab']:checked").length > 0;

                        if (!name) {

                            $.alert({
                                title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                theme: "supervan",
                                content: '{{ ucfirst($translations["backoffice"]["error_message_menus_fill_name_invalid"]) }}',
                            });

                            return false;
                        } else if (!url) {
                            $.alert({
                                title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                theme: "supervan",
                                content: '{{ ucfirst($translations["backoffice"]["error_message_menus_fill_url_invalid"]) }}',
                            });

                            return false;
                        }

                        $.ajax({
                            url: "/api/menus/",
                            type: "POST",
                            data: {name: name, root: "0", parent: parent_id, url: url, newtab: newtab},
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

                                // Recarregar as menus atraves da database
                                menusInit();
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

    function editMenu(id, old_name, old_url, oldtab) {

        let checked = oldtab == true ? 'checked' : '';
        $.confirm({

            title: "{{ ucfirst($translations["backoffice"]["menus_edit_title"]) }}",
            theme: "supervan",
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label>{{ ucfirst($translations["backoffice"]["menus_fill_name"]) }}</label>' +
            '<input type="text" placeholder="{{ ucfirst($translations["backoffice"]["menus_placeholder_name"]) }}" value="' + old_name + '" class="name form-control" required /><br>' +
            '<label>{{ ucfirst($translations["backoffice"]["url_fill_name"]) }}</label>' +
            '<input type="text" placeholder="{{ ucfirst($translations["backoffice"]["menus_placeholder_url"]) }}" value="' + old_url + '" class="url form-control" required /> <br>' +
            '<input type="checkbox" id="newtab" name="newtab" '+checked+'> ' +
            '<label>{{ ucfirst($translations["backoffice"]["newtab"]) }}</label>' +
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: '{{ ucfirst($translations["backoffice"]["menus_btn_save"]) }}',
                    action: function () {

                        var name = this.$content.find('.name').val();
                        var url = this.$content.find('.url').val();
                        var newtab = this.$content.find("input[id='newtab']:checked").length > 0;


                        if (!name) {

                            $.alert({
                                title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                theme: "supervan",
                                content: '{{ ucfirst($translations["backoffice"]["error_message_menus_fill_name_invalid"]) }}',
                            });

                            return false;
                        } else if (!url) {
                            $.alert({
                                title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                theme: "supervan",
                                content: '{{ ucfirst($translations["backoffice"]["error_message_menus_fill_url_invalid"]) }}',
                            });

                            return false;
                        }

                        $.ajax({
                            url: "/api/menus_update/" + id,
                            data: {name: name, url: url, newtab: newtab},
                            type: "POST",
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

                                // Recarregar as menus atraves da database
                                menusInit();
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

    function deleteMenu(id) {

        $.confirm({
            title: "{{ ucfirst($translations["backoffice"]["confirm"]) }}",
            theme: "supervan",
            content: '{{ ucfirst($translations["backoffice"]["confirm_message_menu_remove"]) }}',
            buttons: {

                Sim: function () {
                    $.ajax({
                        url: "/api/menus/" + id,
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

                            // Recarregar as menus atraves da database
                            menusInit();
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
                    data.splice( i, 1 );                                    // Remover a menu do root
                    i--;                                                    // Corrigir a iteração

                } else {

                    data[i][PARENT_KEY] = 0;
                }
            }
        };
        
        return data;
    }
}
</script>