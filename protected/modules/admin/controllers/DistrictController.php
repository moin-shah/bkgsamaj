<?php

class DistrictController extends AdminController
{
	public function beforeAction($action)
	{
		if (!parent::beforeAction($action)) {
			return false;
		}

		$this->requireSystemAccess();

		return true;
	}

	public function actionIndex()
	{
		$this->pageTitle = 'Districts';
		$this->render('index', array(
			'districts' => District::model()->findAll(array('order' => 'display_order ASC, name ASC')),
		));
	}

	public function actionCreate()
	{
		$model = new District();
		$this->pageTitle = 'Add District';

		if (isset($_POST['District'])) {
			$model->attributes = $_POST['District'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'District added successfully.');
				$this->redirect(array('/admin/district'));
			}
		}

		$this->render('form', array('model' => $model));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$this->pageTitle = 'Edit District';

		if (isset($_POST['District'])) {
			$model->attributes = $_POST['District'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'District updated successfully.');
				$this->redirect(array('/admin/district'));
			}
		}

		$this->render('form', array('model' => $model));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$this->loadModel($id)->delete();
			Yii::app()->user->setFlash('success', 'District deleted.');
		}

		$this->redirect(array('/admin/district'));
	}

	public function actionToggleStatus($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$model = $this->loadModel($id);
			$model->status = $model->status ? 0 : 1;
			$model->save(false, array('status'));
		}

		$this->redirect(array('/admin/district'));
	}

	private function loadModel($id)
	{
		$model = District::model()->findByPk((int) $id);
		if ($model === null) {
			throw new CHttpException(404, 'District not found.');
		}

		return $model;
	}
}
