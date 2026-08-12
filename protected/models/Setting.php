<?php

/**
 * @property integer $id
 * @property string $setting_key
 * @property string $setting_value
 * @property string $setting_group
 */
class Setting extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'settings';
	}

	public function rules()
	{
		return array(
			array('setting_key', 'required'),
			array('setting_key', 'length', 'max' => 100),
			array('setting_value', 'safe'),
			array('setting_group', 'length', 'max' => 50),
		);
	}

	public function attributeLabels()
	{
		return array(
			'setting_key' => 'Key',
			'setting_value' => 'Value',
			'setting_group' => 'Group',
		);
	}

	public static function get($key, $default = null)
	{
		$record = self::model()->findByAttributes(array('setting_key' => $key));

		return $record !== null ? $record->setting_value : $default;
	}

	public static function getJson($key, $default = array())
	{
		$value = self::get($key, null);
		if ($value === null) {
			return $default;
		}

		$decoded = json_decode($value, true);

		return is_array($decoded) ? $decoded : $default;
	}

	public static function set($key, $value, $group = 'general')
	{
		$record = self::model()->findByAttributes(array('setting_key' => $key));
		if ($record === null) {
			$record = new self();
			$record->setting_key = $key;
			$record->setting_group = $group;
		}
		$record->setting_value = $value;
		$record->updated_at = date('Y-m-d H:i:s');
		$record->save(false);

		return $record;
	}

	protected function beforeSave()
	{
		$this->updated_at = date('Y-m-d H:i:s');

		return parent::beforeSave();
	}
}
