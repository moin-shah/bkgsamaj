<div class="d-flex justify-content-between align-items-center mb-3">
	<p class="text-muted mb-0">Manage who can sign in to this admin panel, and what they can access.</p>
	<a href="<?php echo Yii::app()->createUrl('/admin/user/create'); ?>" class="btn btn-bkgs-primary">+ Add User</a>
</div>

<div class="admin-card">
	<div class="table-responsive">
		<table class="table admin-table align-middle mb-0">
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Role</th>
					<th>District</th>
					<th>Status</th>
					<th class="text-end">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $user): ?>
					<tr>
						<td><?php echo CHtml::encode($user->name); ?></td>
						<td class="text-muted small"><?php echo CHtml::encode($user->email); ?></td>
						<td><span class="badge bg-secondary"><?php echo CHtml::encode($user->role); ?></span></td>
						<td class="text-muted small"><?php echo $user->district ? CHtml::encode($user->district->name) : '&mdash;'; ?></td>
						<td>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/user/toggleStatus', array('id' => $user->id)); ?>">
								<button type="submit" class="badge border-0 <?php echo $user->status ? 'bg-success' : 'bg-secondary'; ?>">
									<?php echo $user->status ? 'Active' : 'Inactive'; ?>
								</button>
							</form>
						</td>
						<td class="text-end">
							<a href="<?php echo Yii::app()->createUrl('/admin/user/update', array('id' => $user->id)); ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/user/delete', array('id' => $user->id)); ?>" class="d-inline" onsubmit="return confirm('Delete this user?');">
								<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
