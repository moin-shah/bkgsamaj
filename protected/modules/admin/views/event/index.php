<div class="d-flex justify-content-between align-items-center mb-3">
	<p class="text-muted mb-0">Manage events shown on the public Events page and the Home page's Upcoming Event section.</p>
	<a href="<?php echo Yii::app()->createUrl('/admin/event/create'); ?>" class="btn btn-bkgs-primary">+ Add Event</a>
</div>

<div class="admin-card">
	<div class="table-responsive">
		<table class="table admin-table align-middle mb-0">
			<thead>
				<tr>
					<th>Title</th>
					<th>District</th>
					<th>Starts</th>
					<th>Status</th>
					<th class="text-end">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($events)): ?>
					<tr><td colspan="5" class="text-center text-muted py-4">No events yet.</td></tr>
				<?php endif; ?>
				<?php foreach ($events as $event): ?>
					<tr>
						<td><?php echo CHtml::encode($event->title); ?></td>
						<td class="text-muted small"><?php echo $event->district ? CHtml::encode($event->district->name) : 'Samaj-wide'; ?></td>
						<td class="text-muted small"><?php echo CHtml::encode(date('d M Y, h:i A', strtotime($event->start_at))); ?></td>
						<td>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/event/toggleStatus', array('id' => $event->id)); ?>">
								<button type="submit" class="badge border-0 <?php echo $event->status ? 'bg-success' : 'bg-secondary'; ?>">
									<?php echo $event->status ? 'Published' : 'Hidden'; ?>
								</button>
							</form>
						</td>
						<td class="text-end">
							<a href="<?php echo Yii::app()->createUrl('/admin/event/update', array('id' => $event->id)); ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/event/delete', array('id' => $event->id)); ?>" class="d-inline" onsubmit="return confirm('Delete this event?');">
								<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
