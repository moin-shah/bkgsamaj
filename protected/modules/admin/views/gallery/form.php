<?php $isNew = $model->isNewRecord; ?>

<div class="admin-card admin-card-narrow">
	<form method="post" action="<?php echo $isNew ? Yii::app()->createUrl('/admin/gallery/create') : Yii::app()->createUrl('/admin/gallery/update', array('id' => $model->id)); ?>">
		<?php echo CHtml::errorSummary($model); ?>

		<div class="mb-3">
			<label class="form-label">Album Title</label>
			<?php echo CHtml::activeTextField($model, 'title', array('class' => 'form-control')); ?>
		</div>

		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">District</label>
				<?php echo CHtml::activeDropDownList($model, 'district_id', $districtOptions, array('class' => 'form-select')); ?>
			</div>
			<div class="col-md-6 mb-3">
				<label class="form-label">Display Order</label>
				<?php echo CHtml::activeNumberField($model, 'display_order', array('class' => 'form-control')); ?>
			</div>
		</div>

		<div class="mb-3">
			<label class="form-label">Cover Image URL</label>
			<?php echo CHtml::activeTextField($model, 'cover_image_url', array('class' => 'form-control')); ?>
		</div>

		<div class="form-check form-switch mb-3">
			<?php echo CHtml::activeCheckBox($model, 'status', array('class' => 'form-check-input')); ?>
			<label class="form-check-label">Published</label>
		</div>

		<div class="d-flex gap-2">
			<button type="submit" class="btn btn-bkgs-primary"><?php echo $isNew ? 'Add Album' : 'Save Changes'; ?></button>
			<a href="<?php echo Yii::app()->createUrl('/admin/gallery'); ?>" class="btn btn-outline-secondary">Cancel</a>
		</div>
	</form>
</div>
