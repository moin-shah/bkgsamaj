<?php

/**
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $date_of_birth
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property integer $district_id
 * @property string $photo_url
 * @property string $registration_source
 * @property string $status
 */
class Member extends CActiveRecord
{
	const SOURCE_ADMIN = 'admin_added';
	const SOURCE_SELF = 'self_registered';

	const STATUS_PENDING = 'pending';
	const STATUS_ACTIVE = 'active';
	const STATUS_INACTIVE = 'inactive';

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'members';
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
			array('first_name, last_name', 'required'),
			array('first_name, last_name', 'length', 'max' => 100),
			array('gender', 'in', 'range' => array('male', 'female', 'other'), 'allowEmpty' => true),
			array('phone', 'length', 'max' => 20),
			array('email', 'email', 'allowEmpty' => true),
			array('email', 'length', 'max' => 150),
			array('address, date_of_birth, photo_url, district_id', 'safe'),
			array('registration_source', 'in', 'range' => array(self::SOURCE_ADMIN, self::SOURCE_SELF)),
			array('status', 'in', 'range' => array(self::STATUS_PENDING, self::STATUS_ACTIVE, self::STATUS_INACTIVE)),
		);
	}

	public function attributeLabels()
	{
		return array(
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'date_of_birth' => 'Date of Birth',
			'district_id' => 'District',
			'photo_url' => 'Photo URL',
			'registration_source' => 'Source',
			'status' => 'Status',
		);
	}

	public function scopes()
	{
		return array(
			'active' => array('condition' => "status = '" . self::STATUS_ACTIVE . "'"),
			'ordered' => array('order' => 'first_name ASC, last_name ASC'),
		);
	}

	public function getFullName()
	{
		return trim($this->first_name . ' ' . $this->last_name);
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
