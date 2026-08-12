<?php $isNew = $model->isNewRecord; ?>

<div class="admin-card admin-card-narrow">
	<form method="post" action="<?php echo $isNew ? Yii::app()->createUrl('/admin/user/create') : Yii::app()->createUrl('/admin/user/update', array('id' => $model->id)); ?>">
		<?php echo CHtml::errorSummary($model); ?>

		<div class="mb-3">
			<label class="form-label">Name</label>
			<?php echo CHtml::activeTextField($model, 'name', array('class' => 'form-control')); ?>
		</div>

		<div class="mb-3">
			<label class="form-label">Email</label>
			<?php echo CHtml::activeTextField($model, 'email', array('class' => 'form-control')); ?>
			<div class="form-text">They'll sign in with this email using the same OTP flow as any other admin.</div>
		</div>

		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">Role</label>
				<?php echo CHtml::activeDropDownList($model, 'role', array(
					'super_admin' => 'Super Admin - full system access',
					'all_district_admin' => 'All-District Admin - all districts, no system access',
					'district_admin' => 'District Admin - one district only',
				), array('class' => 'form-select', 'id' => 'user-role')); ?>
			</div>
			<div class="col-md-6 mb-3" id="user-district-wrap">
				<label class="form-label">District</label>
				<?php echo CHtml::activeDropDownList($model, 'district_id', $districtOptions, array('class' => 'form-select')); ?>
				<div class="form-text">Only used when Role is District Admin.</div>
			</div>
		</div>

		<div class="form-check form-switch mb-3">
			<?php echo CHtml::activeCheckBox($model, 'status', array('class' => 'form-check-input')); ?>
			<label class="form-check-label">Active</label>
		</div>

		<div class="d-flex gap-2">
			<button type="submit" class="btn btn-bkgs-primary"><?php echo $isNew ? 'Add User' : 'Save Changes'; ?></button>
			<a href="<?php echo Yii::app()->createUrl('/admin/user'); ?>" class="btn btn-outline-secondary">Cancel</a>
		</div>
	</form>
</div>

<script>
(function () {
	var roleSelect = document.getElementById('user-role');
	var districtWrap = document.getElementById('user-district-wrap');
	function syncDistrictVisibility() {
		districtWrap.style.display = roleSelect.value === 'district_admin' ? '' : 'none';
	}
	roleSelect.addEventListener('change', syncDistrictVisibility);
	syncDistrictVisibility();
})();
</script>
