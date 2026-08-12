<section class="bkgs-section">
	<div class="container">
		<h1 class="bkgs-section-title text-center"><?php echo CHtml::encode($about ? $about->title : 'About Samaj'); ?></h1>
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="bkgs-card">
					<?php echo $about ? $about->content : '<p class="text-muted">Content coming soon.</p>'; ?>
				</div>
			</div>
		</div>
	</div>
</section>
