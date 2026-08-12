<?php

/**
 * Public Samaj website: Home, About Samaj, District List, Contact Us.
 */
class SiteController extends PublicController
{
	public function actionIndex()
	{
		$home = CmsPage::findBySlug('home_banner');
		$about = CmsPage::findBySlug('about_samaj');
		$contact = CmsPage::findBySlug('contact_info');
		$districts = District::model()->active()->ordered()->findAll();
		$highlights = Setting::getJson('community_highlights', array());

		$news = News::model()->published()->findAll(array('limit' => 3));
		$upcomingEvent = Event::model()->upcoming()->find();

		$this->pageTitle = $this->getSiteName();
		$this->render('index', array(
			'home' => $home,
			'about' => $about,
			'contact' => $contact,
			'districts' => $districts,
			'highlights' => $highlights,
			'news' => $news,
			'upcomingEvent' => $upcomingEvent,
		));
	}

	public function actionAbout()
	{
		$about = CmsPage::findBySlug('about_samaj');

		$this->pageTitle = $this->getSiteName() . ' - About Samaj';
		$this->render('about', array('about' => $about));
	}

	public function actionDistricts()
	{
		$districts = District::model()->active()->ordered()->findAll();

		$this->pageTitle = $this->getSiteName() . ' - Districts';
		$this->render('districts', array('districts' => $districts));
	}

	public function actionContact()
	{
		$contact = CmsPage::findBySlug('contact_info');

		$this->pageTitle = $this->getSiteName() . ' - Contact Us';
		$this->render('contact', array('contact' => $contact));
	}

	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
			} else {
				$this->render('error', $error);
			}
		}
	}
}
