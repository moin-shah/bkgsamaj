<?php

class EventController extends AdminController
{
	public function actionIndex()
	{
		$this->pageTitle = 'Events';
		$criteria = new CDbCriteria();
		$this->applyDistrictScope($criteria);
		$criteria->order = 'start_at DESC';

		$this->render('index', array(
			'events' => Event::model()->findAll($criteria),
		));
	}

	public function actionCreate()
	{
		$model = new Event();
		$this->pageTitle = 'Add Event';

		if (isset($_POST['Event'])) {
			$model->attributes = $_POST['Event'];
			$this->enforceDistrictOnSave($model);
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Event added successfully.');
				$this->redirect(array('/admin/event'));
			}
		}

		$this->render('form', array('model' => $model, 'districtOptions' => $this->districtOptions()));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$this->pageTitle = 'Edit Event';

		if (isset($_POST['Event'])) {
			$model->attributes = $_POST['Event'];
			$this->enforceDistrictOnSave($model);
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Event updated successfully.');
				$this->redirect(array('/admin/event'));
			}
		}

		$this->render('form', array('model' => $model, 'districtOptions' => $this->districtOptions()));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$this->loadModel($id)->delete();
			Yii::app()->user->setFlash('success', 'Event deleted.');
		}

		$this->redirect(array('/admin/event'));
	}

	public function actionToggleStatus($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$model = $this->loadModel($id);
			$model->status = $model->status ? 0 : 1;
			$model->save(false, array('status'));
		}

		$this->redirect(array('/admin/event'));
	}

	/**
	 * Loads a row and enforces the district scope even on direct-URL
	 * access - a district_admin can't open another district's event by
	 * guessing its id.
	 */
	private function loadModel($id)
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('id = :id');
		$criteria->params[':id'] = (int) $id;
		$this->applyDistrictScope($criteria);

		$model = Event::model()->find($criteria);
		if ($model === null) {
			throw new CHttpException(404, 'Event not found.');
		}

		return $model;
	}
}
