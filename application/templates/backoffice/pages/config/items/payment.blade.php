<h4 class="inline">{{ ucfirst($translations["backoffice"]["methodPayment_title"]) }}</h4>
<hr>
<div class="table-responsive">
    <table id="thetable2" class="dt-responsive stripe languages-table dataTable no-footer dtr-inline" >
        <thead>
            <tr role="row">
                <th >{{ ucfirst($translations["backoffice"]["methodPayment_fill_name"]) }}</th>
                <th >{{ ucfirst($translations["backoffice"]["methodPayment_fill_status"]) }}</th>
                <th >#</th>
            </tr>
        </thead>
        <tbody id="payments-table">

        </tbody>
    </table>
</div>


<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ ucfirst($translations["backoffice"]["methodPayment_settings"]) }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body height-auto">
                <form id="form-method-payment">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">{{ ucfirst($translations["backoffice"]["methodPayment_btn_cancel"]) }}</button>
                <button type="button" class="btn btn-primary btn-save">{{ ucfirst($translations["backoffice"]["methodPayment_btn_save"]) }}</button>
            </div>
        </div>
    </div>
</div>
<script>

function payment() {

    // Carregar os metodos de pagamento
    paymentInit();

    function paymentInit() {

        $.ajax({
			url: "/api/payment/",
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

				// Limpar os métodos da tabela
				$("#payments-table").html("");

				// Inserir as linguas disponveis na tabela
				$.each(response.data, function(key, method) {

                    let badge = (method.active == "1") ? '<span class="badge badge-pill badge-success method-active-button mb-1">{{ ucfirst($translations["backoffice"]["methodPayment_status_active"]) }}</span>' : '<span class="badge badge-pill badge-danger method-active-button mb-1">Desativado</span>';

                    $("#payments-table").append(`
                    <tr data-id="` + method.id + `">
                        <td>` + method.name + `</td>
                        <td>
                            ` + badge + `
                        </td>
                        <td class="text-right">
                            <button type="button" class="btn btn-outline-secondary btn-xs btn-edit" data-id = "` + method.id + `" data-toggle="modal" data-target="#modal-edit "><i class="simple-icon-pencil"></i></button>
                        </td>
                    </tr>`);

                    $(document).ready( function () {
                    $('#thetable2').DataTable();
                       } );

				});

                // Ativar os listners
                paymentMethodListners();
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

    function editpaymentMethod(id = "", data, success_message = true, type) {

        data.type = type
        $.ajax({
			url: "/api/payment/" + id,
			type: "POST",
            data: data,
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
                if(type === "settings"){
                    $("#modal-edit").modal("hide");
                }

                // Recarregar dados da database
                paymentInit()
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

    function getMethodPayment(id) {
        $.ajax({
            url: "/api/payment/" + id,
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

                populateModal(response.data)
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

    function populateModal(method_payment) {
        $("#form-method-payment").html("")
        $.each(method_payment, function (key, setting) {
            let label =  key.replaceAll("_", " ")

            let template = `
                <label class="form-group has-float-label">
                    <input value="` + setting +`" name="` + key +`" type="text"
                           autocomplete="off" class="form-control">
                    <span>` + label.trim().toLowerCase().replace(/\w\S*/g, (w) => (w.replace(/^\w/, (c) => c.toUpperCase()))); +`</span>
                </label>`
            $("#form-method-payment").append(template)
        })
    }

    function getPageData() {

        let data = {};

        // Estamos a utilizar a função serialize para todos os inputs dento de #news-form
        $.each($('#form-method-payment').serializeArray(), function () {

            data[this.name] = this.value;
        });

        console.log(data)
        return data;
    }

	function paymentMethodListners() {

		$("body").off("click", '.method-active-button');
		$("body").on("click", '.method-active-button', function() {

			let id = $(this).closest("tr").data("id");

			if ($(this).hasClass("badge-success")) {

				$(this).removeClass("badge-success").addClass("badge-danger");
				$(this).text("{{ ucfirst($translations["backoffice"]["methodPayment_status_inactive"]) }}");

				// False para nao mostrar mensagem de sucesso
				editpaymentMethod(id, {active: 0, id: id}, false,"status");

			} else {

				$(this).removeClass("badge-danger").addClass("badge-success");
				$(this).text("{{ ucfirst($translations["backoffice"]["methodPayment_status_active"]) }}");

				// False para nao mostrar mensagem de sucesso
				editpaymentMethod(id, {active: 1, id: id}, false, "status");
			}
		})

        $("body").off("click", '.btn-edit');
        $("body").on("click", '.btn-edit', function() {
            getMethodPayment($(this).data("id"))
            $(".btn-save").data("id", $(this).data("id"))
        })

        $("body").off("click", '.btn-save');
        $("body").on("click", '.btn-save', function() {
            console.log($(this).data("id"))
            let data = getPageData()

            editpaymentMethod($(this).data("id"), data, true ,"settings")

        })
	}



}

</script>