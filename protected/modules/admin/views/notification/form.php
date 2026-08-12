<?php $isNew = $model->isNewRecord; ?>

<div class="admin-card admin-card-narrow">
	<form method="post" action="<?php echo $isNew ? Yii::app()->createUrl('/admin/notification/create') : Yii::app()->createUrl('/admin/notification/update', array('id' => $model->id)); ?>">
		<?php echo CHtml::errorSummary($model); ?>

		<div class="mb-3">
			<label class="form-label">Title</label>
			<?php echo CHtml::activeTextField($model, 'title', array('class' => 'form-control')); ?>
		</div>

		<div class="mb-3">
			<label class="form-label">Message</label>
			<?php echo CHtml::activeTextArea($model, 'message', array('class' => 'form-control', 'rows' => 4)); ?>
		</div>

		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">Audience</label>
				<?php echo CHtml::activeDropDownList($model, 'audience', array('all' => 'Everyone', 'district' => 'One District', 'role' => 'One Role'), array('class' => 'form-select')); ?>
			</div>
			<div class="col-md-6 mb-3">
				<label class="form-label">Audience Value</label>
				<?php echo CHtml::activeTextField($model, 'audience_value', array('class' => 'form-control')); ?>
				<div class="form-text">For "One District", enter the district name. For "One Role", enter the role name (admin/editor/district_admin). Ignored for "Everyone".</div>
			</div>
		</div>

		<div class="mb-3">
			<label class="form-label">Link URL</label>
			<?php echo CHtml::activeTextField($model, 'link_url', array('class' => 'form-control')); ?>
		</div>

		<div class="form-check form-switch mb-3">
			<?php echo CHtml::activeCheckBox($model, 'status', array('class' => 'form-check-input')); ?>
			<label class="form-check-label">Active</label>
		</div>

		<div class="d-flex gap-2">
			<button type="submit" class="btn btn-bkgs-primary"><?php echo $isNew ? 'Add Notification' : 'Save Changes'; ?></button>
			<a href="<?php echo Yii::app()->createUrl('/admin/notification'); ?>" class="btn btn-outline-secondary">Cancel</a>
		</div>
	</form>
</div>
