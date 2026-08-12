<?php

/**
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property integer $display_order
 */
class District extends CActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'districts';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length', 'max' => 150),
			array('description', 'safe'),
			array('status', 'boolean'),
			array('display_order', 'numerical', 'integerOnly' => true),
		);
	}

	public function attributeLabels()
	{
		return array(
			'name' => 'District Name',
			'description' => 'Description',
			'status' => 'Status',
			'display_order' => 'Display Order',
		);
	}

	public function scopes()
	{
		return array(
			'active' => array(
				'condition' => 'status = ' . self::STATUS_ACTIVE,
			),
			'ordered' => array(
				'order' => 'display_order ASC, name ASC',
			),
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
