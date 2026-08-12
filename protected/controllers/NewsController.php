<?php

/**
 * Public News listing and article detail pages.
 */
class NewsController extends PublicController
{
	public function actionIndex()
	{
		$this->pageTitle = $this->getSiteName() . ' - News';
		$this->render('index', array(
			'newsItems' => News::model()->published()->findAll(),
		));
	}

	public function actionView($slug)
	{
		$news = News::findBySlug($slug);
		if ($news === null) {
			throw new CHttpException(404, 'News not found.');
		}

		$this->pageTitle = $this->getSiteName() . ' - ' . $news->title;
		$this->render('view', array('news' => $news));
	}
}
