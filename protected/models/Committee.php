<?php

/**
 * A single committee entry: one position, held by one person, in one
 * district. Deliberately holds its own name/contact fields rather than
 * referencing the Member registry - Committee and Member are separate
 * entities with no relationship. At most one row per (position, district)
 * pair - enforced both in the DB (uq_committee_position_district) and here.
 *
 * @property integer $id
 * @property integer $district_id
 * @property string $position
 * @property string $full_name
 * @property string $phone
 * @property string $email
 * @property string $term_start
 * @property string $term_end
 * @property integer $status
 */
class Committee extends CActiveRecord
{
	const POSITION_PRESIDENT = 'President';
	const POSITION_VICE_PRESIDENT = 'Vice President';
	const POSITION_SECRETARY = 'Secretary';
	const POSITION_KEYHOLDER = 'Keyholder';
	const POSITION_TREASURER = 'Treasurer';
	const POSITION_OTHER = 'Other';

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'committee';
	}

	public function relations()
	{
		return array(
			'district' => array(self::BELONGS_TO, 'District', 'district_id'),
		);
	}

	public static function positionOptions()
	{
		return array(
			self::POSITION_PRESIDENT => self::POSITION_PRESIDENT,
			self::POSITION_VICE_PRESIDENT => self::POSITION_VICE_PRESIDENT,
			self::POSITION_SECRETARY => self::POSITION_SECRETARY,
			self::POSITION_KEYHOLDER => self::POSITION_KEYHOLDER,
			self::POSITION_TREASURER => self::POSITION_TREASURER,
			self::POSITION_OTHER => self::POSITION_OTHER,
		);
	}

	public function rules()
	{
		return array(
			array('district_id, position, full_name', 'required'),
			array('position', 'in', 'range' => array_keys(self::positionOptions())),
			array('full_name', 'length', 'max' => 150),
			array('phone', 'length', 'max' => 20),
			array('email', 'email', 'allowEmpty' => true),
			array('email', 'length', 'max' => 150),
			array('term_start, term_end', 'safe'),
			array('status', 'boolean'),
			array('position', 'validatePositionDistrictUnique'),
		);
	}

	/**
	 * Enforces one row per (position, district) - e.g. only one President
	 * per district - with a friendly form error rather than a raw SQL one.
	 */
	public function validatePositionDistrictUnique($attribute, $params)
	{
		if (empty($this->position) || empty($this->district_id)) {
			return;
		}

		$criteria = new CDbCriteria();
		$criteria->addCondition('position = :position AND district_id = :districtId');
		$criteria->params[':position'] = $this->position;
		$criteria->params[':districtId'] = $this->district_id;
		if (!$this->isNewRecord) {
			$criteria->addCondition('id != :id');
			$criteria->params[':id'] = $this->id;
		}

		if (Committee::model()->exists($criteria)) {
			$this->addError('position', $this->position . ' is already assigned for this district.');
		}
	}

	public function attributeLabels()
	{
		return array(
			'district_id' => 'District',
			'position' => 'Position',
			'full_name' => 'Name',
			'phone' => 'Phone',
			'email' => 'Email',
			'term_start' => 'Term Start',
			'term_end' => 'Term End',
			'status' => 'Status',
		);
	}

	public function scopes()
	{
		return array(
			'active' => array('condition' => 'status = 1'),
			'ordered' => array('order' => 'district_id ASC, position ASC'),
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
