<?php

class DownloadController extends AdminController
{
	public function actionIndex()
	{
		$this->pageTitle = 'Downloads';
		$criteria = new CDbCriteria();
		$this->applyDistrictScope($criteria);
		$criteria->order = 'display_order ASC, title ASC';

		$this->render('index', array(
			'downloads' => Download::model()->findAll($criteria),
		));
	}

	public function actionCreate()
	{
		$model = new Download();
		$this->pageTitle = 'Add Download';

		if (isset($_POST['Download'])) {
			$model->attributes = $_POST['Download'];
			$this->enforceDistrictOnSave($model);
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Download added successfully.');
				$this->redirect(array('/admin/download'));
			}
		}

		$this->render('form', array(
			'model' => $model,
			'districtOptions' => $this->districtOptions(),
			'categoryOptions' => Download::categoryLabels(),
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$this->pageTitle = 'Edit Download';

		if (isset($_POST['Download'])) {
			$model->attributes = $_POST['Download'];
			$this->enforceDistrictOnSave($model);
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Download updated successfully.');
				$this->redirect(array('/admin/download'));
			}
		}

		$this->render('form', array(
			'model' => $model,
			'districtOptions' => $this->districtOptions(),
			'categoryOptions' => Download::categoryLabels(),
		));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$this->loadModel($id)->delete();
			Yii::app()->user->setFlash('success', 'Download deleted.');
		}

		$this->redirect(array('/admin/download'));
	}

	public function actionToggleStatus($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$model = $this->loadModel($id);
			$model->status = $model->status ? 0 : 1;
			$model->save(false, array('status'));
		}

		$this->redirect(array('/admin/download'));
	}

	/**
	 * Loads a row and enforces the district scope even on direct-URL
	 * access - a district_admin can't open another district's download
	 * by guessing its id.
	 */
	private function loadModel($id)
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('id = :id');
		$criteria->params[':id'] = (int) $id;
		$this->applyDistrictScope($criteria);

		$model = Download::model()->find($criteria);
		if ($model === null) {
			throw new CHttpException(404, 'Download not found.');
		}

		return $model;
	}
}
