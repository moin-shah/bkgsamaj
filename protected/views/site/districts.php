<section class="bkgs-section">
	<div class="container">
		<h1 class="bkgs-section-title text-center">District List</h1>
		<p class="bkgs-section-subtitle text-center">Our Samaj community across districts</p>

		<?php if (empty($districts)): ?>
			<p class="text-muted text-center">No districts have been added yet.</p>
		<?php else: ?>
			<div class="row g-4">
				<?php foreach ($districts as $district): ?>
					<div class="col-md-6 col-lg-4">
						<div class="bkgs-card">
							<div class="bkgs-card-icon">&#128205;</div>
							<h5><?php echo CHtml::encode($district->name); ?></h5>
							<p class="text-muted small mb-0"><?php echo CHtml::encode($district->description); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
