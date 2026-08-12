<?php

/**
 * Public Downloads listing, grouped by category. The "Rules & Regulations"
 * category section within this same page doubles as the /rules-regulations
 * page (routed separately with a category filter).
 */
class DownloadController extends PublicController
{
	public function actionIndex()
	{
		$downloads = Download::model()->active()->ordered()->findAll();

		$this->pageTitle = $this->getSiteName() . ' - Downloads';
		$this->render('index', array(
			'downloads' => $downloads,
			'categoryLabels' => Download::categoryLabels(),
		));
	}
}
