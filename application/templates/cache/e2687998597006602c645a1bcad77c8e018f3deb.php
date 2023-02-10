<?php
    $parentCategory = "0";

    foreach($categories as $category) {

        if ($category->root == 1) {

            $parentCategory = $category->id;
        }
    }

	$cart = ((isset($_COOKIE["cart"]) && !empty($_COOKIE["cart"])) ? @json_decode($_COOKIE["cart"], true) : array());
?>
<!DOCTYPE html>
<html lang="pt-PT">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="theme-color" content="#28292C">
        <link rel="shortcut icon" href="/public/static/img/light/favicon.png" type="image/x-icon">
        <link rel="stylesheet" href="/public/static/css/plugins/bootstrap.min.css">
        <link rel="stylesheet" href="/public/static/css/plugins/font-awesome.min.css">
        <link rel="stylesheet" href="/public/static/css/plugins/swiper.min.css">
        <link rel="stylesheet" href="/public/static/css/plugins/fancybox.min.css">
        <!--<link href="css/plugins/mapbox-style.css" rel='stylesheet'>-->
        <link rel="stylesheet" href="/public/static/css/style-light.css">
        <link rel="stylesheet" href="/public/static/css/ttig.css">
        <title>TTig Soldaduras</title>
    </head>

    <body>
	<div class="mry-app">
		<!-- preloader -->
		<div class="mry-preloader mry-active">
			<div class="mry-preloader-content">
				<img class="mry-logo mry-mb-20" src="/public/static/img/light/logo.svg" alt="TTig Soldaduras">
				<div class="mry-loader-bar">
					<div class="mry-loader"></div>
				</div>
				<div class="mry-label">Por favor aguarde</div>
			</div>
		</div>
		<!-- preloader end -->
		<!-- cursor -->
		
		<!-- cursor end -->
		<!-- top panel -->
		<div class="mry-top-panel">
			<div class="mry-logo-frame">
				<a href="/<?php echo e($selected_language->code); ?>/" class="mry-default-link mry-anima-link">
					<img class="mry-logo" src="/public/static/img/light/logo.svg" alt="TTig Soldaduras">
				</a>
			</div>
			<div class="mry-menu-button-frame">

				<div class="mry-label pr-1rem" style="color: #ccc">
					<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<a href="/language/<?php echo e($lang->code); ?>" style="text-transform: uppercase;"><?php echo e($lang->code); ?></a>
						<?php if($key !== array_key_last($languages)): ?>
							|
						<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>

				<div class="mry-label">Menu</div>
				<div class="mry-menu-btn mry-magnetic-link">
					<div class="mry-burger mry-magnetic-object">
						<span></span>
					</div>
				</div>
			</div>
		</div>
		<!-- top panel end -->
		<!-- menu -->
		<div class="mry-menu">
			<div class="container">
				<div class="row justify-content-between">
					<div class="col-md-4">
					<nav id="mry-dynamic-menu">
							<ul>
								<li class="menu-item"><a href="/<?php echo e($selected_language->code); ?>/" class="mry-anima-link mry-default-link"><?php echo e(ucfirst($translations["frontoffice"]["Index_menu_link1"])); ?></a></li>
								<li class="menu-item"><a href="/<?php echo e($selected_language->code); ?>/about" class="mry-anima-link mry-default-link"><?php echo e(ucfirst($translations["frontoffice"]["Index_menu_link2"])); ?></a></li>
								<li class="menu-item menu-item-has-children"><a href="#" disabled><?php echo e(ucfirst($translations["frontoffice"]["Index_menu_link3"])); ?></a>
									<ul class="sub-menu">
										<li class="menu-item"><a href="/<?php echo e($selected_language->code); ?>/news/3" class="mry-anima-link mry-default-link"><?php echo e(ucfirst($translations["frontoffice"]["Index_menu_link11"])); ?></a></li>
										<li class="menu-item"><a href="/<?php echo e($selected_language->code); ?>/news/2" class="mry-anima-link mry-default-link"><?php echo e(ucfirst($translations["frontoffice"]["Index_menu_link4"])); ?></a></li>
										<li class="menu-item"><a href="/<?php echo e($selected_language->code); ?>/news/1" class="mry-anima-link mry-default-link"><?php echo e(ucfirst($translations["frontoffice"]["Index_menu_link5"])); ?></a></li>
										<li class="menu-item"><a href="/<?php echo e($selected_language->code); ?>/news/4" class="mry-anima-link mry-default-link"><?php echo e(ucfirst($translations["frontoffice"]["Index_menu_link6"])); ?></a></li>
										<li class="menu-item"><a href="/<?php echo e($selected_language->code); ?>/news/5" class="mry-anima-link mry-default-link"><?php echo e(ucfirst($translations["frontoffice"]["Index_menu_link7"])); ?></a></li>
										<li class="menu-item"><a href="/<?php echo e($selected_language->code); ?>/news/6" class="mry-anima-link mry-default-link"><?php echo e(ucfirst($translations["frontoffice"]["Index_menu_link8"])); ?></a></li>
									</ul>
								</li>
								<li class="menu-item"><a href="/<?php echo e($selected_language->code); ?>/contact" class="mry-anima-link mry-default-link"><?php echo e(ucfirst($translations["frontoffice"]["Index_menu_link9"])); ?></a></li>
								<li class="menu-item"><a href="/<?php echo e($selected_language->code); ?>/portfolio" class="mry-default-link"><?php echo e(ucfirst($translations["frontoffice"]["Index_menu_link10"])); ?></a></li>
								<li class="menu-item">
									<div class="top-idioma">
										<span class="top-bar-contact-list no-border-left no-border-right d-md-none d-inline-block pb-1 me-2 bb-1px-white">
											<?php if(isset($menus)): ?>
												<?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<?php if($menu->root != 1 && $menu->root != 2 && $menu->type == 1): ?>
														<?php
															$new_tab_tm = $menu->newtab == "true" ? "_blank" : "";
														?>
														<a href="<?php echo e($menu->url); ?>" style="font-size: .9em !important;" target="<?php echo e($new_tab_tm); ?>" class="alt-font text-small text-uppercase font-weight-300">
															<?php if($menu->icon != NULL && !empty($menu->icon)): ?>
																<i class="<?php echo e($menu->icon); ?>" style="color: white;"></i>
															<?php endif; ?>
															<?php echo e($menu->name); ?> &nbsp;</a>
													<?php endif; ?>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php endif; ?>
										</span>
										<!--  <a class="md-display-none" href="#">PT / EN</a><br> -->
										<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<a href="/language/<?php echo e($lang->code); ?>" style="text-transform: uppercase;"><?php echo e($lang->code); ?></a>
											<?php if($key !== array_key_last($languages)): ?>
												/
											<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</li>
							</ul>
						</nav>
					</div>
					
					<div class="col-md-4">
						<div class="mry-info-box-frame">
							<div class="mry-info-box">
								<div class="mry-mb-20">
									<div class="mry-text font-weight-800"><?php echo e(ucfirst($translations["frontoffice"]["contact_menu_items_section1_line1"])); ?></div>
									<div class="mry-text"><?php echo e(ucfirst($translations["frontoffice"]["contact_menu_items_section1_line2"])); ?></div>
									<div class="mry-text"><?php echo e(ucfirst($translations["frontoffice"]["contact_menu_items_section1_line3"])); ?></div>
									<div class="mry-text"><?php echo e(ucfirst($translations["frontoffice"]["contact_menu_items_section1_line4"])); ?></div>
								</div>
								<div class="mry-mb-20">
									<div class="mry-text font-weight-800"><?php echo e(ucfirst($translations["frontoffice"]["contact_menu_items_section2_line1"])); ?></div>
									<div class="mry-text"><?php echo e(ucfirst($translations["frontoffice"]["contact_menu_items_section2_line2"])); ?></div>
								</div>
								<div class="mry-mb-20">
									<div class="mry-text font-weight-800"><?php echo e(ucfirst($translations["frontoffice"]["contact_menu_items_section3_line1"])); ?></div>
									<div class="mry-text"><?php echo e(ucfirst($translations["frontoffice"]["contact_menu_items_section3_line2"])); ?></div>
								</div>
								<div class="mry-mb-20">
									<div class="mry-text font-weight-800"><?php echo e(ucfirst($translations["frontoffice"]["contact_menu_items_section4_line1"])); ?></div>
									<div class="mry-text"><?php echo e(ucfirst($translations["frontoffice"]["contact_menu_items_section4_line2"])); ?></div>
									<div class="mry-text"><?php echo e(ucfirst($translations["frontoffice"]["contact_menu_items_section4_line3"])); ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

        <?php echo $__env->yieldContent('content'); ?>

				<!-- footer end -->
				<div class="mry-head-bg mry-head-bottom">
					<img src="/public/static/img/light/projects/prjct-2/1.jpg" alt="background">
					<div class="mry-bg-overlay"></div>
				</div>

			</div>
		</div>
	</div>
	<script src="/public/static/js/plugins/jquery.min.js"></script>
	<script src="/public/static/js/plugins/tween-max.min.js"></script>
	<script src="/public/static/js/plugins/scroll-magic.js"></script>
	<script src="/public/static/js/plugins/scroll-magic-gsap-plugin.js"></script>
	<script src="/public/static/js/plugins/swiper.min.js"></script>
	<script src="/public/static/js/plugins/isotope.min.js"></script>
	<script src="/public/static/js/plugins/fancybox.min.js"></script>
	<!-- <script src="js/plugins/mapbox.min.js"></script> -->
	<script src="/public/static/js/plugins/smooth-scrollbar.min.js"></script>
	<script src="/public/static/js/plugins/overscroll.min.js"></script>
	<script src="/public/static/js/plugins/canvas.js"></script>
	<script src="/public/static/js/plugins/parsley.min.js"></script>
	<script src="/public/static/js/main.js"></script>



        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-93NGDNYKNY"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-93NGDNYKNY');

            function parseQueryString() {

                // Use location.search to access query string instead
                const qs = window.location.search.replace('?', '');

                const items = qs.split('&');

                // Consider using reduce to create the data mapping
                return items.reduce((data, item) => {

                const [key, value] = item.split('=');

                // Sometimes a query string can have multiple values
                // for the same key, so to factor that case in, you
                // could collect an array of values for the same key
                if(data[key] !== undefined) {

                    // If the value for this key was not previously an
                    // array, update it
                    if(!Array.isArray(data[key])) {
                    data[key] = [ data[key] ]
                    }

                    data[key].push(value)
                }
                else {

                    data[key] = value
                }

                return data

                }, {})
            }

        </script>
        <?php if($settings->cookies_active == "true"): ?>
            <?php echo $settings->cookies_value; ?>

        <?php endif; ?>
        <?php if($settings->whatsapp_active == "true"): ?>
            <?php
                $phone_number = $settings->whatsapp_number;
            ?>
            <style>
                #whatsapp_btn {
                    position: fixed;
                    top: 83%;
                    right: 37px;
                    z-index: 9999;
                }
            </style>
            <div id="whatsapp_btn">
                <a href="https://api.whatsapp.com/send?phone=<?php echo e($phone_number); ?>&text=Olá." target="_blank">
                    <img src="/static/images/whatsapp_icon.png" alt="" width="60" height="60">
                </a>
            </div>
        <?php endif; ?>
        <?php if($settings->messenger_active == "true"): ?>
            <?php echo $settings->messenger_value; ?>

        <?php endif; ?>
    </body>
</html>
<?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/layouts/master_home.blade.php ENDPATH**/ ?>