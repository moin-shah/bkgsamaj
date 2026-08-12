<p class="text-muted">Manage the content shown on the public website.</p>

<div class="row g-4">
	<?php foreach ($pages as $page): ?>
		<div class="col-md-4">
			<div class="admin-card h-100">
				<h6><?php echo CHtml::encode($page->title); ?></h6>
				<p class="text-muted small mb-3"><?php echo CHtml::encode($page->slug); ?></p>
				<a href="<?php echo Yii::app()->createUrl('/admin/cms/edit', array('slug' => $page->slug)); ?>" class="btn btn-sm btn-bkgs-primary">Edit</a>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="col-md-4">
		<div class="admin-card h-100">
			<h6>General Settings</h6>
			<p class="text-muted small mb-3">Site name, tagline, footer &amp; highlights</p>
			<a href="<?php echo Yii::app()->createUrl('/admin/cms/settings'); ?>" class="btn btn-sm btn-bkgs-primary">Edit</a>
		</div>
	</div>
</div>
