<div class="d-flex justify-content-between align-items-center mb-3">
	<p class="text-muted mb-0">Manage news articles shown on the public News page and the Home page's Latest News section.</p>
	<a href="<?php echo Yii::app()->createUrl('/admin/news/create'); ?>" class="btn btn-bkgs-primary">+ Add News</a>
</div>

<div class="admin-card">
	<div class="table-responsive">
		<table class="table admin-table align-middle mb-0">
			<thead>
				<tr>
					<th>Title</th>
					<th>Published At</th>
					<th>Status</th>
					<th class="text-end">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($newsItems)): ?>
					<tr><td colspan="4" class="text-center text-muted py-4">No news articles yet.</td></tr>
				<?php endif; ?>
				<?php foreach ($newsItems as $newsItem): ?>
					<tr>
						<td><?php echo CHtml::encode($newsItem->title); ?></td>
						<td class="text-muted small"><?php echo $newsItem->published_at ? CHtml::encode(date('d M Y, h:i A', strtotime($newsItem->published_at))) : '&mdash;'; ?></td>
						<td>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/news/toggleStatus', array('id' => $newsItem->id)); ?>">
								<button type="submit" class="badge border-0 <?php echo $newsItem->status ? 'bg-success' : 'bg-secondary'; ?>">
									<?php echo $newsItem->status ? 'Published' : 'Hidden'; ?>
								</button>
							</form>
						</td>
						<td class="text-end">
							<a href="<?php echo Yii::app()->createUrl('/admin/news/update', array('id' => $newsItem->id)); ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
							<form method="post" action="<?php echo Yii::app()->createUrl('/admin/news/delete', array('id' => $newsItem->id)); ?>" class="d-inline" onsubmit="return confirm('Delete this news article?');">
								<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
