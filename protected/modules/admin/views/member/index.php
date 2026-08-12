<div class="d-flex justify-content-between align-items-center mb-3">
	<p class="text-muted mb-0">Manage the Samaj's member records.</p>
	<a href="<?php echo Yii::app()->createUrl('/admin/member/create'); ?>" class="btn btn-bkgs-primary">+ Add Member</a>
</div>

<div class="admin-card">
	<div class="table-responsive">
		<table class="table admin-table align-middle mb-0">
			<thead>
				<tr>
					<th>Name</th>
					<th>District</th>
					<th>Status</th>
					<th class="text-end">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($members)): ?>
					<tr><td colspan="4" class="text-center text-muted py-4">No members yet.</td></tr>
				<?php endif; ?>
				<?php foreach ($members as $member): ?>
					<tr>
						<td><?php echo CHtml::encode($member->getFullName()); ?></td>
						<td class="text-muted small"><?php echo $member->district ? CHtml::encode($member->district->name) : 'Samaj-wide'; ?></td>
						<td>
							<?php
								$statusClass = 'bg-secondary';
								if ($member->status === Member::STATUS_ACTIVE) {
									$statusClass = 'bg-success';
								} elseif ($member->status === Member::STATUS_PENDING) {
									$statusClass = 'bg-warning';
								}
							?>
							<span class="badge <?php echo $statusClass; ?>"><?php echo CHtml::encode(ucfirst($member->status)); ?></span>
						</td>
						<td class="text-end">
							<a href="<?php echo Yii::app()->createUrl('/admin/member/update', array('id' => $member->id)); ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/member/delete', array('id' => $member->id)); ?>" class="d-inline" onsubmit="return confirm('Delete this member?');">
								<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
