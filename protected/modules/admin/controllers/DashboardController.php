<?php

class DashboardController extends AdminController
{
	public function actionIndex()
	{
		$this->pageTitle = 'Dashboard';

		$memberCriteria = new CDbCriteria();
		$this->applyDistrictScope($memberCriteria);

		$eventCriteria = new CDbCriteria();
		$this->applyDistrictScope($eventCriteria);

		$this->render('index', array(
			'districtCount' => District::model()->count(),
			'memberCount' => Member::model()->count($memberCriteria),
			'eventCount' => Event::model()->count($eventCriteria),
		));
	}
}
