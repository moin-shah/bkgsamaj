<?php

/**
 * @property integer $id
 * @property string $title
 * @property integer $district_id
 * @property string $cover_image_url
 * @property integer $display_order
 * @property integer $status
 */
class GalleryAlbum extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'gallery_albums';
	}

	public function relations()
	{
		return array(
			'district' => array(self::BELONGS_TO, 'District', 'district_id'),
			'images' => array(self::HAS_MANY, 'GalleryImage', 'album_id', 'order' => 'images.display_order ASC'),
		);
	}

	public function rules()
	{
		return array(
			array('title', 'required'),
			array('title', 'length', 'max' => 200),
			array('district_id, cover_image_url, display_order', 'safe'),
			array('status', 'boolean'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'title' => 'Album Title',
			'district_id' => 'District',
			'cover_image_url' => 'Cover Image URL',
			'display_order' => 'Display Order',
			'status' => 'Status',
		);
	}

	public function scopes()
	{
		return array(
			'active' => array('condition' => 'status = 1'),
			'ordered' => array('order' => 'display_order ASC, title ASC'),
		);
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
