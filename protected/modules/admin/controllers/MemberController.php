<?php

class MemberController extends AdminController
{
	public function actionIndex()
	{
		$this->pageTitle = 'Members';
		$criteria = new CDbCriteria();
		$this->applyMemberDistrictScope($criteria);
		$criteria->order = 'first_name ASC, last_name ASC';

		$this->render('index', array(
			'members' => Member::model()->findAll($criteria),
		));
	}

	public function actionCreate()
	{
		$model = new Member();
		$model->registration_source = Member::SOURCE_ADMIN;
		$this->pageTitle = 'Add Member';

		if (isset($_POST['Member'])) {
			$model->attributes = $_POST['Member'];
			$model->registration_source = Member::SOURCE_ADMIN;
			$this->enforceDistrictOnSave($model);
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Member added successfully.');
				$this->redirect(array('/admin/member'));
			}
		}

		$this->render('form', array('model' => $model, 'districtOptions' => $this->districtOptions()));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$this->pageTitle = 'Edit Member';

		if (isset($_POST['Member'])) {
			$model->attributes = $_POST['Member'];
			$model->registration_source = Member::SOURCE_ADMIN;
			$this->enforceDistrictOnSave($model);
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Member updated successfully.');
				$this->redirect(array('/admin/member'));
			}
		}

		$this->render('form', array('model' => $model, 'districtOptions' => $this->districtOptions()));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$this->loadModel($id)->delete();
			Yii::app()->user->setFlash('success', 'Member deleted.');
		}

		$this->redirect(array('/admin/member'));
	}

	/**
	 * Loads a row and enforces the district scope even on direct-URL
	 * access - a district_admin can't open another district's member by
	 * guessing its id.
	 */
	private function loadModel($id)
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('id = :id');
		$criteria->params[':id'] = (int) $id;
		$this->applyMemberDistrictScope($criteria);

		$model = Member::model()->find($criteria);
		if ($model === null) {
			throw new CHttpException(404, 'Member not found.');
		}

		return $model;
	}

	/**
	 * Members are an independent, per-district list (per explicit request):
	 * a district_admin sees only their own district's members, with no
	 * Samaj-wide fallback - unlike AdminController::applyDistrictScope(),
	 * used by every other district-scoped module.
	 */
	private function applyMemberDistrictScope(CDbCriteria $criteria)
	{
		$scopeDistrictId = $this->getScopeDistrictId();

		if ($scopeDistrictId !== null) {
			$criteria->addCondition('district_id = :scopeDistrictId');
			$criteria->params[':scopeDistrictId'] = $scopeDistrictId;
		}

		return $criteria;
	}
}
