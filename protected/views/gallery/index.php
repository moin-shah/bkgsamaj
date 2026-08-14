<section class="bkgs-section">
	<div class="container">
		<h1 class="bkgs-section-title text-center">Gallery</h1>
		<p class="bkgs-section-subtitle text-center">Moments from our Samaj community</p>

		<?php if (empty($albums)): ?>
			<p class="text-muted text-center">No albums have been added yet.</p>
		<?php else: ?>
			<div class="row g-4">
				<?php foreach ($albums as $album): ?>
					<?php $url = Yii::app()->createUrl('/gallery/view', array('id' => $album->id)); ?>
					<div class="col-md-6 col-lg-4">
						<div class="bkgs-card h-100 text-center">
							<a href="<?php echo $url; ?>">
								<img src="<?php echo CHtml::encode($album->cover_image_url ?: '/images/logo/bkgs-logo.png'); ?>" alt="<?php echo CHtml::encode($album->title); ?>" style="width:100%;height:160px;object-fit:cover;border-radius:8px;" class="mb-3">
							</a>
							<h5 class="mb-1"><a href="<?php echo $url; ?>" class="text-decoration-none"><?php echo CHtml::encode($album->title); ?></a></h5>
							<p class="text-muted small mb-0">
								<?php echo count($album->images); ?> photo<?php echo count($album->images) === 1 ? '' : 's'; ?>
								<?php if ($album->district): ?> &middot; <?php echo CHtml::encode($album->district->name); ?><?php endif; ?>
							</p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
