<?php

class CmsController extends AdminController
{
	/** Slugs manageable in Phase 1, per the CMS scope (Home Banner, About Samaj, Contact Information). */
	private static $allowedSlugs = array('home_banner', 'about_samaj', 'contact_info');

	public function beforeAction($action)
	{
		if (!parent::beforeAction($action)) {
			return false;
		}

		$this->requireSystemAccess();

		return true;
	}

	public function actionIndex()
	{
		$this->pageTitle = 'CMS';
		$this->render('index', array(
			'pages' => CmsPage::model()->findAllByAttributes(array(), array('order' => 'id ASC')),
		));
	}

	public function actionEdit($slug)
	{
		if (!in_array($slug, self::$allowedSlugs, true)) {
			throw new CHttpException(404, 'Page not found.');
		}

		$model = CmsPage::findBySlug($slug);
		if ($model === null) {
			throw new CHttpException(404, 'Page not found.');
		}

		$this->pageTitle = 'Edit: ' . $model->title;

		if (isset($_POST['CmsPage'])) {
			$model->attributes = $_POST['CmsPage'];
			$meta = isset($_POST['meta']) && is_array($_POST['meta']) ? $_POST['meta'] : array();
			$model->setMeta($meta);
			$model->updated_by = Yii::app()->user->id;

			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Page updated successfully.');
				$this->redirect(array('/admin/cms'));
			}
		}

		$this->registerTinyMce('#CmsPage_content');
		$this->render('edit', array('model' => $model, 'meta' => $model->getMeta()));
	}

	public function actionSettings()
	{
		$this->pageTitle = 'General Settings';

		if (isset($_POST['Setting'])) {
			foreach ($_POST['Setting'] as $key => $value) {
				Setting::set($key, $value);
			}
			Yii::app()->user->setFlash('success', 'Settings updated successfully.');
			$this->redirect(array('/admin/cms/settings'));
		}

		$this->render('settings', array(
			'siteName' => Setting::get('site_name', ''),
			'siteTagline' => Setting::get('site_tagline', ''),
			'footerText' => Setting::get('footer_text', ''),
			'highlights' => Setting::getJson('community_highlights', array()),
		));
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
}
