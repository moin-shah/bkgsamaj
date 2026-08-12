<?php

class NewsController extends AdminController
{
	public function actionIndex()
	{
		$this->pageTitle = 'News';
		$this->render('index', array(
			'newsItems' => News::model()->findAll(array('order' => 'id DESC')),
		));
	}

	public function actionCreate()
	{
		$model = new News();
		$this->pageTitle = 'Add News';

		if (isset($_POST['News'])) {
			$model->attributes = $_POST['News'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'News added successfully.');
				$this->redirect(array('/admin/news'));
			}
		}

		$this->registerTinyMce('#News_content');
		$this->render('form', array('model' => $model));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$this->pageTitle = 'Edit News';

		if (isset($_POST['News'])) {
			$model->attributes = $_POST['News'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'News updated successfully.');
				$this->redirect(array('/admin/news'));
			}
		}

		$this->registerTinyMce('#News_content');
		$this->render('form', array('model' => $model));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$this->loadModel($id)->delete();
			Yii::app()->user->setFlash('success', 'News deleted.');
		}

		$this->redirect(array('/admin/news'));
	}

	public function actionToggleStatus($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$model = $this->loadModel($id);
			$model->status = $model->status ? 0 : 1;
			$model->save(false, array('status'));
		}

		$this->redirect(array('/admin/news'));
	}

	protected function registerTinyMce($selector)
	{
		$assetUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('ext.tinymce.js.assets'));
		Yii::app()->clientScript->registerScriptFile($assetUrl . '/tinymce.min.js');
		Yii::app()->clientScript->registerScript('tinymce-init-' . $selector, "
			tinymce.init({ selector: '" . $selector . "', height: 320, menubar: false,
				plugins: 'lists link', toolbar: 'undo redo | bold italic | bullist numlist | link' });
		", CClientScript::POS_END);
	}

	private function loadModel($id)
	{
		$model = News::model()->findByPk((int) $id);
		if ($model === null) {
			throw new CHttpException(404, 'News not found.');
		}

		return $model;
	}
}
