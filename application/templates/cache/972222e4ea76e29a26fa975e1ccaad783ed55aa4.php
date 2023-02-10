	<h4 class="w-100"><?php echo e(ucfirst($translations["backoffice"]["banner_title"])); ?>

	<a href="#" class="btn btn-xs btn-outline-primary float-right add-new-banners"><?php echo e(ucfirst($translations["backoffice"]["banner_btn_create"])); ?></a>
</h4>
<hr>
<div class="row mt-2">
    <div class="col-12">
        <ul class="nav nav-tabs mb-4" id="big-banners-languages-list" role="tablist"></ul>
        <div class="tab-content" id="big-banners-languages-tabs">
        </div>
    </div>
</div>


<div class="modal fade modal-right" id="big-banners-modal" tabindex="-1" role="dialog" aria-labelledby="big-banners-modal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
			<form>
					<h3></h3>
					<hr>
					<div class="nav nav-tabs nav-fill mb-2" role="tablist">
						<a class="nav-item nav-link active" data-toggle="tab" href="#banners-image" role="tab">Imagem</a>
						<a class="nav-item nav-link" data-toggle="tab" href="#banners-video" role="tab">Video</a>
					</div>
					<div class="tab-content" id="nav-tabContent">
						<div class="tab-pane fade show active" id="banners-image" role="tabpanel">
							<div id="banner-image"></div>
						</div>
						<div class="tab-pane fade" id="banners-video" role="tabpanel">
							<h6 style="d-block mb-2">Max: 1.5MB MP4</h6>
							<input id="file-input" type="file" accept="video/*" class="form-control">
							<video id="video" width="100%" height="300" controls></video>
						</div>
					</div>
					<div class="form-group mt-3">
						<label><?php echo e(ucfirst($translations["backoffice"]["banner_fill_title"])); ?></label>
						<input name="title" class="form-control">
					</div>
					<div class="form-group">
						<label><?php echo e(ucfirst($translations["backoffice"]["banner_fill_subTitle"])); ?></label>
						<input name="subtitle" class="form-control">
					</div>
					<div class="form-group">
						<label><?php echo e(ucfirst($translations["backoffice"]["banner_fill_description"])); ?></label>
						<input name="description" class="form-control">
					</div>
					<div class="form-group">
						<label><?php echo e(ucfirst($translations["backoffice"]["banner_fill_btn_text"])); ?></label>
						<input name="button_text" class="form-control">
					</div>
					<div class="form-group">
						<label><?php echo e(ucfirst($translations["backoffice"]["banner_fill_url"])); ?></label>
						<input name="link" class="form-control">
					</div>
					<div class="form-group">
						<label><?php echo e(ucfirst($translations["backoffice"]["banner_fill_language"])); ?></label>
						<select name="lang" class="form-control">
						</select>
					</div>
					<fieldset class="form-group">
						<div class="row">
							<label class="col-form-label col-lg-12 pt-0"><?php echo e(ucfirst($translations["backoffice"]["banner_fill_alignment"])); ?></label>
							<div class="col-lg-12">
								<div class="form-check">
									<input class="form-check-input" type="radio" name="align" id="align-left-new" value="left" checked>
									<label class="form-check-label" for="align-left-new"><?php echo e(ucfirst($translations["backoffice"]["banner_alignment_left"])); ?></label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="align" id="align-center-new" value="center">
									<label class="form-check-label" for="align-center-new"><?php echo e(ucfirst($translations["backoffice"]["banner_alignment_center"])); ?></label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="align" id="align-right-new" value="right">
									<label class="form-check-label" for="align-right-new"><?php echo e(ucfirst($translations["backoffice"]["banner_alignment_right"])); ?></label>
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset class="form-group">
						<div class="row">
							<label class="col-form-label col-lg-12 pt-0"><?php echo e(ucfirst($translations["backoffice"]["banner_fill_text_color"])); ?></label>
							<div class="col-lg-12">
								<div class="form-check">
									<input class="form-check-input" type="radio" name="color" id="color-white-new" value="white" checked>
									<label class="form-check-label" for="color-white-new"><?php echo e(ucfirst($translations["backoffice"]["banner_text_color_white"])); ?></label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="color" id="color-black-new" value="black">
									<label class="form-check-label" for="color-black-new"><?php echo e(ucfirst($translations["backoffice"]["banner_text_color_black"])); ?></label>
								</div>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light btn-sm" data-dismiss="modal"><?php echo e(ucfirst($translations["backoffice"]["banner_btn_cancel"])); ?></button>
				<button type="button" class="btn btn-danger remove-banners btn-sm"><?php echo e(ucfirst($translations["backoffice"]["banner_btn_remove"])); ?></button>
				<button type="button" class="btn btn-primary save-banner btn-sm"><?php echo e(ucfirst($translations["backoffice"]["banner_btn_save"])); ?></button>
			</div>
		</div>
	</div>
</div>
<script>	

	function banners() {
	
	    var default_language = null;
		var uploaded_video   = null;
	
	    initBanners();
	
	    function initBanners() {

			videoUploadListners();
			
			$("#banner-image").slim(slimDefaultConfig( { folder: 'banners' }, "16:9" ));
	
	        // Temos de obter as línguas primeiro
	        getLanguages(function() {
	
	            // Limpar linguas do modal de editar
	            $("#big-banners-modal select").html("");
	
	            // Por cada lingua que tivermos temos de adicionar uma tab
	            $.each(window.LANGUAGES, function(key, language) {
	
	                // Introduzir as linguas no modal de editar
	                $("#big-banners-modal select").append(`<option value="` + language.code + `">` + language.name + `</option>`);
	
	                // Vereficar se é a lingua default ou não
	                (language.default === "1") ? default_language = language.code: null;
	
	                // Nav links
	                if ($("#big-banners-languages-list").find(".nav-item").length < window.LANGUAGES.length) {
	
	                    $("#big-banners-languages-list").append(`
							<li class="nav-item col p-0">
								<a class="nav-link ` + ((language.default === "1") ? "active" : "") +
								` text-muted text-small" id="language-big-banners-tab-` + language.code +
								`" data-toggle="tab" href="#language-big-banners-` + language.code +
								`" role="tab">` + language.name + `</a>
							</li>
	                	`);
	
	                    // Tabs
	                    $("#big-banners-languages-tabs").append(`
	                    <div class="tab-pane fade ` + ((language.default === "1") ? "active show" : "") +
	                        `" id="language-big-banners-` + language.code + `" role="tabpanel">
							<div class="row list disable-text-selection banners-methods-list" id="language-big-banners-table-` + language.code + `"></div>
	                    </div>
	                `);
	                }
	            });
	
	            $.ajax({
	                url: "/api/banners/",
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
	                    $(".banners-methods-list").html("");
	
	                    populatebanners(response.data);

	                    // Ativar os listners 
	                    listnersbanners();
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
	
	    function populatebanners(items) {
	
	        $.each(items, function(key, banners) {			

				content = banners.photo ? `<img class="card-img-top" src="${banners.photo}" alt="${banners.title}">` : `
					<video class="card-img-top" controls>
						<source src="${banners.video}" type="video/mp4">
					</video>`;
	            // Adicionar o banner à lingua correspondente
	            $(`#language-big-banners-table-` + banners.lang).append(`
					<div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4 edit-banners" data-id="` + banners.id + `">
						<div class="card">
							<div class="position-relative">
							<a href="javascript:void(0)">		
								${content}						
							</a>
							<span class="badge badge-pill badge-theme-1 position-absolute badge-top-` + banners.align + ` font-` + banners.color +`">` + banners.button_text + `</span></div>
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<a href="javascript:void(0)">
											<p class="list-item-heading pt-1">` + banners.title + `<br><span class="text-small text-muted">` + banners.subtitle + `</span></p>
										</a>
										<footer>
											<p class="text-muted text-small mb-0 font-weight-light text-truncate">` + banners.description + `</p>
										</footer>
									</div>
								</div>
							</div>
						</div>
					</div>
				`);
	        });
	    }
	
	    function listnersbanners() {
	
	        // Ao clicar no adicionar metodo
	        $(".add-new-banners").off("click");
	        $(".add-new-banners").on("click", function() {
	
	            // Alterar o titulo do modal
	            $("#big-banners-modal h3").text("Novo banner");
	
	            cleanEditor();

				$(".remove-banners").hide();

				$("[name='align']").prop('checked', false);

				$("#banner-image").slim('remove');

				// Retirar id do botao
				$(".save-banner").data("id", "");
	
	            $("#big-banners-modal").modal("show");
	        });
	
	        // Ao clicar no editar
	        $(".edit-banners").off("click");
	        $(".edit-banners").on("click", function() {
	
	            cleanEditor();
	
	            // Alterar o titulo do modal
	            $("#big-banners-modal h3").text("Editar banner");
	
	            let id = $(this).data("id");
	
	            // Adicionar o id ao botao de salvar
	            $(".save-banner").data("id", id);

				$(".remove-banners").show();
	
	            // Introduzir os dados no modal
	            $.get("/api/banners/" + id, function(response) {


					console.log(response);

					$("[name='align']").prop('checked', false);

					let banner_data = response.data;
					const video = document.getElementById('video');
					const videoSource = document.createElement('source');

	                $.each(banner_data, function(key, value) {

						if (key == "align" ) {

							$('#align-' + value + '-new').prop('checked', true);

						} else if (key == "color") {

							$('#color-' + value + '-new').prop('checked', true);
							
						}else {

							$("#big-banners-modal [name='" + key + "']").val(value);
						}
	                });

					if (banner_data.video.length > 1 && banner_data.photo.length == 0) {

						videoSource.setAttribute('src', banner_data.video);
						video.appendChild(videoSource);
						video.load();
						video.play();

						$('[href="#banners-video"]').addClass("active");
						$('[href="#banners-image"]').removeClass("active");

					} else {

						if(banner_data.video.length > 1){
							videoSource.setAttribute('src', "");
							video.appendChild(videoSource);
							video.load();
							video.play();
						}
						$('[href="#banners-image"]').addClass("active");
						$('[href="#banners-video"]').removeClass("active");
					}

					if(response.data.photo){
						$("#banner-image").slim('load', response.data.photo + "?cache=" + new Date().getTime(), { blockPush : true }, function(error, data) { });
					}
	
	                // Abrir o modal de editar
	                $("#big-banners-modal").modal("show");
	            });
	        });
	
	        //Ao clicar no eliminar
	        $(".remove-banners").off("click");
	        $(".remove-banners").on("click", function() {
	
	            let id = $(".save-banner").data("id");
	
	            removebanners(id);

				$("#big-banners-modal").modal("hide");
	
	        });
	
	        // Guardar o método de envio
	        $(".save-banner").off("click");
	        $(".save-banner").on("click", function() {
	
	            // Vereficar se vamos guardar ou editar
	            let id = $(this).data("id");
	            let data = $("#big-banners-modal form").serialize();
	            
				editbanners(id, data);
	
	            cleanEditor();
	
	            $("#big-banners-modal").modal("hide");
	
	            // Retirar o id do data-id para uma proxima ação
	            $(this).data("id", "");
	        });
	    }
	
	    // Eliminar a método de envio
	    function removebanners(id) {
	
	        $.confirm({
				title: '<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>',
				theme: "supervan",
				content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_message_remove_banner"])); ?>',
	            buttons: {
	
	                Sim: function() {
	                    $.ajax({
	                        url: "/api/banners/" + id,
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
	                            initBanners();
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
	
	        $("#big-banners-modal form").trigger("reset");
	    }
	
	    function editbanners(id = "", data) {

			let slim_data 	= $("#banner-image").slim('data')[0];
			let photo_path 	= "";
			let input 		= document.getElementById('file-input');
			
            if (slim_data.server) {
                
                photo_path = "&photo=" + slim_data.server;
            }
			

			if ($('[href="#banners-video"]').hasClass("active") && uploaded_video !== null && input.value != "") {

				photo_path = "&video=" + uploaded_video + "&photo=";
			}
	
	        $.ajax({
	            url: "/api/banners/" + id,
	            type: "POST",
	            data: data + photo_path,
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
	                initBanners();
	
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

		function videoUploadListners() {

			const input = document.getElementById('file-input');
			const video = document.getElementById('video');
			const maxFileSize = 1572864; // 1.5MB
			const videoSource = document.createElement('source');

			input.addEventListener('change', function() {

				const files = this.files || [];

				if (!files.length) return;

				if (files[0].size > maxFileSize) {

					alert("Ficheiro demasiado grande!");
					input.value = "";
					return;
				}
				
				const reader = new FileReader();

				reader.onload = function (e) {
					videoSource.setAttribute('src', e.target.result);
					video.appendChild(videoSource);
					video.load();
					video.play();
				};
				
				reader.onprogress = function (e) {
					console.log('progress: ', Math.round((e.loaded * 100) / e.total));
				};
				
				reader.readAsDataURL(files[0]);

				// Upload do video
				var formData = new FormData();
				formData.append('file', files[0]);

				$.ajax({
					type: "POST",
					url: '/api/image/dropzone?not_product_gallery=true&folder=banners',
					data: formData,
					processData: false, // tell jQuery not to process the data
					contentType: false, // tell jQuery not to set contentType
					dataType: "json",
					success: function (response) {

						if (response.success) {

							uploaded_video = response.data.path;
							console.log(response.data);
						} else {							
							$.alert({
								title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
								theme: "supervan",
								content: response.message,
							});
						}

					},
					error: function (xhr, ajaxOptions, thrownError) {

						console.log(thrownError);

						$.alert({
							title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
							theme: "supervan",
							content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
						});
					}
				});
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
	
</script><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/pages/config/items/banners.blade.php ENDPATH**/ ?>