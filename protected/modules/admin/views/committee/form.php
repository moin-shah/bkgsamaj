<?php $isNew = $model->isNewRecord; ?>

<div class="admin-card" style="max-width: 820px;">
	<form method="post" action="<?php echo $isNew ? Yii::app()->createUrl('/admin/committee/create') : Yii::app()->createUrl('/admin/committee/update', array('id' => $model->id)); ?>">
		<?php echo CHtml::errorSummary($model); ?>

		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">District</label>
				<?php echo CHtml::activeDropDownList($model, 'district_id', $districtOptions, array('class' => 'form-select', 'empty' => '-- Select District --')); ?>
			</div>
			<div class="col-md-6 mb-3">
				<label class="form-label">Position</label>
				<?php echo CHtml::activeDropDownList($model, 'position', Committee::positionOptions(), array('class' => 'form-select', 'empty' => '-- Select Position --')); ?>
				<div class="form-text">Only one person per position, per district.</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 mb-3">
				<label class="form-label">Name</label>
				<?php echo CHtml::activeTextField($model, 'full_name', array('class' => 'form-control')); ?>
			</div>
			<div class="col-md-4 mb-3">
				<label class="form-label">Phone</label>
				<?php echo CHtml::activeTextField($model, 'phone', array('class' => 'form-control')); ?>
			</div>
			<div class="col-md-4 mb-3">
				<label class="form-label">Email</label>
				<?php echo CHtml::activeTextField($model, 'email', array('class' => 'form-control')); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">Term Start</label>
				<?php echo CHtml::activeTextField($model, 'term_start', array('class' => 'form-control', 'placeholder' => 'YYYY-MM-DD')); ?>
			</div>
			<div class="col-md-6 mb-3">
				<label class="form-label">Term End</label>
				<?php echo CHtml::activeTextField($model, 'term_end', array('class' => 'form-control', 'placeholder' => 'YYYY-MM-DD')); ?>
			</div>
		</div>

		<div class="form-check form-switch mb-3">
			<?php echo CHtml::activeCheckBox($model, 'status', array('class' => 'form-check-input')); ?>
			<label class="form-check-label">Active</label>
		</div>

		<div class="d-flex gap-2">
			<button type="submit" class="btn btn-bkgs-primary"><?php echo $isNew ? 'Add Entry' : 'Save Changes'; ?></button>
			<a href="<?php echo Yii::app()->createUrl('/admin/committee'); ?>" class="btn btn-outline-secondary">Cancel</a>
		</div>
	</form>
</div>
