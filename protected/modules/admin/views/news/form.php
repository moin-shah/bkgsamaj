<?php $isNew = $model->isNewRecord; ?>

<div class="admin-card admin-card-narrow">
	<form method="post" action="<?php echo $isNew ? Yii::app()->createUrl('/admin/news/create') : Yii::app()->createUrl('/admin/news/update', array('id' => $model->id)); ?>">
		<?php echo CHtml::errorSummary($model); ?>

		<div class="mb-3">
			<label class="form-label">Title</label>
			<?php echo CHtml::activeTextField($model, 'title', array('class' => 'form-control', 'id' => 'news-title')); ?>
		</div>

		<div class="mb-3">
			<label class="form-label">Slug</label>
			<?php echo CHtml::activeTextField($model, 'slug', array('class' => 'form-control', 'id' => 'news-slug')); ?>
			<div class="form-text">Used in the public URL: /news/&lt;slug&gt;</div>
		</div>

		<div class="mb-3">
			<label class="form-label">Excerpt</label>
			<?php echo CHtml::activeTextArea($model, 'excerpt', array('class' => 'form-control', 'rows' => 3)); ?>
		</div>

		<div class="mb-3">
			<label class="form-label">Content</label>
			<?php echo CHtml::activeTextArea($model, 'content', array('class' => 'form-control', 'rows' => 10)); ?>
		</div>

		<div class="mb-3">
			<label class="form-label">Published At</label>
			<?php echo CHtml::activeTextField($model, 'published_at', array('class' => 'form-control', 'placeholder' => 'YYYY-MM-DD HH:MM:SS')); ?>
			<div class="form-text">Leave blank to keep this article unpublished.</div>
		</div>

		<div class="form-check form-switch mb-3">
			<?php echo CHtml::activeCheckBox($model, 'status', array('class' => 'form-check-input')); ?>
			<label class="form-check-label">Published</label>
		</div>

		<div class="d-flex gap-2">
			<button type="submit" class="btn btn-bkgs-primary"><?php echo $isNew ? 'Add News' : 'Save Changes'; ?></button>
			<a href="<?php echo Yii::app()->createUrl('/admin/news'); ?>" class="btn btn-outline-secondary">Cancel</a>
		</div>
	</form>
</div>

<script>
(function () {
	var titleInput = document.getElementById('news-title');
	var slugInput = document.getElementById('news-slug');
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
