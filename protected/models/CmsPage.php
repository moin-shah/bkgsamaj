<?php

/**
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $content
 * @property string $meta_json
 * @property integer $status
 * @property integer $updated_by
 */
class CmsPage extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'cms_pages';
	}

	public function rules()
	{
		return array(
			array('slug, title', 'required'),
			array('slug', 'length', 'max' => 100),
			array('title', 'length', 'max' => 255),
			array('content, meta_json', 'safe'),
			array('status', 'boolean'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'slug' => 'Slug',
			'title' => 'Title',
			'content' => 'Content',
			'meta_json' => 'Meta',
			'status' => 'Status',
		);
	}

	public static function findBySlug($slug)
	{
		return self::model()->findByAttributes(array('slug' => $slug));
	}

	/**
	 * Decodes meta_json to an associative array, defaulting missing keys.
	 */
	public function getMeta()
	{
		$decoded = json_decode((string) $this->meta_json, true);

		return is_array($decoded) ? $decoded : array();
	}

	public function setMeta(array $meta)
	{
		$this->meta_json = json_encode($meta);
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
