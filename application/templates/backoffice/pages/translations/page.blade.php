@extends('layouts.master')
@section('content')
<main class="default-transition pt-5 mb-5 collapsable-main no-load">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 mb-8">
				<div class="col-12">
					<button type="button" class="btn btn-outline-primary save" style="float:right; position:relative; top:0px;">Guardar</button>
					<h1>Editar idioma</h1>
					<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
						<ol class="breadcrumb pt-0">
							<li class="breadcrumb-item">
								<a href="/adm">Página principal</a>
							</li>
							<li class="breadcrumb-item">
								<a href="/adm/settings">Definições gerais</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">Editar idioma</li>
						</ol>
					</nav>
					<div class="separator mb-5"></div>
				</div>
				<div class="contact-form clearfix">
					<div class="col-md-12">
						<form id="language-form">
							<div class="card">
								<div class="card-body">
									<div id="language_settings" class="row">
										<div class="col-md-12">
											<h3 class="title">Espanhol</h3><hr><br>
										</div>
										<input name="id" type="hidden" value="8">
										<div class="col-md-4 col-xs-6">
											<label class="form-group has-float-label">
												<input value="Espanhol" name="name" type="text" autocomplete="off" class="form-control">
												<span>Nome</span>
											</label>
										</div>
										<div class="col-md-4 col-xs-6">
											<label class="form-group has-float-label">
												<input value="Criativatek™" name="author" type="text" autocomplete="off" class="form-control">
												<span>Autor</span>
											</label>
										</div>
										<div class="col-md-4 col-xs-6">
											<label class="form-group has-float-label">
												<input value="es" name="code" type="text" autocomplete="off" class="form-control">
												<span>Código</span>
											</label>
										</div>
										<div class="col-md-4 col-xs-6">
											<label class="form-group has-float-label">
												<input value="" name="default_state1" type="text" autocomplete="off" class="form-control" disabled>
												<span>Estado inicial da encomenda</span>
											</label>
										</div>
										<div class="col-md-4 col-xs-6">
											<label class="form-group has-float-label">
												<input value="" name="default_state2" type="text" autocomplete="off" class="form-control" disabled>
												<span>Estado inicial do pagamento</span>
											</label>
										</div>
										<div class="col-md-4 col-xs-6">
											<label class="form-group has-float-label">
												<input value="" name="default_state3" type="text" autocomplete="off" class="form-control" disabled>
												<span>Estado de pagamento concluído</span>
											</label>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<br><hr><br>
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<h5>Traduções</h5>
								<hr>
								<div class="row mt-3">
									<div class="col-12">
										<ul class="nav nav-tabs card-header-tabs ml-0 mr-0" role="tablist">
											<li class="nav-item w-50 text-center">
												<a class="nav-link active" data-toggle="tab" href="#frontOffice" role="tab" aria-controls="first" aria-selected="true">FrontOffice</a>
											</li>
											<li class="nav-item w-50 text-center">
												<a class="nav-link d-none" id="backoffice_btn" data-toggle="tab" href="#backOffice" role="tab" aria-controls="second" aria-selected="false">BackOffice</a>
											</li>
										</ul>
										<div class="tab-content mt-4">
											<div class="tab-pane fade mb-4 active show" id="frontOffice" role="tabpanel">
												<form id="frontEnd-form">
													<div class="row" id="translationsFrontOffice">
														<div class="col-md-6 col-xs-12">
															<label class="form-group has-float-label">
																<input value="perfil" name="profile" type="text" autocomplete="off" class="form-control">
																<span>common - profile</span>
															</label>
														</div>
														<div class="col-md-6 col-xs-12">
															<label class="form-group has-float-label">
																<input value="Newsletter" name="newsletter" type="text" autocomplete="off" class="form-control">
																<span>common - newsletter</span>
															</label>
														</div>
													</div>
												</form>
											</div>
											<div class="tab-pane fade mb-4" id="backOffice" role="tabpanel">
												<form id="backEnd-form">
													<div class="row" id="translationsBackOffice">
														<div class="col-md-6 col-xs-12">
															<label class="form-group has-float-label">
																<input value="perfil" name="profile" type="text" autocomplete="off" class="form-control">
																<span>common - profile</span>
															</label>
														</div>
														<div class="col-md-6 col-xs-12">
															<label class="form-group has-float-label">
																<input value="Newsletter" name="newsletter" type="text" autocomplete="off" class="form-control">
																<span>common - newsletter</span>
															</label>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		    </div>
		</div>
	</div>
</main>
@endsection

@section("scripts")
<script>
	init()

	function init() {

		// Vamos buscar o url pretendido para ver se a página vai editar ou adicionar novo produto
		var page = new RegExp('^/adm/products/.*');

		// Vamos buscar o link do site
		var path = window.location.pathname.replace(/\/+$/, '');

		// Predefinir a variavel do wildcard
		var wildcard = null;

		// Definir a wildcard como o último valor do URL /valor1/valor2/valor3 ( nest caso vamos buscar o valor 3)
		wildcard = path.split("/");
		wildcard = wildcard[wildcard.length - 1];

		load(wildcard)

		listners(wildcard)
	}

	function load(id) {
		$.ajax({
			url: "/api/translations/" + id,
			type: "GET",
			dataType: "json",
			success: function (response) {

				if (!response.success) {

					// Output do erro
					console.error(response);

					$.alert({
						title: 'Erro!',
						theme: "supervan",
						content: 'Ocorreu algum erro ao processar o pedido, mais informações na consola do navegador!',
					});

					// Não deixar a função executar mais
					return;
				}

				console.log("cdzsafsf", response)

				$(".title").html(response.data.name)
				populateInfoLanguage(response.data.language)
				populateTranslations(response.data.translations)
				populateOrderStatus(response.data.orderStatus)

			},
			error: function (jqXHR, textStatus, errorThrown) {

				console.log(textStatus, errorThrown);

				$.alert({
					title: 'Erro!',
					theme: "supervan",
					content: 'Ocorreu algum erro ao processar o pedido, mais informações na consola do navegador!',
				});
			}
		});
	}

	function editLanguage(id, data, dataFront, dataBack, success_message = true) {
		console.log(data)
		$.ajax({
			url: "/api/translations/" + id,
			type: "POST",
			data: {	lang: data,
					frontoffice: dataFront,
					backoffice: dataBack
				  },
			dataType: "json",
			success: function(response) {

				if (!response.success) {

					// Output do erro
					console.error(response);

					$.alert({
						title: 'Erro!',
						theme: "supervan",
						content: 'Ocorreu algum erro ao processar o pedido, mais informações na consola do navegador!',
					});

					// Não deixar a função executar mais
					return;
				}

				$.alert({
					title: 'Sucesso!',
					theme: "supervan",
					content: 'Traduções guardadas com sucesso!',
				});

			},
			error: function(jqXHR, textStatus, errorThrown) {

				console.log(textStatus, errorThrown);

				$.alert({
					title: 'Erro!',
					theme: "supervan",
					content: 'Ocorreu algum erro ao processar o pedido, mais informações na consola do navegador!',
				});
			}
		});
	}

	function populateInfoLanguage(language) {

		$.each(language, function (key, value) {
			$(`[name = "${key}"]`).val(value);
			if(key == 'code' && value == 'pt') {
				$('#backoffice_btn').removeClass('d-none');
			}
		});

	}

	function populateTranslations(translations) {
		$("#translationsBackOffice").html("")
		$("#translationsFrontOffice").html("")
		$.each(translations, function (key, translation) {

			let template = `
				<div class="col-md-6 col-xs-12">
					<label class="form-group has-float-label">
						<input value="` + translation.word + `" name="` + translation.word_key +`" type="text" autocomplete="off" class="form-control">
						<span>` + translation.category + ` - ` + translation.word_key +`</span>
					</label>
				</div>
			`

			switch(translation.category){
				case "backoffice":
					$("#translationsBackOffice").append(template)
					break;
				case "frontoffice":
					$("#translationsFrontOffice").append(template)
					break;
			}
		});
	}

	function populateOrderStatus(orderStatus) {

		console.log("sdsd", $("[name='default_state2']").val())

		$.each(orderStatus, function (key, status) {
			
			if(status.id == $("[name='default_state1']").val()){
				$("[name='default_state1']").val(status.name)
			}
			if(status.id == $("[name='default_state2']").val()){
				$("[name='default_state2']").val(status.name)
			}
			if(status.id == $("[name='default_state3']").val()){
				$("[name='default_state3']").val(status.name)
			}
		});
	}

	function listners(wildcard) {

		$(".save").off("click");
		$(".save").on("click", function() {
			let data = {}
			let dataFront = {}
			let dataBack = {}
			$.each($('#language-form').serializeArray(), function () {

				data[this.name] = this.value;
			});

			$.each($('#frontEnd-form').serializeArray(), function () {

				dataFront[this.name] = this.value;
			});

			$.each($('#backEnd-form').serializeArray(), function () {

				dataBack[this.name] = this.value;
			});

			editLanguage(wildcard, data, dataFront, dataBack)
		})
	}



</script>
@endsection