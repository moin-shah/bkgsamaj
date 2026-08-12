<div class="admin-card admin-card-narrow">
	<form method="post" action="<?php echo Yii::app()->createUrl('/admin/profile'); ?>">
		<div class="mb-3">
			<label class="form-label">Email</label>
			<input type="email" class="form-control" value="<?php echo CHtml::encode($model->email); ?>" disabled>
			<div class="form-text">Email is your login identity and can't be changed here.</div>
		</div>
		<div class="mb-3">
			<label class="form-label">Display Name</label>
			<input type="text" class="form-control" name="User[name]" value="<?php echo CHtml::encode($model->name); ?>" required>
		</div>
		<div class="mb-3">
			<label class="form-label">Role</label>
			<input type="text" class="form-control" value="<?php echo CHtml::encode($model->role); ?>" disabled>
		</div>

		<button type="submit" class="btn btn-bkgs-primary">Save Changes</button>
	</form>
</div>
