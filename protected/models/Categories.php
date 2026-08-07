<?php

class Categories extends CActiveRecord
{
	public function tableName()
	{
		return 'categories';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('id, name', 'safe', 'on'=>'search'),
		);
	}
	public function relations()
	{
		return array(
			'related-category'=>array(self::HAS_MANY, 'RelatedCategoriesFeatures', 'categories_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
		);
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
