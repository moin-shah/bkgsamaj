<div class="d-flex justify-content-between align-items-center mb-3">
	<p class="text-muted mb-0">Manage the formal Samaj-issued circulars and notices shown on the public Raja Chithi page.</p>
	<a href="<?php echo Yii::app()->createUrl('/admin/rajaChithi/create'); ?>" class="btn btn-bkgs-primary">+ Add Raja Chithi</a>
</div>

<div class="admin-card">
	<div class="table-responsive">
		<table class="table admin-table align-middle mb-0">
			<thead>
				<tr>
					<th>Title</th>
					<th>District</th>
					<th>Issued On</th>
					<th>Status</th>
					<th class="text-end">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($rajaChithis)): ?>
					<tr><td colspan="5" class="text-center text-muted py-4">No Raja Chithi yet.</td></tr>
				<?php endif; ?>
				<?php foreach ($rajaChithis as $rajaChithi): ?>
					<tr>
						<td><?php echo CHtml::encode($rajaChithi->title); ?></td>
						<td class="text-muted small"><?php echo $rajaChithi->district ? CHtml::encode($rajaChithi->district->name) : 'Samaj-wide'; ?></td>
						<td class="text-muted small"><?php echo CHtml::encode(date('d M Y', strtotime($rajaChithi->issued_date))); ?></td>
						<td>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/rajaChithi/toggleStatus', array('id' => $rajaChithi->id)); ?>">
								<button type="submit" class="badge border-0 <?php echo $rajaChithi->status ? 'bg-success' : 'bg-secondary'; ?>">
									<?php echo $rajaChithi->status ? 'Published' : 'Hidden'; ?>
								</button>
							</form>
						</td>
						<td class="text-end">
							<a href="<?php echo Yii::app()->createUrl('/admin/rajaChithi/update', array('id' => $rajaChithi->id)); ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/rajaChithi/delete', array('id' => $rajaChithi->id)); ?>" class="d-inline" onsubmit="return confirm('Delete this Raja Chithi?');">
								<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
