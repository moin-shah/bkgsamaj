<?php
$route = Yii::app()->controller->id;
$isSuperAdmin = Yii::app()->user->getState('role') === 'super_admin';
?>
<aside class="admin-sidebar">
	<div class="admin-sidebar-brand">
		<img src="/images/logo/bkgs-logo.png" alt="BKGS Logo" height="36">
		<span>BKGS Admin</span>
	</div>
	<nav class="admin-sidebar-nav">
		<a href="<?php echo Yii::app()->createUrl('/admin/dashboard'); ?>" class="<?php echo $route === 'dashboard' ? 'active' : ''; ?>">
			<span class="admin-nav-icon">&#128202;</span> Dashboard
		</a>

		<div class="admin-nav-heading">Community</div>
		<a href="<?php echo Yii::app()->createUrl('/admin/member'); ?>" class="<?php echo $route === 'member' ? 'active' : ''; ?>">
			<span class="admin-nav-icon">&#128101;</span> Members
		</a>
		<a href="<?php echo Yii::app()->createUrl('/admin/committee'); ?>" class="<?php echo $route === 'committee' ? 'active' : ''; ?>">
			<span class="admin-nav-icon">&#127942;</span> Committee
		</a>

		<div class="admin-nav-heading">Content</div>
		<a href="<?php echo Yii::app()->createUrl('/admin/event'); ?>" class="<?php echo $route === 'event' ? 'active' : ''; ?>">
			<span class="admin-nav-icon">&#128197;</span> Events
		</a>
		<a href="<?php echo Yii::app()->createUrl('/admin/news'); ?>" class="<?php echo $route === 'news' ? 'active' : ''; ?>">
			<span class="admin-nav-icon">&#128240;</span> News
		</a>
		<a href="<?php echo Yii::app()->createUrl('/admin/rajaChithi'); ?>" class="<?php echo $route === 'rajaChithi' ? 'active' : ''; ?>">
			<span class="admin-nav-icon">&#128220;</span> Raja Chithi
		</a>
		<a href="<?php echo Yii::app()->createUrl('/admin/download'); ?>" class="<?php echo $route === 'download' ? 'active' : ''; ?>">
			<span class="admin-nav-icon">&#128190;</span> Downloads
		</a>
		<a href="<?php echo Yii::app()->createUrl('/admin/gallery'); ?>" class="<?php echo $route === 'gallery' ? 'active' : ''; ?>">
			<span class="admin-nav-icon">&#128247;</span> Gallery
		</a>
		<a href="<?php echo Yii::app()->createUrl('/admin/notification'); ?>" class="<?php echo $route === 'notification' ? 'active' : ''; ?>">
			<span class="admin-nav-icon">&#128276;</span> Notifications
		</a>

		<a href="<?php echo Yii::app()->createUrl('/admin/profile'); ?>" class="<?php echo $route === 'profile' ? 'active' : ''; ?>">
			<span class="admin-nav-icon">&#128100;</span> Profile
		</a>

		<?php if ($isSuperAdmin): ?>
			<div class="admin-nav-heading">System (Super Admin)</div>
			<a href="<?php echo Yii::app()->createUrl('/admin/district'); ?>" class="<?php echo $route === 'district' ? 'active' : ''; ?>">
				<span class="admin-nav-icon">&#128506;</span> Districts
			</a>
			<a href="<?php echo Yii::app()->createUrl('/admin/cms'); ?>" class="<?php echo $route === 'cms' ? 'active' : ''; ?>">
				<span class="admin-nav-icon">&#128221;</span> CMS
			</a>
			<a href="<?php echo Yii::app()->createUrl('/admin/user'); ?>" class="<?php echo $route === 'user' ? 'active' : ''; ?>">
				<span class="admin-nav-icon">&#128272;</span> Users
			</a>
		<?php endif; ?>
	</nav>
	<div class="admin-sidebar-footer">
		<a href="/" class="text-white-50 small d-block mb-2">&larr; View Website</a>
		<form method="post" action="<?php echo Yii::app()->createUrl('/admin/default/logout'); ?>">
			<button type="submit" class="btn btn-sm btn-outline-light w-100">Logout</button>
		</form>
	</div>
</aside>
