<?php $isNew = $model->isNewRecord; ?>

<div class="admin-card admin-card-narrow">
	<form method="post" action="<?php echo $isNew ? Yii::app()->createUrl('/admin/rajaChithi/create') : Yii::app()->createUrl('/admin/rajaChithi/update', array('id' => $model->id)); ?>">
		<?php echo CHtml::errorSummary($model); ?>

		<div class="mb-3">
			<label class="form-label">Title</label>
			<?php echo CHtml::activeTextField($model, 'title', array('class' => 'form-control')); ?>
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
				<label class="form-label">Issued Date</label>
				<?php echo CHtml::activeTextField($model, 'issued_date', array('class' => 'form-control', 'placeholder' => 'YYYY-MM-DD')); ?>
			</div>
		</div>

		<div class="mb-3">
			<label class="form-label">Attachment URL</label>
			<?php echo CHtml::activeTextField($model, 'attachment_url', array('class' => 'form-control')); ?>
		</div>

		<div class="form-check form-switch mb-3">
			<?php echo CHtml::activeCheckBox($model, 'status', array('class' => 'form-check-input')); ?>
			<label class="form-check-label">Published</label>
		</div>

		<div class="d-flex gap-2">
			<button type="submit" class="btn btn-bkgs-primary"><?php echo $isNew ? 'Add Raja Chithi' : 'Save Changes'; ?></button>
			<a href="<?php echo Yii::app()->createUrl('/admin/rajaChithi'); ?>" class="btn btn-outline-secondary">Cancel</a>
		</div>
	</form>
</div>
