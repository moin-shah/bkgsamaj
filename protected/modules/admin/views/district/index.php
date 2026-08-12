<div class="d-flex justify-content-between align-items-center mb-3">
	<p class="text-muted mb-0">Manage the districts shown on the public District List page.</p>
	<a href="<?php echo Yii::app()->createUrl('/admin/district/create'); ?>" class="btn btn-bkgs-primary">+ Add District</a>
</div>

<div class="admin-card">
	<div class="table-responsive">
		<table class="table admin-table align-middle mb-0">
			<thead>
				<tr>
					<th>Order</th>
					<th>Name</th>
					<th>Description</th>
					<th>Status</th>
					<th class="text-end">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($districts)): ?>
					<tr><td colspan="5" class="text-center text-muted py-4">No districts yet.</td></tr>
				<?php endif; ?>
				<?php foreach ($districts as $district): ?>
					<tr>
						<td><?php echo (int) $district->display_order; ?></td>
						<td><?php echo CHtml::encode($district->name); ?></td>
						<td class="text-muted small"><?php echo CHtml::encode(mb_strimwidth((string) $district->description, 0, 80, '...')); ?></td>
						<td>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/district/toggleStatus', array('id' => $district->id)); ?>">
								<button type="submit" class="badge border-0 <?php echo $district->status ? 'bg-success' : 'bg-secondary'; ?>">
									<?php echo $district->status ? 'Active' : 'Inactive'; ?>
								</button>
							</form>
						</td>
						<td class="text-end">
							<a href="<?php echo Yii::app()->createUrl('/admin/district/update', array('id' => $district->id)); ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/district/delete', array('id' => $district->id)); ?>" class="d-inline" onsubmit="return confirm('Delete this district?');">
								<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
