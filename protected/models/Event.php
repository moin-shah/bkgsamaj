<?php

/**
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property integer $district_id
 * @property string $venue
 * @property string $start_at
 * @property string $end_at
 * @property string $banner_url
 * @property integer $status
 */
class Event extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'events';
	}

	public function relations()
	{
		return array(
			'district' => array(self::BELONGS_TO, 'District', 'district_id'),
		);
	}

	public function rules()
	{
		return array(
			array('title, slug, start_at', 'required'),
			array('title', 'length', 'max' => 200),
			array('slug', 'length', 'max' => 150),
			array('slug', 'unique'),
			array('slug', 'match', 'pattern' => '/^[a-z0-9\-]+$/', 'message' => 'Slug may only contain lowercase letters, numbers and hyphens.'),
			array('description, venue, banner_url, district_id, end_at', 'safe'),
			array('status', 'boolean'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'title' => 'Title',
			'slug' => 'Slug',
			'district_id' => 'District',
			'venue' => 'Venue',
			'start_at' => 'Starts At',
			'end_at' => 'Ends At',
			'banner_url' => 'Banner Image URL',
			'status' => 'Status',
		);
	}

	public function scopes()
	{
		return array(
			'published' => array('condition' => 'status = 1'),
			'upcoming' => array('condition' => 'status = 1 AND start_at >= NOW()', 'order' => 'start_at ASC'),
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
