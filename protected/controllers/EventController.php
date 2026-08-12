<?php

/**
 * Public Events listing and event detail pages.
 */
class EventController extends PublicController
{
	public function actionIndex()
	{
		$this->pageTitle = $this->getSiteName() . ' - Events';
		$this->render('index', array(
			'upcomingEvents' => Event::model()->upcoming()->findAll(),
			'pastEvents' => Event::model()->published()->findAll(array(
				'condition' => 'start_at < NOW()',
				'order' => 'start_at DESC',
				'limit' => 10,
			)),
		));
	}

	public function actionView($slug)
	{
		$event = Event::findBySlug($slug);
		if ($event === null) {
			throw new CHttpException(404, 'Event not found.');
		}

		$this->pageTitle = $this->getSiteName() . ' - ' . $event->title;
		$this->render('view', array('event' => $event));
	}
}
