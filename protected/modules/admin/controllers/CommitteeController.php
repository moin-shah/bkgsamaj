<?php

/**
 * Access rule specific to this module (per explicit request, does not use
 * the general applyDistrictScope pattern): every role sees committee data
 * for every district. Only a district_admin is restricted, and it's a
 * write restriction, not a visibility one - they can view all districts'
 * committees but cannot add/edit/delete anything.
 */
class CommitteeController extends AdminController
{
	public function actionIndex()
	{
		$this->pageTitle = 'Committee';
		$this->render('index', array(
			'entries' => Committee::model()->ordered()->findAll(),
		));
	}

	public function actionCreate()
	{
		$this->denyIfDistrictAdmin();

		$model = new Committee();
		$this->pageTitle = 'Add Committee Entry';

		if (isset($_POST['Committee'])) {
			$model->attributes = $_POST['Committee'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Committee entry added successfully.');
				$this->redirect(array('/admin/committee'));
			}
		}

		$this->render('form', array('model' => $model, 'districtOptions' => $this->allDistrictOptions()));
	}

	public function actionUpdate($id)
	{
		$this->denyIfDistrictAdmin();

		$model = $this->loadModel($id);
		$this->pageTitle = 'Edit Committee Entry';

		if (isset($_POST['Committee'])) {
			$model->attributes = $_POST['Committee'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Committee entry updated successfully.');
				$this->redirect(array('/admin/committee'));
			}
		}

		$this->render('form', array('model' => $model, 'districtOptions' => $this->allDistrictOptions()));
	}

	public function actionDelete($id)
	{
		$this->denyIfDistrictAdmin();

		if (Yii::app()->request->isPostRequest) {
			$this->loadModel($id)->delete();
			Yii::app()->user->setFlash('success', 'Committee entry deleted.');
		}

		$this->redirect(array('/admin/committee'));
	}

	public function actionToggleStatus($id)
	{
		$this->denyIfDistrictAdmin();

		if (Yii::app()->request->isPostRequest) {
			$model = $this->loadModel($id);
			$model->status = $model->status ? 0 : 1;
			$model->save(false, array('status'));
		}

		$this->redirect(array('/admin/committee'));
	}

	private function denyIfDistrictAdmin()
	{
		if ($this->isDistrictAdmin()) {
			throw new CHttpException(403, 'District Admins have view-only access to Committee data.');
		}
	}

	/**
	 * View-all rule: no district scoping on read - any role can open any
	 * district's committee entry.
	 */
	private function loadModel($id)
	{
		$model = Committee::model()->findByPk((int) $id);
		if ($model === null) {
			throw new CHttpException(404, 'Committee entry not found.');
		}

		return $model;
	}

	/**
	 * Plain full district list - District is a required field on this
	 * form (no "Samaj-wide" option, unlike AdminController::districtOptions()),
	 * and this controller is only reachable by roles that see every district.
	 */
	private function allDistrictOptions()
	{
		$options = array();
		foreach (District::model()->ordered()->findAll() as $district) {
			$options[$district->id] = $district->name;
		}

		return $options;
	}
}
