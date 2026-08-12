<div class="d-flex justify-content-between align-items-center mb-3">
	<p class="text-muted mb-0">Manage gallery albums and their photos shown on the public Gallery page.</p>
	<a href="<?php echo Yii::app()->createUrl('/admin/gallery/create'); ?>" class="btn btn-bkgs-primary">+ Add Album</a>
</div>

<div class="admin-card">
	<div class="table-responsive">
		<table class="table admin-table align-middle mb-0">
			<thead>
				<tr>
					<th>Title</th>
					<th>District</th>
					<th>Images</th>
					<th>Status</th>
					<th class="text-end">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($albums)): ?>
					<tr><td colspan="5" class="text-center text-muted py-4">No albums yet.</td></tr>
				<?php endif; ?>
				<?php foreach ($albums as $album): ?>
					<tr>
						<td><?php echo CHtml::encode($album->title); ?></td>
						<td class="text-muted small"><?php echo $album->district ? CHtml::encode($album->district->name) : 'Samaj-wide'; ?></td>
						<td class="text-muted small"><?php echo count($album->images); ?></td>
						<td>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/gallery/toggleStatus', array('id' => $album->id)); ?>">
								<button type="submit" class="badge border-0 <?php echo $album->status ? 'bg-success' : 'bg-secondary'; ?>">
									<?php echo $album->status ? 'Published' : 'Hidden'; ?>
								</button>
							</form>
						</td>
						<td class="text-end">
							<a href="<?php echo Yii::app()->createUrl('/admin/gallery/images', array('id' => $album->id)); ?>" class="btn btn-sm btn-outline-secondary">Images</a>
							<a href="<?php echo Yii::app()->createUrl('/admin/gallery/update', array('id' => $album->id)); ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/gallery/delete', array('id' => $album->id)); ?>" class="d-inline" onsubmit="return confirm('Delete this album and all its images?');">
								<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
