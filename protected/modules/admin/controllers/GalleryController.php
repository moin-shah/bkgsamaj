<?php

class GalleryController extends AdminController
{
	public function actionIndex()
	{
		$this->pageTitle = 'Gallery';
		$criteria = new CDbCriteria();
		$this->applyDistrictScope($criteria);
		$criteria->order = 'display_order ASC, title ASC';

		$this->render('index', array(
			'albums' => GalleryAlbum::model()->findAll($criteria),
		));
	}

	public function actionCreate()
	{
		$model = new GalleryAlbum();
		$this->pageTitle = 'Add Album';

		if (isset($_POST['GalleryAlbum'])) {
			$model->attributes = $_POST['GalleryAlbum'];
			$this->enforceDistrictOnSave($model);
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Album added successfully.');
				$this->redirect(array('/admin/gallery'));
			}
		}

		$this->render('form', array('model' => $model, 'districtOptions' => $this->districtOptions()));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$this->pageTitle = 'Edit Album';

		if (isset($_POST['GalleryAlbum'])) {
			$model->attributes = $_POST['GalleryAlbum'];
			$this->enforceDistrictOnSave($model);
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Album updated successfully.');
				$this->redirect(array('/admin/gallery'));
			}
		}

		$this->render('form', array('model' => $model, 'districtOptions' => $this->districtOptions()));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$model = $this->loadModel($id);
			GalleryImage::model()->deleteAll('album_id = :id', array(':id' => $model->id));
			$model->delete();
			Yii::app()->user->setFlash('success', 'Album deleted.');
		}

		$this->redirect(array('/admin/gallery'));
	}

	public function actionToggleStatus($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$model = $this->loadModel($id);
			$model->status = $model->status ? 0 : 1;
			$model->save(false, array('status'));
		}

		$this->redirect(array('/admin/gallery'));
	}

	/**
	 * Shows an album's images plus a small form to add a new one - the
	 * album itself is loaded through loadModel() so the district scope
	 * still applies to direct-URL access.
	 */
	public function actionImages($id)
	{
		$album = $this->loadModel($id);
		$this->pageTitle = 'Album Images - ' . $album->title;

		$image = new GalleryImage();
		if (isset($_POST['GalleryImage'])) {
			$image->attributes = $_POST['GalleryImage'];
			$image->album_id = $album->id;
			if ($image->save()) {
				Yii::app()->user->setFlash('success', 'Image added successfully.');
				$this->redirect(array('/admin/gallery/images', 'id' => $album->id));
			}
		}

		$this->render('images', array('album' => $album, 'image' => $image));
	}

	public function actionRemoveImage($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$image = GalleryImage::model()->findByPk((int) $id);
			if ($image !== null) {
				$albumId = $image->album_id;
				$this->loadModel($albumId);
				$image->delete();
				Yii::app()->user->setFlash('success', 'Image removed.');
				$this->redirect(array('/admin/gallery/images', 'id' => $albumId));
			}
		}

		$this->redirect(array('/admin/gallery'));
	}

	/**
	 * Loads a row and enforces the district scope even on direct-URL
	 * access - a district_admin can't open another district's album by
	 * guessing its id.
	 */
	private function loadModel($id)
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('id = :id');
		$criteria->params[':id'] = (int) $id;
		$this->applyDistrictScope($criteria);

		$model = GalleryAlbum::model()->find($criteria);
		if ($model === null) {
			throw new CHttpException(404, 'Album not found.');
		}

		return $model;
	}
}
