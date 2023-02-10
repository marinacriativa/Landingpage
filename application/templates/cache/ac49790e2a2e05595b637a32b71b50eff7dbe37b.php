
<?php $__env->startSection('content'); ?>
<main class="default-transition pt-5 mb-5 collapsable-main no-load">
	<div class="p-desktop-5 config-page">
		<div class="row">
			<div class="col-md-12 mb-8">
				<div class="col-12">
					<h1><?php echo e(ucfirst($translations["backoffice"]["settings_title"])); ?></h1>
					<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
						<ol class="breadcrumb pt-0">
							<li class="breadcrumb-item">
								<a href="/adm"><?php echo e(ucfirst($translations["backoffice"]["store"])); ?></a>
							</li>
							<li class="breadcrumb-item active" aria-current="page"><?php echo e(ucfirst($translations["backoffice"]["settings"])); ?></li>
						</ol>
					</nav>
					<div class="separator mb-5"></div>
					<div class="row">
						<div class="col-12 col-lg-4 col-xl-3 col-left">
							<div class="card mb-4">
								<div class="card-body">
									<h4><?php echo e(ucfirst($translations["backoffice"]["settings_menu"])); ?></h4>
									<hr>
									<a class="settings-page line-button active" data-link="store"> <span class="text">Website</span></a>
									<!-- <a class="settings-page line-button" data-link="menu_manager"> <span class="text"><?php echo e(ucfirst($translations["backoffice"]["menu_manager"])); ?></span></a> -->
									<?php if(MODULES_PRODUCTS): ?>
										<a class="settings-page line-button" data-link="shipping"> <span class="text"><?php echo e(ucfirst($translations["backoffice"]["settings_menu_shipping"])); ?></span></a>
										<a class="settings-page line-button" data-link="payment"> <span class="text"><?php echo e(ucfirst($translations["backoffice"]["settings_menu_payment"])); ?></span></a>
										<a class="settings-page line-button" data-link="orderStatus"> <span class="text"><?php echo e(ucfirst($translations["backoffice"]["settings_menu_orderStatus"])); ?></span></a>
									<?php endif; ?>
									<!--<a class="settings-page line-button" data-link="categories"> <span class="text"><?php echo e(ucfirst($translations["backoffice"]["settings_menu_categories"])); ?></span></a> -->
									<?php if(MODULES_GALLERY): ?>
										<a class="settings-page line-button" data-link="categories_galleries"> <span class="text"><?php echo e(ucfirst($translations["backoffice"]["settings_menu_categories_galleries"])); ?></span></a>
									<?php endif; ?>
									<!-- <a class="settings-page line-button" data-link="categories_constructions"> <span class="text"><?php echo e(ucfirst($translations["backoffice"]["constructions"])); ?></span></a> -->
									<?php if(MODULES_PERSONALIZATION): ?>
										<a class="settings-page line-button" data-link="personalizationGroups"> <span class="text"><?php echo e(ucfirst($translations["backoffice"]["settings_menu_customizeGroups"])); ?></span></a>
									<?php endif; ?>
									<a class="settings-page line-button" data-link="design"> <span class="text"><?php echo e(ucfirst($translations["backoffice"]["settings_menu_design"])); ?>	</span></a>
<!-- 									<a class="settings-page line-button" data-link="banners"> <span class="text"><?php echo e(ucfirst($translations["backoffice"]["settings_menu_banners"])); ?></span></a> -->
									<?php if(MODULES_FAQS): ?>
										<a class="settings-page line-button" data-link="faqs"> <span class="text"><?php echo e(ucfirst($translations["backoffice"]["settings_menu_faqs"])); ?></span></a>
									<?php endif; ?>
									<?php if(MODULES_LANGUAGES): ?>
										<a class="settings-page line-button" data-link="languages"> <span class="text"><?php echo e(ucfirst($translations["backoffice"]["settings_menu_languages"])); ?></span></a>
									<?php endif; ?>
									<a class="settings-page line-button" data-link="sitemap"> <span class="text"><?php echo e(ucfirst($translations["backoffice"]["settings_menu_sitemap"])); ?></span></a>
									<a class="settings-page line-button" data-link="email"> <span class="text"><?php echo e(ucfirst($translations["backoffice"]["settings_menu_email"])); ?></span></a>
									<a class="settings-page line-button" data-link="scripts"> <span class="text">Scripts</span></a>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-8 col-xl-9 col-right">
							<div class="card">
								<div class="card-body">
									<div class="tab fade show" data-id="store">
										<?php echo $__env->make("pages.config.items.website", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div>
									<!-- <div class="tab fade show" data-id="menu_manager">
										<?php echo $__env->make("pages.config.items.menu_manager", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div> -->
									<div class="tab fade" data-id="shipping">
										<?php echo $__env->make("pages.config.items.shipping", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div>
									<div class="tab fade" data-id="payment">
										<?php echo $__env->make("pages.config.items.payment", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div>
									<div class="tab fade" data-id="orderStatus">
										<?php echo $__env->make("pages.config.items.orderStatus", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div>
									<!--
									<div class="tab fade" data-id="categories">
										<?php echo $__env->make("pages.config.items.categories", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div>
									-->
									<div class="tab fade" data-id="categories_galleries">
										<?php echo $__env->make("pages.config.items.categories_galleries", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div>
									<div class="tab fade" data-id="categories_constructions">
										<?php echo $__env->make("pages.config.items.categories_constructions", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div>
									<div class="tab fade" data-id="personalizationGroups">
										<?php echo $__env->make("pages.config.items.personalizationGroups", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div>
									<div class="tab fade" data-id="design">
										<?php echo $__env->make("pages.config.items.design", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div>
									<!-- <div class="tab fade" data-id="banners">
										<?php echo $__env->make("pages.config.items.banners", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div> -->
									<div class="tab fade" data-id="faqs">
										<?php echo $__env->make("pages.config.items.faqs", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div>
									<div class="tab fade" data-id="languages">
										<?php echo $__env->make("pages.config.items.languages", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div>
									<div class="tab fade" data-id="sitemap">
										<?php echo $__env->make("pages.config.items.sitemap", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div>
									<div class="tab fade" data-id="email">
										<?php echo $__env->make("pages.config.items.email", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div>
									<div class="tab fade" data-id="scripts">
										<?php echo $__env->make("pages.config.items.scripts", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>

	/* 
	*	Iniciar as "páginas" das definições só depois de clicar nelas
	*/
	
	$(".settings-page").on("click", function() {

		let page = $(this).data("link");

		if (page !== undefined) {

			console.log(page);

			// Vamos iniciar a função para abrir a página
			window[page]();
		}
	})

	init();

	function slimDefaultConfig(meta) {

		return {
			
			push: true,
            service: '/api/image/slim',
            label: 'Carregar',
            statusUploadSuccess: 'Guardado!',
            
            buttonCancelLabel: 'Cancelar',
            buttonConfirmLabel: 'Confirmar',
            buttonEditLabel: 'Editar',
            buttonDownloadLabel: 'Download',
            buttonUploadLabel: 'Upload',
            
            buttonCancelTitle: 'Cancelar',
            buttonConfirmTitle: 'Confirmar',
            buttonEditTitle: 'Editar',
            buttonDownloadTitle: 'Download',
            buttonUploadTitle: 'Upload',
            buttonRotateTitle: 'Rodar',
            buttonRemoveTitle: 'Remover',

			meta : meta
		}
	}

	function init() {

		// Obter todas as definições e "populate" os campos de texto normal

		$.ajax({
			url: "/api/config/",
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

				window.CONFIG = response.data;

				// Procurar todos os elementos por name="" e meter os dados da api
				$.each(response.data, function(key, value) {

					$("[data-config-name='" + key + "']").val(value);
				});

				// Iniciar a primeira página
				store();
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

	function saveSetting(key, value) {
		
		$.ajax({
			url: "/api/config/" + key + "?value=" + encodeURIComponent(value),
			type: "PUT",
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

				window.CONFIG = response.data;

				// Procurar todos os elementos por name="" e meter os dados da api
				$.each(response.data, function(key, value) {

					$("[data-config-name='" + key + "']").val(value);
				});
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

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/pages/config/index.blade.php ENDPATH**/ ?>