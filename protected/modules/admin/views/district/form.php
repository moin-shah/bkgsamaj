<?php $isNew = $model->isNewRecord; ?>

<div class="admin-card admin-card-narrow">
	<form method="post" action="<?php echo $isNew ? Yii::app()->createUrl('/admin/district/create') : Yii::app()->createUrl('/admin/district/update', array('id' => $model->id)); ?>">
		<?php echo CHtml::errorSummary($model); ?>

		<div class="mb-3">
			<label class="form-label">District Name</label>
			<?php echo CHtml::activeTextField($model, 'name', array('class' => 'form-control', 'maxlength' => 150)); ?>
		</div>

		<div class="mb-3">
			<label class="form-label">Description</label>
			<?php echo CHtml::activeTextArea($model, 'description', array('class' => 'form-control', 'rows' => 4)); ?>
		</div>

		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">Display Order</label>
				<?php echo CHtml::activeNumberField($model, 'display_order', array('class' => 'form-control')); ?>
			</div>
			<div class="col-md-6 mb-3">
				<label class="form-label d-block">Status</label>
				<div class="form-check form-switch mt-2">
					<?php echo CHtml::activeCheckBox($model, 'status', array('class' => 'form-check-input')); ?>
					<label class="form-check-label">Active</label>
				</div>
			</div>
		</div>

		<div class="d-flex gap-2">
			<button type="submit" class="btn btn-bkgs-primary"><?php echo $isNew ? 'Add District' : 'Save Changes'; ?></button>
			<a href="<?php echo Yii::app()->createUrl('/admin/district'); ?>" class="btn btn-outline-secondary">Cancel</a>
		</div>
	</form>
</div>
