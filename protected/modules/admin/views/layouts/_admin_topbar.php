<header class="admin-topbar">
	<h5 class="mb-0"><?php echo CHtml::encode($this->pageTitle); ?></h5>
	<div class="admin-topbar-user">
		<span class="admin-user-name"><?php echo CHtml::encode(Yii::app()->user->name); ?></span>
		<span class="admin-user-role"><?php echo CHtml::encode(Yii::app()->user->getState('role')); ?></span>
	</div>
</header>
