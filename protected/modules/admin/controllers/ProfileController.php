<?php

/**
 * Since admin login is OTP-only (no persistent password), the "Change
 * Password" module is reinterpreted as a Profile screen for updating your
 * own display name.
 */
class ProfileController extends AdminController
{
	public function actionIndex()
	{
		$model = $this->currentUser();
		$this->pageTitle = 'Profile';

		if (isset($_POST['User'])) {
			$model->name = isset($_POST['User']['name']) ? trim($_POST['User']['name']) : $model->name;
			if ($model->name !== '' && $model->save(false, array('name'))) {
				Yii::app()->user->setState('name', $model->name);
				Yii::app()->user->setFlash('success', 'Profile updated successfully.');
				$this->redirect(array('/admin/profile'));
			}
		}

		$this->render('index', array('model' => $model));
	}
}
