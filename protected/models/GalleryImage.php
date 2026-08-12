<?php

/**
 * @property integer $id
 * @property integer $album_id
 * @property string $image_url
 * @property string $caption
 * @property integer $display_order
 */
class GalleryImage extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'gallery_images';
	}

	public function relations()
	{
		return array(
			'album' => array(self::BELONGS_TO, 'GalleryAlbum', 'album_id'),
		);
	}

	public function rules()
	{
		return array(
			array('album_id, image_url', 'required'),
			array('caption, display_order', 'safe'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'image_url' => 'Image URL',
			'caption' => 'Caption',
			'display_order' => 'Display Order',
		);
	}

	protected function beforeSave()
	{
		if ($this->isNewRecord) {
			$this->created_at = date('Y-m-d H:i:s');
		}

		return parent::beforeSave();
	}
}
