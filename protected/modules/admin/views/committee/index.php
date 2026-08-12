<?php $readOnly = $this->isDistrictAdmin(); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
	<p class="text-muted mb-0">
		<?php echo $readOnly ? 'View the committee across all districts (view only).' : 'Manage who holds each committee position, per district.'; ?>
	</p>
	<?php if (!$readOnly): ?>
		<a href="<?php echo Yii::app()->createUrl('/admin/committee/create'); ?>" class="btn btn-bkgs-primary">+ Add Committee Entry</a>
	<?php endif; ?>
</div>

<div class="admin-card">
	<div class="table-responsive">
		<table class="table admin-table align-middle mb-0">
			<thead>
				<tr>
					<th>District</th>
					<th>Position</th>
					<th>Name</th>
					<th>Contact</th>
					<th>Term</th>
					<th>Status</th>
					<?php if (!$readOnly): ?><th class="text-end">Actions</th><?php endif; ?>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($entries)): ?>
					<tr><td colspan="<?php echo $readOnly ? 6 : 7; ?>" class="text-center text-muted py-4">No committee entries yet.</td></tr>
				<?php endif; ?>
				<?php foreach ($entries as $entry): ?>
					<tr>
						<td><?php echo $entry->district ? CHtml::encode($entry->district->name) : '&mdash;'; ?></td>
						<td><?php echo CHtml::encode($entry->position); ?></td>
						<td><?php echo CHtml::encode($entry->full_name); ?></td>
						<td class="text-muted small">
							<?php echo CHtml::encode($entry->phone); ?>
							<?php if ($entry->phone && $entry->email): ?> &middot; <?php endif; ?>
							<?php echo CHtml::encode($entry->email); ?>
						</td>
						<td class="text-muted small">
							<?php echo $entry->term_start ? CHtml::encode(date('d M Y', strtotime($entry->term_start))) : '-'; ?>
							&rarr;
							<?php echo $entry->term_end ? CHtml::encode(date('d M Y', strtotime($entry->term_end))) : 'Current'; ?>
						</td>
						<td>
							<?php if ($readOnly): ?>
								<span class="badge border-0 <?php echo $entry->status ? 'bg-success' : 'bg-secondary'; ?>">
									<?php echo $entry->status ? 'Active' : 'Inactive'; ?>
								</span>
							<?php else: ?>
								<form method="post" action="<?php echo Yii::app()->createUrl('/admin/committee/toggleStatus', array('id' => $entry->id)); ?>">
									<button type="submit" class="badge border-0 <?php echo $entry->status ? 'bg-success' : 'bg-secondary'; ?>">
										<?php echo $entry->status ? 'Active' : 'Inactive'; ?>
									</button>
								</form>
							<?php endif; ?>
						</td>
						<?php if (!$readOnly): ?>
							<td class="text-end">
								<a href="<?php echo Yii::app()->createUrl('/admin/committee/update', array('id' => $entry->id)); ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
								<form method="post" action="<?php echo Yii::app()->createUrl('/admin/committee/delete', array('id' => $entry->id)); ?>" class="d-inline" onsubmit="return confirm('Delete this committee entry?');">
									<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
								</form>
							</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
