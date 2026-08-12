<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="icon" href="/images/logo/favicon.ico">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/admin.css">
</head>
<body class="admin-body">

<div class="admin-shell">
	<?php echo $this->renderPartial('/layouts/_admin_sidebar', array(), true); ?>

	<div class="admin-main">
		<?php echo $this->renderPartial('/layouts/_admin_topbar', array(), true); ?>

		<div class="admin-content">
			<?php foreach (Yii::app()->user->getFlashes() as $key => $message): ?>
				<div class="alert alert-<?php echo $key === 'success' ? 'success' : ($key === 'error' ? 'danger' : 'info'); ?>">
					<?php echo $message; ?>
				</div>
			<?php endforeach; ?>

			<?php $latestNotification = Notification::model()->active()->find(); ?>
			<?php if ($latestNotification !== null): ?>
				<div class="admin-notification-banner">
					<span class="admin-nav-icon">&#128276;</span>
					<span><strong><?php echo CHtml::encode($latestNotification->title); ?></strong> &mdash; <?php echo CHtml::encode($latestNotification->message); ?></span>
					<a href="<?php echo Yii::app()->createUrl('/admin/notification'); ?>" class="ms-auto small text-nowrap">All notifications &rarr;</a>
				</div>
			<?php endif; ?>

			<?php echo $content; ?>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
