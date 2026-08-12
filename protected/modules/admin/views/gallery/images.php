<div class="d-flex justify-content-between align-items-center mb-3">
	<div>
		<h5 class="mb-0"><?php echo CHtml::encode($album->title); ?></h5>
		<p class="text-muted mb-0 small">Manage photos in this album.</p>
	</div>
	<a href="<?php echo Yii::app()->createUrl('/admin/gallery'); ?>" class="btn btn-outline-secondary">&larr; Back to Albums</a>
</div>

<div class="admin-card admin-card-narrow mb-4">
	<?php echo CHtml::errorSummary($image); ?>
	<form method="post" action="<?php echo Yii::app()->createUrl('/admin/gallery/images', array('id' => $album->id)); ?>">
		<div class="row">
			<div class="col-md-5 mb-3">
				<label class="form-label">Image URL</label>
				<?php echo CHtml::activeTextField($image, 'image_url', array('class' => 'form-control')); ?>
			</div>
			<div class="col-md-4 mb-3">
				<label class="form-label">Caption</label>
				<?php echo CHtml::activeTextField($image, 'caption', array('class' => 'form-control')); ?>
			</div>
			<div class="col-md-3 mb-3">
				<label class="form-label">Display Order</label>
				<?php echo CHtml::activeNumberField($image, 'display_order', array('class' => 'form-control')); ?>
			</div>
		</div>
		<button type="submit" class="btn btn-bkgs-primary">+ Add Image</button>
	</form>
</div>

<div class="admin-card">
	<?php if (empty($album->images)): ?>
		<p class="text-muted text-center py-4 mb-0">No images in this album yet.</p>
	<?php else: ?>
		<div class="row g-3">
			<?php foreach ($album->images as $img): ?>
				<div class="col-md-3 col-6">
					<div class="border rounded p-2 h-100">
						<img src="<?php echo CHtml::encode($img->image_url); ?>" alt="<?php echo CHtml::encode($img->caption); ?>" style="width:100%;height:140px;object-fit:cover;" class="rounded mb-2">
						<p class="text-muted small mb-2"><?php echo CHtml::encode($img->caption); ?></p>
						<form method="post" action="<?php echo Yii::app()->createUrl('/admin/gallery/removeImage', array('id' => $img->id)); ?>" onsubmit="return confirm('Remove this image?');">
							<button type="submit" class="btn btn-sm btn-outline-danger w-100">Remove</button>
						</form>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
