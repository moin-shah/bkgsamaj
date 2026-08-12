<?php

/**
 * Base controller for the admin module. Requires an authenticated admin for
 * every action except the login/verify-otp/logout actions on DefaultController.
 */
class AdminController extends CController
{
	public $layout = '/layouts/admin';

	private static $publicActions = array('login', 'requestOtp', 'verifyOtp', 'logout');

	public function beforeAction($action)
	{
		$isPublic = ($this->id === 'default' && in_array($action->id, self::$publicActions));

		if (!$isPublic && Yii::app()->user->isGuest) {
			Yii::app()->user->loginUrl = array('/admin/default/login');
			Yii::app()->user->loginRequired();

			return false;
		}

		return parent::beforeAction($action);
	}

	public function currentUser()
	{
		return User::model()->findByPk(Yii::app()->user->id);
	}

	/**
	 * @return integer|null the district this admin is confined to, or null
	 * if they can see/manage every district (super_admin, all_district_admin).
	 */
	public function getScopeDistrictId()
	{
		$user = $this->currentUser();

		return $user ? $user->getScopeDistrictId() : null;
	}

	/**
	 * @return bool whether the current admin is a district_admin - used by
	 * modules (Committee, Member) that apply access rules different from
	 * the general district-scoping pattern above.
	 */
	public function isDistrictAdmin()
	{
		$user = $this->currentUser();

		return $user !== null && $user->role === 'district_admin';
	}

	/**
	 * Guards system-level areas (Users, site-wide CMS/Settings, the District
	 * list itself) that only a Super Admin may reach - an All-District Admin
	 * manages every district's content but not the system configuration.
	 */
	public function requireSystemAccess()
	{
		$user = $this->currentUser();

		if ($user === null || !$user->hasSystemAccess()) {
			throw new CHttpException(403, 'Only a Super Admin can access this.');
		}
	}

	/**
	 * Restricts a district-scoped listing to the current admin's district
	 * plus Samaj-wide (district_id IS NULL) rows. No-op for unscoped admins.
	 */
	public function applyDistrictScope(CDbCriteria $criteria)
	{
		$scopeDistrictId = $this->getScopeDistrictId();

		if ($scopeDistrictId !== null) {
			$criteria->addCondition('district_id = :scopeDistrictId OR district_id IS NULL');
			$criteria->params[':scopeDistrictId'] = $scopeDistrictId;
		}

		return $criteria;
	}

	/**
	 * Pins district_id on a model being created/updated to the current
	 * admin's own district when they're scoped - a district_admin can't
	 * reassign a record to another district or make it Samaj-wide.
	 */
	public function enforceDistrictOnSave($model)
	{
		$scopeDistrictId = $this->getScopeDistrictId();

		if ($scopeDistrictId !== null) {
			$model->district_id = $scopeDistrictId;
		}

		return $model;
	}

	/**
	 * District dropdown options for a form. A district_admin only gets
	 * their own district; everyone else gets the full list plus a
	 * Samaj-wide option.
	 */
	public function districtOptions()
	{
		$scopeDistrictId = $this->getScopeDistrictId();

		if ($scopeDistrictId !== null) {
			$district = District::model()->findByPk($scopeDistrictId);

			return $district ? array($district->id => $district->name) : array();
		}

		$options = array('' => 'Samaj-wide (all districts)');
		foreach (District::model()->ordered()->findAll() as $district) {
			$options[$district->id] = $district->name;
		}

		return $options;
	}
}
