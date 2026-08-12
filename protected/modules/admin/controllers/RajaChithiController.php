<?php

class RajaChithiController extends AdminController
{
	public function actionIndex()
	{
		$this->pageTitle = 'Raja Chithi';
		$criteria = new CDbCriteria();
		$this->applyDistrictScope($criteria);
		$criteria->order = 'issued_date DESC';

		$this->render('index', array(
			'rajaChithis' => RajaChithi::model()->findAll($criteria),
		));
	}

	public function actionCreate()
	{
		$model = new RajaChithi();
		$this->pageTitle = 'Add Raja Chithi';

		if (isset($_POST['RajaChithi'])) {
			$model->attributes = $_POST['RajaChithi'];
			$this->enforceDistrictOnSave($model);
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Raja Chithi added successfully.');
				$this->redirect(array('/admin/rajaChithi'));
			}
		}

		$this->render('form', array('model' => $model, 'districtOptions' => $this->districtOptions()));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$this->pageTitle = 'Edit Raja Chithi';

		if (isset($_POST['RajaChithi'])) {
			$model->attributes = $_POST['RajaChithi'];
			$this->enforceDistrictOnSave($model);
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Raja Chithi updated successfully.');
				$this->redirect(array('/admin/rajaChithi'));
			}
		}

		$this->render('form', array('model' => $model, 'districtOptions' => $this->districtOptions()));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$this->loadModel($id)->delete();
			Yii::app()->user->setFlash('success', 'Raja Chithi deleted.');
		}

		$this->redirect(array('/admin/rajaChithi'));
	}

	public function actionToggleStatus($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$model = $this->loadModel($id);
			$model->status = $model->status ? 0 : 1;
			$model->save(false, array('status'));
		}

		$this->redirect(array('/admin/rajaChithi'));
	}

	/**
	 * Loads a row and enforces the district scope even on direct-URL
	 * access - a district_admin can't open another district's raja
	 * chithi by guessing its id.
	 */
	private function loadModel($id)
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('id = :id');
		$criteria->params[':id'] = (int) $id;
		$this->applyDistrictScope($criteria);

		$model = RajaChithi::model()->find($criteria);
		if ($model === null) {
			throw new CHttpException(404, 'Raja Chithi not found.');
		}

		return $model;
	}
}
