<section class="bkgs-section">
	<div class="container">
		<a href="<?php echo Yii::app()->createUrl('/gallery'); ?>" class="d-inline-block mb-3 text-decoration-none">&larr; Back to Gallery</a>
		<h1 class="bkgs-section-title text-center"><?php echo CHtml::encode($album->title); ?></h1>
		<p class="bkgs-section-subtitle text-center"><?php echo $album->district ? CHtml::encode($album->district->name) : 'Samaj-wide'; ?></p>

		<?php if (empty($album->images)): ?>
			<p class="text-muted text-center">No photos in this album yet.</p>
		<?php else: ?>
			<div class="row g-4">
				<?php foreach ($album->images as $image): ?>
					<div class="col-md-4 col-6">
						<div class="bkgs-card p-2 text-center h-100">
							<img src="<?php echo CHtml::encode($image->image_url); ?>" alt="<?php echo CHtml::encode($image->caption); ?>" style="width:100%;height:200px;object-fit:cover;border-radius:8px;" class="mb-2">
							<?php if ($image->caption): ?>
								<p class="text-muted small mb-0"><?php echo CHtml::encode($image->caption); ?></p>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
