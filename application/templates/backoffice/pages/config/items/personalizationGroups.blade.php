<h4 class="inline">{{ ucfirst($translations["backoffice"]["customizeGroups_title"]) }}</h4>
<hr>
<div id="personalizationGroups"></div>
<script>

// A função categories é apenas chamada quando clicamos na tab categories
function personalizationGroups() {

    personalizationGroupsInit();

    function personalizationGroupsInit() {

        $.ajax({
            url: "/api/personalization/",
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

                // Vamos transformar a lista de categories numa lista estruturada ( tipo um arvore )
                let personalizationGroup = listToTree(response.data);

                $("#personalizationGroups").html(populatePersonalizationGroup(personalizationGroup));

                // Ativar os listners 
                personalizationGroupListners();
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

    function populatePersonalizationGroup(personalizations) {

        let template = $("<ul class='p-0'></ul>");

        $.each(personalizations, function(key, personalization) {

            let personalizationGroup_template = $(`
                <li class='` + ((personalization.root == "1") ? "mb-5" : "pl-5") + `'>
                    <div data-id="` + personalization.id + `" class='personalizationGroup-block'>
                        <span>` + personalization.name + `</span>
                        ` + ((personalization.root != "1") ? "" : "<a class='personalizationGroup-action add'><i class='simple-icon-plus float-right mr-3 mt-1'></i></a>") + `

                        ` + ((personalization.root == "1") ? "" : "<a class='personalizationGroup-action edit'><i class='simple-icon-pencil float-right mr-3 mt-1'></i></a>") + `
                        ` + ((personalization.root == "1") ? "" : "<a class='personalizationGroup-action remove'><i class='simple-icon-close float-right mr-3 mt-1'></i></a>") + `
                    </div>
                </li>
            `);

            if (personalization.children.length > 0) {

                // Temos filhos na categoria, vamos chamar a função para adicionar o html
                // Isto chama-se uma função recursiva ou algo parecido, idk, não andei na uni :)

                personalizationGroup_template.append(populatePersonalizationGroup(personalization.children));
            }

            template.append(personalizationGroup_template[0].outerHTML);
        });

        return template[0].outerHTML;
    }

    function personalizationGroupListners() {

        // Ao clicar no botão remover
        $(".personalizationGroup-action.remove i").off("click");
        $(".personalizationGroup-action.remove i").on("click", function() {

            let id = $(this).closest(".personalizationGroup-block").data("id");

            deletePersonalizationGroup(id)
        });

        // Ao clicar no botão editar
        $(".personalizationGroup-action.edit i").off("click");
        $(".personalizationGroup-action.edit i").on("click", function() {

            let id          = $(this).closest(".personalizationGroup-block").data("id");
            let old_name    = $(this).closest(".personalizationGroup-block").find("span").text();

            editPersonalizationGroup(id, old_name);
        });

        // Ao clicar no botão adicionar
        $(".personalizationGroup-action.add i").off("click");
        $(".personalizationGroup-action.add i").on("click", function() {

            let id = $(this).closest(".personalizationGroup-block").data("id");

            addPersonalizationGroup(id);
        });
    }

    function addPersonalizationGroup(parent_id) {

        $.confirm({

            title: "{{ ucfirst($translations["backoffice"]["customizeGroups_create_title"]) }}",
            theme: "supervan",
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label>{{ ucfirst($translations["backoffice"]["customizeGroups_fill_name"]) }}</label>' +
            '<input type="text" placeholder="Nome do grupo" class="name form-control" required />' +
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: 'Adicionar!',
                    action: function () {

                        var name = this.$content.find('.name').val();

                        if (!name) {

                            $.alert({
                                title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                theme: "supervan",
                                content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                            });

                            return false;
                        }

                        $.ajax({
                            url: "/api/personalization/",
                            type: "POST",
                            data: {name: name, root: "0", parent: parent_id},
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

                                // Recarregar as categorias atraves da database
                                personalizationGroupsInit();
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

    function editPersonalizationGroup(id, old_name) {

        $.confirm({

            title: "{{ ucfirst($translations["backoffice"]["customizeGroups_edit_title"]) }}",
            theme: "supervan",
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label>{{ ucfirst($translations["backoffice"]["customizeGroups_fill_name"]) }}</label>' +
            '<input type="text" placeholder="Nome do grupo" value="' + old_name + '" class="name form-control" required />' +
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: 'Editar!',
                    action: function () {

                        var name = this.$content.find('.name').val();

                        if (!name) {

                            $.alert({
                                title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                theme: "supervan",
                                content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                            });

                            return false;
                        }

                        $.ajax({
                            url: "/api/personalization/" + id + "?name=" + name,
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

                                // Recarregar as categorias atraves da database
                                personalizationGroupsInit();
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

    function deletePersonalizationGroup(id) {

        $.confirm({
            title: "{{ ucfirst($translations["backoffice"]["confirm"]) }}",
            theme: "supervan",
            content: '{{ ucfirst($translations["backoffice"]["confirm_message_remove_customizeGroups"]) }}',
            buttons: {

                Sim: function () {
                    $.ajax({
                        url: "/api/personalization/" + id,
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

                            // Recarregar as categorias atraves da database
                            personalizationGroupsInit();
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
</script>