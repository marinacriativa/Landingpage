<html lang="en">
	<head>
	    <meta charset="UTF-8">
	    <title><?php echo $__env->yieldContent('title'); ?></title>
	    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	    <link rel="stylesheet" href="/static/backoffice/css/style.css" />
	    <link rel="stylesheet" href="/static/backoffice/css/themes/dore.light.blue.css" />
	    <link href="/static/images/favicon.png" rel="icon" type="image/png">
	</head>

	<body class="background no-footer">
	    <div class="fixed-background"></div>
	    <?php echo $__env->yieldContent('content'); ?>
		<script src="/static/backoffice/javascript/jquery.js"></script>
	    <script src="/static/backoffice/javascript/scripts.js"></script>
		<?php echo $__env->yieldContent('scripts'); ?>
	</body>

</html><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/layouts/standalone.blade.php ENDPATH**/ ?>