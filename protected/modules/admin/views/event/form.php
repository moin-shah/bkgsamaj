<?php $isNew = $model->isNewRecord; ?>

<div class="admin-card admin-card-narrow">
	<form method="post" action="<?php echo $isNew ? Yii::app()->createUrl('/admin/event/create') : Yii::app()->createUrl('/admin/event/update', array('id' => $model->id)); ?>">
		<?php echo CHtml::errorSummary($model); ?>

		<div class="mb-3">
			<label class="form-label">Title</label>
			<?php echo CHtml::activeTextField($model, 'title', array('class' => 'form-control', 'id' => 'event-title')); ?>
		</div>

		<div class="mb-3">
			<label class="form-label">Slug</label>
			<?php echo CHtml::activeTextField($model, 'slug', array('class' => 'form-control', 'id' => 'event-slug')); ?>
			<div class="form-text">Used in the public URL: /events/&lt;slug&gt;</div>
		</div>

		<div class="mb-3">
			<label class="form-label">Description</label>
			<?php echo CHtml::activeTextArea($model, 'description', array('class' => 'form-control', 'rows' => 4)); ?>
		</div>

		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">District</label>
				<?php echo CHtml::activeDropDownList($model, 'district_id', $districtOptions, array('class' => 'form-select')); ?>
			</div>
			<div class="col-md-6 mb-3">
				<label class="form-label">Venue</label>
				<?php echo CHtml::activeTextField($model, 'venue', array('class' => 'form-control')); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">Starts At</label>
				<?php echo CHtml::activeTextField($model, 'start_at', array('class' => 'form-control', 'placeholder' => 'YYYY-MM-DD HH:MM:SS')); ?>
			</div>
			<div class="col-md-6 mb-3">
				<label class="form-label">Ends At</label>
				<?php echo CHtml::activeTextField($model, 'end_at', array('class' => 'form-control', 'placeholder' => 'YYYY-MM-DD HH:MM:SS')); ?>
			</div>
		</div>

		<div class="mb-3">
			<label class="form-label">Banner Image URL</label>
			<?php echo CHtml::activeTextField($model, 'banner_url', array('class' => 'form-control')); ?>
		</div>

		<div class="form-check form-switch mb-3">
			<?php echo CHtml::activeCheckBox($model, 'status', array('class' => 'form-check-input')); ?>
			<label class="form-check-label">Published</label>
		</div>

		<div class="d-flex gap-2">
			<button type="submit" class="btn btn-bkgs-primary"><?php echo $isNew ? 'Add Event' : 'Save Changes'; ?></button>
			<a href="<?php echo Yii::app()->createUrl('/admin/event'); ?>" class="btn btn-outline-secondary">Cancel</a>
		</div>
	</form>
</div>

<script>
(function () {
	var titleInput = document.getElementById('event-title');
	var slugInput = document.getElementById('event-slug');
	if (!titleInput || !slugInput) { return; }
	titleInput.addEventListener('input', function () {
		if (slugInput.value.trim() !== '') { return; }
		slugInput.value = titleInput.value.toLowerCase().trim()
			.replace(/[^a-z0-9\s-]/g, '')
			.replace(/\s+/g, '-')
			.replace(/-+/g, '-');
	});
})();
</script>
