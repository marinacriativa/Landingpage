<div class="modal fade modal-right" id="new-language" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<form id="language-form">
					<div class="form-group">
						<label><?php echo e(ucfirst($translations["backoffice"]["language_fill_name"])); ?></label>
						<input name="name" placeholder="<?php echo e(ucfirst($translations["backoffice"]["language_placeholder_name"])); ?>" class="form-control">
					</div>
					<div class="form-group">
						<label><?php echo e(ucfirst($translations["backoffice"]["language_fill_code"])); ?></label>
						<input name="code" placeholder="<?php echo e(ucfirst($translations["backoffice"]["language_placeholder_code"])); ?>" class="form-control">
					</div>
					<div class="form-group">
						<label><?php echo e(ucfirst($translations["backoffice"]["language_fill_author"])); ?></label>
						<input name="author" placeholder="<?php echo e(ucfirst($translations["backoffice"]["language_placeholder_author"])); ?>" class="form-control">
					</div>
					<div class="form-group">
						<label><?php echo e(ucfirst($translations["backoffice"]["language_fill_initial_status_order"])); ?></label>
						<input name="default_state1" placeholder="<?php echo e(ucfirst($translations["backoffice"]["language_placeholder_initial_status_order"])); ?>" class="form-control">
					</div>
					<div class="form-group">
						<label><?php echo e(ucfirst($translations["backoffice"]["language_fill_initial_status_payment"])); ?>/label>
						<input name="default_state2" placeholder="<?php echo e(ucfirst($translations["backoffice"]["language_placeholder_initial_status_payment"])); ?>" class="form-control">
					</div>
					<div class="form-group">
						<label><?php echo e(ucfirst($translations["backoffice"]["language_fill_concluded_status_payment"])); ?></label>
						<input name="default_state3" placeholder="<?php echo e(ucfirst($translations["backoffice"]["language_placeholder_concluded_status_payment"])); ?>" class="form-control">
					</div>
					<hr>
					<div class="form-group">
						<label><?php echo e(ucfirst($translations["backoffice"]["language_copy"])); ?></label>
						<select name="clone" class="form-control">
							<option value="1">Português</option>
							<option value="7">Inglês</option>
							<option value="8">Espanhol</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-primary" data-dismiss="modal"><?php echo e(ucfirst($translations["backoffice"]["language_btn_cancel"])); ?></button>
				<button type="button" class="btn btn-primary save-button"><?php echo e(ucfirst($translations["backoffice"]["language_btn_save"])); ?></button>
			</div>
		</div>
	</div>
</div>
<h4 class="inline"><?php echo e(ucfirst($translations["backoffice"]["language_translation"])); ?></h4>
<div class="top-right-button-container ">
    <button type="button" data-toggle="modal" data-target="#new-language" class="btn btn-outline-primary btn-xs new-family"><?php echo e(ucfirst($translations["backoffice"]["language_btn_create"])); ?></button>
</div>
<hr>
<div class="table-responsive">
    <table class="dt-responsive stripe languages-table dataTable no-footer dtr-inline" id="thetable4" role="grid" style="width: 0px;">
        <thead class="thead">
            <tr>
                <th><?php echo e(ucfirst($translations["backoffice"]["language_fill_name"])); ?></th>
                <th><?php echo e(ucfirst($translations["backoffice"]["language_fill_code"])); ?></th>
                <th><?php echo e(ucfirst($translations["backoffice"]["language_fill_author"])); ?></th>
                <th><?php echo e(ucfirst($translations["backoffice"]["language_fill_status"])); ?></th>
                <th>#</th>
            </tr>
        </thead>
        <tbody id="translations-table">
            
        </tbody>
    </table>
</div>



<script>

function languages() {

    // Carregar as línguas
    translations();

    function translations() {

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

				// Limpar linguas
				$("#translations-table").html("");

				// Inserir as linguas disponveis na tabela
				$.each(response.data, function(key, translation) {

                    if(translation.default == 1){
						let badge = (translation.active == "1") ? '<span class="badge badge-pill badge-success mb-1"><?php echo e(ucfirst($translations["backoffice"]["language_status_active"])); ?></span>' : '<span class="badge badge-pill badge-danger mb-1"><?php echo e(ucfirst($translations["backoffice"]["language_status_inactive"])); ?></span>';

						$("#translations-table").append(`
                        <tr data-id="` + translation.id + `">
                            <td>` + translation.name + `</td>
                            <td>
                                <span class="badge badge-pill badge-info mb-1 text-uppercase">` + translation.code + `</span>
                            </td>
                            <td>` + translation.author + `</td>
                            <td>
                                ` + badge + `
                            </td>
                            <td class="text-right">
                                <a class="btn btn-outline-secondary btn-xs m-1 " href="/adm/translations/` + translation.id + `"><i class="simple-icon-pencil"></i></a>
                                
								<a class="btn btn-light btn-xs m-1 disabled" disabled><i class="simple-icon-star" disabled></i></a>

                            </td>
                        </tr>`);
					}else{
						let badge = (translation.active == "1") ? '<span class="badge badge-pill badge-success translation-active-button mb-1"><?php echo e(ucfirst($translations["backoffice"]["language_status_active"])); ?></span>' : '<span class="badge badge-pill badge-danger translation-active-button mb-1"><?php echo e(ucfirst($translations["backoffice"]["language_status_inactive"])); ?></span>';

						$("#translations-table").append(`
                        <tr role="row" class="odd" data-id="` + translation.id + `">
                            <td>` + translation.name + `</td>
                            <td>
                                <span class="badge badge-pill badge-info mb-1 text-uppercase">` + translation.code + `</span>
                            </td>
                            <td>` + translation.author + `</td>
                            <td>
                                ` + badge + `
                            </td>
                            <td class="text-right">
                                <a class="btn btn-outline-secondary mb-1 btn-xs m-1" href="/adm/translations/` + translation.id + `"><i class="simple-icon-pencil"></i></a>
                                <a class="btn btn-outline-danger mb-1 btn-xs m-1" href="#" data-id="` + translation.id +`"><i class="simple-icon-trash"></i></a>
                            </td>
                        </tr>`);
					}

					$(document).ready( function () {
                    $('#thetable4').DataTable();
                       } );

				});

                // Ativar os listners
                languageListners();
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

    function editLanguage(id = "", data, success_message = true) {
        $.ajax({
			url: "/api/translations/" + id,
			type: "POST",
            data: {lang: data},
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
				console.log(response.data)

				// Inserir as linguas disponveis na tabela
				$.each(response.data, function(key, translation) {

                    let badge = (translation.active == "1") ? '<span class="badge badge-pill badge-success translation-active-button mb-1 w-100"><?php echo e(ucfirst($translations["backoffice"]["language_status_active"])); ?></span>' : '<span class="badge badge-pill badge-danger translation-active-button mb-1 w-100"><?php echo e(ucfirst($translations["backoffice"]["language_status_inactive"])); ?></span>';

					$("#translations-table").append(`
                        <tr data-id="` + translation.id + `">
                            <td>` + translation.name + `</td>
                            <td>
                                <span class="badge badge-pill badge-info mb-1 text-uppercase">` + translation.code + `</span>
                            </td>
                            <td>` + translation.author + `</td>
                            <td>
                                ` + badge + `
                            </td>
                            <td class="text-right">
                                <a class="btn btn-outline-secondary mb-1 btn-xs m-1" href="/adm/translations/` + translation.code + `"><i class="simple-icon-pencil"></i></a>
                                <a class="btn btn-outline-danger mb-1 btn-xs m-1" href="#"><i class="simple-icon-trash"></i></a>
                            </td>
                        </tr>`);
				});

                // Ativar os listners
                languageListners();
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

	function saveLanguage(data) {
		$.ajax({
			url: "/api/translations/",
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
				console.log("data",response.data)

				let dataCategory = {
					name: response.data.name,
					lang: response.data.code,
					root: 1
				}

				$("#new-language").modal("hide")
				clearFormNewLanguage()

				let badge = (response.data.active == "1") ? '<span class="badge badge-pill badge-success translation-active-button mb-1 w-100"><?php echo e(ucfirst($translations["backoffice"]["language_status_active"])); ?></span>' : '<span class="badge badge-pill badge-danger translation-active-button mb-1 w-100"><?php echo e(ucfirst($translations["backoffice"]["language_status_inactive"])); ?></span>';


				$("#translations-table").append(`
                        <tr data-id="` + response.data.id + `">
                            <td>` + response.data.name + `</td>
                            <td>
                                <span class="badge badge-pill badge-info mb-1 text-uppercase">` + response.data.code + `</span>
                            </td>
                            <td>` + response.data.author + `</td>
                            <td>
                                ` + badge + `
                            </td>
                            <td class="text-right">
                                <a class="btn btn-outline-secondary mb-1 btn-xs m-1" href="/adm/translations/` + response.data.id + `"><i class="simple-icon-pencil"></i></a>
                                <a class="btn btn-outline-danger mb-1 btn-xs m-1" href="#" data-id="` + response.data.id +`"><i class="simple-icon-trash"></i></a>
                            </td>
                        </tr>`);


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
	
	function deleteLanguage(object) {

		let id = $(object).data("id");

		$.ajax({
			url: "/api/translations/" + id,
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
				$(object).closest("tr").remove();
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
	
	function clearFormNewLanguage() {
    	$("[name='name']").val("");
    	$("[name='code']").val("");
    	$("[name='author']").val("");
    	$("[name='default_state1']").val("");
    	$("[name='default_state2']").val("");
    	$("[name='default_state3']").val("");
    	$("[name='clone']").val(1);
	}

	function languageListners() {

		$("body").off("click", '.translation-active-button');
		$("body").on("click", '.translation-active-button', function() {

			let id = $(this).closest("tr").data("id");

			if ($(this).hasClass("badge-success")) {

				$(this).removeClass("badge-success").addClass("badge-danger");
				$(this).text("<?php echo e(ucfirst($translations["backoffice"]["language_status_inactive"])); ?>");

				// False para nao mostrar mensagem de sucesso
				editLanguage(id, {active: 0, id: id}), false;

			} else {

				$(this).removeClass("badge-danger").addClass("badge-success");
				$(this).text("<?php echo e(ucfirst($translations["backoffice"]["language_status_active"])); ?>");

				// False para nao mostrar mensagem de sucesso
				editLanguage(id, {active: 1, id: id}, false);
			}
		})

		$(".save-button").off("click");
		$(".save-button").on("click", function() {
			let data = {}
			$.each($('#language-form').serializeArray(), function () {

				data[this.name] = this.value;
			});
			saveLanguage(data)
		})
		$("body").off("click", '.delete-language');
		$("body").on("click", '.delete-language', function() {

			let object = $(this);

			$.confirm({
				title: '<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>',
				content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_delete_language"])); ?>',
				theme: 'supervan',
				buttons: {
					yes: {
						keys: ['enter'],
						text: '<?php echo e(ucfirst($translations["backoffice"]["yes"])); ?>',
						action: function () {

							deleteLanguage(object);
						}
					},
					no: {
						keys: ['esc'],
						text: "<?php echo e(ucfirst($translations["backoffice"]["no"])); ?>",
						action: function () {
						}
					},
				}
			});
		})
	}

}

</script><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/pages/config/items/languages.blade.php ENDPATH**/ ?>