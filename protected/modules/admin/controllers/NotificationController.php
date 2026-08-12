<?php

class NotificationController extends AdminController
{
	public function actionIndex()
	{
		$this->pageTitle = 'Notifications';
		$this->render('index', array(
			'notifications' => Notification::model()->findAll(array('order' => 'created_at DESC')),
		));
	}

	public function actionCreate()
	{
		$model = new Notification();
		$this->pageTitle = 'Add Notification';

		if (isset($_POST['Notification'])) {
			$model->attributes = $_POST['Notification'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Notification added successfully.');
				$this->redirect(array('/admin/notification'));
			}
		}

		$this->render('form', array('model' => $model));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$this->pageTitle = 'Edit Notification';

		if (isset($_POST['Notification'])) {
			$model->attributes = $_POST['Notification'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Notification updated successfully.');
				$this->redirect(array('/admin/notification'));
			}
		}

		$this->render('form', array('model' => $model));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$this->loadModel($id)->delete();
			Yii::app()->user->setFlash('success', 'Notification deleted.');
		}

		$this->redirect(array('/admin/notification'));
	}

	public function actionToggleStatus($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$model = $this->loadModel($id);
			$model->status = $model->status ? 0 : 1;
			$model->save(false, array('status'));
		}

		$this->redirect(array('/admin/notification'));
	}

	private function loadModel($id)
	{
		$model = Notification::model()->findByPk((int) $id);
		if ($model === null) {
			throw new CHttpException(404, 'Notification not found.');
		}

		return $model;
	}
}
