<?php $categoryLabels = Download::categoryLabels(); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
	<p class="text-muted mb-0">Manage documents shown on the public Downloads page, including Rules &amp; Regulations.</p>
	<a href="<?php echo Yii::app()->createUrl('/admin/download/create'); ?>" class="btn btn-bkgs-primary">+ Add Download</a>
</div>

<div class="admin-card">
	<div class="table-responsive">
		<table class="table admin-table align-middle mb-0">
			<thead>
				<tr>
					<th>Title</th>
					<th>Category</th>
					<th>District</th>
					<th>Status</th>
					<th class="text-end">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($downloads)): ?>
					<tr><td colspan="5" class="text-center text-muted py-4">No downloads yet.</td></tr>
				<?php endif; ?>
				<?php foreach ($downloads as $download): ?>
					<tr>
						<td><?php echo CHtml::encode($download->title); ?></td>
						<td class="text-muted small"><?php echo CHtml::encode(isset($categoryLabels[$download->category]) ? $categoryLabels[$download->category] : $download->category); ?></td>
						<td class="text-muted small"><?php echo $download->district ? CHtml::encode($download->district->name) : 'Samaj-wide'; ?></td>
						<td>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/download/toggleStatus', array('id' => $download->id)); ?>">
								<button type="submit" class="badge border-0 <?php echo $download->status ? 'bg-success' : 'bg-secondary'; ?>">
									<?php echo $download->status ? 'Published' : 'Hidden'; ?>
								</button>
							</form>
						</td>
						<td class="text-end">
							<a href="<?php echo Yii::app()->createUrl('/admin/download/update', array('id' => $download->id)); ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/download/delete', array('id' => $download->id)); ?>" class="d-inline" onsubmit="return confirm('Delete this download?');">
								<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
