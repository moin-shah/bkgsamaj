<div class="d-flex justify-content-between align-items-center mb-3">
	<p class="text-muted mb-0">Manage notifications shown to admins and members.</p>
	<a href="<?php echo Yii::app()->createUrl('/admin/notification/create'); ?>" class="btn btn-bkgs-primary">+ Add Notification</a>
</div>

<div class="admin-card">
	<div class="table-responsive">
		<table class="table admin-table align-middle mb-0">
			<thead>
				<tr>
					<th>Title</th>
					<th>Audience</th>
					<th>Status</th>
					<th class="text-end">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($notifications)): ?>
					<tr><td colspan="4" class="text-center text-muted py-4">No notifications yet.</td></tr>
				<?php endif; ?>
				<?php
					$audienceLabels = array('all' => 'Everyone', 'district' => 'One District', 'role' => 'One Role');
				?>
				<?php foreach ($notifications as $notification): ?>
					<tr>
						<td><?php echo CHtml::encode($notification->title); ?></td>
						<td class="text-muted small">
							<?php echo CHtml::encode(isset($audienceLabels[$notification->audience]) ? $audienceLabels[$notification->audience] : $notification->audience); ?>
							<?php if ($notification->audience !== 'all' && $notification->audience_value): ?>
								(<?php echo CHtml::encode($notification->audience_value); ?>)
							<?php endif; ?>
						</td>
						<td>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/notification/toggleStatus', array('id' => $notification->id)); ?>">
								<button type="submit" class="badge border-0 <?php echo $notification->status ? 'bg-success' : 'bg-secondary'; ?>">
									<?php echo $notification->status ? 'Active' : 'Inactive'; ?>
								</button>
							</form>
						</td>
						<td class="text-end">
							<a href="<?php echo Yii::app()->createUrl('/admin/notification/update', array('id' => $notification->id)); ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/notification/delete', array('id' => $notification->id)); ?>" class="d-inline" onsubmit="return confirm('Delete this notification?');">
								<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
