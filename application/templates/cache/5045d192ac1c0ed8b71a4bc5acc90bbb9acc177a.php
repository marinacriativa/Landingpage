<div id="track-order-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="video-banner-title h1"><span class="text-primary"><?php echo e($langg->lang772); ?><span class="black-text">.</span></span></h3>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<br>
				<form id="track-form" class="track-form">
					<div class="form-group">
						<input type="text" id="track-code" class="form-control" placeholder="<?php echo e($langg->lang773); ?>" required="">
					</div>
					<button type="submit" class="btn btn-outline-primary-2"> <span><?php echo e($langg->lang774); ?></span> <i class="icon-long-arrow-right"></i> </button>
				</form>
				<div style="display:none" id="track-order-wrapper">
					<hr>
					<div id="track-order"></div>
				</div>
			</div>
		</div>
	</div>
</div><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/modals/track-order.blade.php ENDPATH**/ ?>