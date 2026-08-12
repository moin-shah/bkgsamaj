<?php

/**
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $excerpt
 * @property string $content
 * @property string $published_at
 * @property integer $status
 */
class News extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'news';
	}

	public function rules()
	{
		return array(
			array('title, slug', 'required'),
			array('title', 'length', 'max' => 200),
			array('slug', 'length', 'max' => 150),
			array('slug', 'unique'),
			array('slug', 'match', 'pattern' => '/^[a-z0-9\-]+$/', 'message' => 'Slug may only contain lowercase letters, numbers and hyphens.'),
			array('excerpt, content, published_at', 'safe'),
			array('status', 'boolean'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'title' => 'Title',
			'slug' => 'Slug',
			'excerpt' => 'Excerpt',
			'content' => 'Content',
			'published_at' => 'Published At',
			'status' => 'Status',
		);
	}

	public function scopes()
	{
		return array(
			'published' => array(
				'condition' => 'status = 1 AND published_at IS NOT NULL AND published_at <= NOW()',
				'order' => 'published_at DESC',
			),
		);
	}

	public static function findBySlug($slug)
	{
		return self::model()->findByAttributes(array('slug' => $slug));
	}

	protected function beforeSave()
	{
		if ($this->isNewRecord) {
			$this->created_at = date('Y-m-d H:i:s');
		}
		$this->updated_at = date('Y-m-d H:i:s');

		return parent::beforeSave();
	}
}
