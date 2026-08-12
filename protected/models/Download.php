<?php

/**
 * @property integer $id
 * @property string $title
 * @property string $category
 * @property string $file_url
 * @property integer $district_id
 * @property integer $display_order
 * @property integer $status
 */
class Download extends CActiveRecord
{
	const CATEGORY_RULES = 'rules_regulations';
	const CATEGORY_FORMS = 'forms';
	const CATEGORY_CIRCULARS = 'circulars';
	const CATEGORY_OTHER = 'other';

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'downloads';
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
			array('title, file_url', 'required'),
			array('title', 'length', 'max' => 200),
			array('category', 'in', 'range' => array(self::CATEGORY_RULES, self::CATEGORY_FORMS, self::CATEGORY_CIRCULARS, self::CATEGORY_OTHER)),
			array('district_id, display_order', 'safe'),
			array('status', 'boolean'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'title' => 'Title',
			'category' => 'Category',
			'file_url' => 'File URL',
			'district_id' => 'District',
			'display_order' => 'Display Order',
			'status' => 'Status',
		);
	}

	public static function categoryLabels()
	{
		return array(
			self::CATEGORY_RULES => 'Rules & Regulations',
			self::CATEGORY_FORMS => 'Forms',
			self::CATEGORY_CIRCULARS => 'Circulars',
			self::CATEGORY_OTHER => 'Other',
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
