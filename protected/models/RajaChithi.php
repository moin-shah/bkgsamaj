<?php

/**
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $district_id
 * @property string $attachment_url
 * @property string $issued_date
 * @property integer $status
 */
class RajaChithi extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'raja_chithi';
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
			array('title, issued_date', 'required'),
			array('title', 'length', 'max' => 200),
			array('description, attachment_url, district_id', 'safe'),
			array('status', 'boolean'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'title' => 'Title',
			'description' => 'Description',
			'district_id' => 'District',
			'attachment_url' => 'Attachment URL',
			'issued_date' => 'Issued Date',
			'status' => 'Status',
		);
	}

	public function scopes()
	{
		return array(
			'published' => array('condition' => 'status = 1', 'order' => 'issued_date DESC'),
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
