<?php

/**
 * Public Gallery listing and album detail pages.
 */
class GalleryController extends PublicController
{
	public function actionIndex()
	{
		$this->pageTitle = $this->getSiteName() . ' - Gallery';
		$this->render('index', array(
			'albums' => GalleryAlbum::model()->active()->ordered()->findAll(),
		));
	}

	public function actionView($id)
	{
		$album = GalleryAlbum::model()->findByPk((int) $id);
		if ($album === null || !$album->status) {
			throw new CHttpException(404, 'Album not found.');
		}

		$this->pageTitle = $this->getSiteName() . ' - ' . $album->title;
		$this->render('view', array('album' => $album));
	}
}
