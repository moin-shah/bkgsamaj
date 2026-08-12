<?php

/**
 * Manages admin accounts (super_admin/admin/editor/district_admin). Creating
 * or changing another admin's access is sensitive, so this whole controller
 * is restricted to super_admin regardless of what the generic AdminController
 * login guard would otherwise allow.
 */
class UserController extends AdminController
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
		$this->pageTitle = 'Users';
		$this->render('index', array(
			'users' => User::model()->findAll(array('order' => 'name ASC')),
		));
	}

	public function actionCreate()
	{
		$model = new User();
		$model->status = User::STATUS_ACTIVE;
		$this->pageTitle = 'Add User';

		if (isset($_POST['User'])) {
			$model->attributes = $_POST['User'];
			if ($model->role !== 'district_admin') {
				$model->district_id = null;
			}
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'User added successfully.');
				$this->redirect(array('/admin/user'));
			}
		}

		$this->render('form', array('model' => $model, 'districtOptions' => $this->allDistrictOptions()));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$this->pageTitle = 'Edit User';

		if (isset($_POST['User'])) {
			$model->attributes = $_POST['User'];
			if ($model->role !== 'district_admin') {
				$model->district_id = null;
			}
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'User updated successfully.');
				$this->redirect(array('/admin/user'));
			}
		}

		$this->render('form', array('model' => $model, 'districtOptions' => $this->allDistrictOptions()));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$model = $this->loadModel($id);
			if ((int) $model->id === (int) Yii::app()->user->id) {
				Yii::app()->user->setFlash('error', "You can't delete your own account.");
			} else {
				$model->delete();
				Yii::app()->user->setFlash('success', 'User deleted.');
			}
		}

		$this->redirect(array('/admin/user'));
	}

	public function actionToggleStatus($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$model = $this->loadModel($id);
			if ((int) $model->id === (int) Yii::app()->user->id) {
				Yii::app()->user->setFlash('error', "You can't deactivate your own account.");
			} else {
				$model->status = $model->status ? 0 : 1;
				$model->save(false, array('status'));
			}
		}

		$this->redirect(array('/admin/user'));
	}

	/**
	 * Full district list for the create/edit form - unlike
	 * AdminController::districtOptions(), this is never scoped, since only
	 * a super_admin (who sees every district) reaches this controller.
	 */
	private function allDistrictOptions()
	{
		$options = array('' => '-- Not district-scoped --');
		foreach (District::model()->ordered()->findAll() as $district) {
			$options[$district->id] = $district->name;
		}

		return $options;
	}

	private function loadModel($id)
	{
		$model = User::model()->findByPk((int) $id);
		if ($model === null) {
			throw new CHttpException(404, 'User not found.');
		}

		return $model;
	}
}
