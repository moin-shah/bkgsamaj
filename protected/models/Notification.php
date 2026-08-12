<?php

/**
 * @property integer $id
 * @property string $title
 * @property string $message
 * @property string $audience
 * @property string $audience_value
 * @property string $link_url
 * @property integer $status
 */
class Notification extends CActiveRecord
{
	const AUDIENCE_ALL = 'all';
	const AUDIENCE_DISTRICT = 'district';
	const AUDIENCE_ROLE = 'role';

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'notifications';
	}

	public function rules()
	{
		return array(
			array('title, message', 'required'),
			array('title', 'length', 'max' => 200),
			array('audience', 'in', 'range' => array(self::AUDIENCE_ALL, self::AUDIENCE_DISTRICT, self::AUDIENCE_ROLE)),
			array('audience_value, link_url', 'safe'),
			array('status', 'boolean'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'title' => 'Title',
			'message' => 'Message',
			'audience' => 'Audience',
			'audience_value' => 'Audience Value',
			'link_url' => 'Link URL',
			'status' => 'Status',
		);
	}

	public function scopes()
	{
		return array(
			'active' => array('condition' => 'status = 1', 'order' => 'created_at DESC'),
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
