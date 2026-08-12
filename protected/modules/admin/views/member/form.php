<?php $isNew = $model->isNewRecord; ?>

<div class="admin-card admin-card-narrow">
	<form method="post" action="<?php echo $isNew ? Yii::app()->createUrl('/admin/member/create') : Yii::app()->createUrl('/admin/member/update', array('id' => $model->id)); ?>">
		<?php echo CHtml::errorSummary($model); ?>

		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">First Name</label>
				<?php echo CHtml::activeTextField($model, 'first_name', array('class' => 'form-control')); ?>
			</div>
			<div class="col-md-6 mb-3">
				<label class="form-label">Last Name</label>
				<?php echo CHtml::activeTextField($model, 'last_name', array('class' => 'form-control')); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">Gender</label>
				<?php echo CHtml::activeDropDownList($model, 'gender', array('male' => 'Male', 'female' => 'Female', 'other' => 'Other'), array('class' => 'form-select', 'empty' => 'Not specified')); ?>
			</div>
			<div class="col-md-6 mb-3">
				<label class="form-label">Date of Birth</label>
				<?php echo CHtml::activeTextField($model, 'date_of_birth', array('class' => 'form-control', 'placeholder' => 'YYYY-MM-DD')); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">Phone</label>
				<?php echo CHtml::activeTextField($model, 'phone', array('class' => 'form-control')); ?>
			</div>
			<div class="col-md-6 mb-3">
				<label class="form-label">Email</label>
				<?php echo CHtml::activeTextField($model, 'email', array('class' => 'form-control')); ?>
			</div>
		</div>

		<div class="mb-3">
			<label class="form-label">Address</label>
			<?php echo CHtml::activeTextArea($model, 'address', array('class' => 'form-control', 'rows' => 3)); ?>
		</div>

		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">District</label>
				<?php echo CHtml::activeDropDownList($model, 'district_id', $districtOptions, array('class' => 'form-select')); ?>
			</div>
			<div class="col-md-6 mb-3">
				<label class="form-label">Photo URL</label>
				<?php echo CHtml::activeTextField($model, 'photo_url', array('class' => 'form-control')); ?>
			</div>
		</div>

		<div class="form-check form-switch mb-3">
			<?php echo CHtml::activeCheckBox($model, 'status', array('class' => 'form-check-input', 'value' => Member::STATUS_ACTIVE, 'uncheckValue' => Member::STATUS_INACTIVE)); ?>
			<label class="form-check-label">Active</label>
		</div>

		<div class="d-flex gap-2">
			<button type="submit" class="btn btn-bkgs-primary"><?php echo $isNew ? 'Add Member' : 'Save Changes'; ?></button>
			<a href="<?php echo Yii::app()->createUrl('/admin/member'); ?>" class="btn btn-outline-secondary">Cancel</a>
		</div>
	</form>
</div>
