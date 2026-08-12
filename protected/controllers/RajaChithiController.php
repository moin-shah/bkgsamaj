<?php

/**
 * Public listing of formal Samaj-issued circulars and notices.
 */
class RajaChithiController extends PublicController
{
	public function actionIndex()
	{
		$rajaChithis = RajaChithi::model()->published()->findAll();

		$this->pageTitle = $this->getSiteName() . ' - Raja Chithi';
		$this->render('index', array(
			'rajaChithis' => $rajaChithis,
		));
	}
}
