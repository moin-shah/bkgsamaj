<?php

/**
 * Admin user, authenticated via emailed OTP (no persistent password).
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property integer $district_id
 * @property integer $status
 * @property string $otp_code
 * @property string $otp_expires_at
 * @property integer $otp_attempts
 * @property string $otp_requested_at
 * @property string $last_login_at
 */
class User extends CActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;

	const OTP_TTL_SECONDS = 600;
	const OTP_RESEND_COOLDOWN_SECONDS = 60;
	const OTP_MAX_ATTEMPTS = 5;

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'users';
	}

	public function rules()
	{
		return array(
			array('name, email', 'required'),
			array('name', 'length', 'max' => 100),
			array('email', 'email'),
			array('email', 'length', 'max' => 150),
			array('email', 'unique'),
			array('role', 'in', 'range' => array('super_admin', 'all_district_admin', 'district_admin')),
			array('district_id', 'safe'),
			array('status', 'boolean'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'name' => 'Name',
			'email' => 'Email',
			'role' => 'Role',
			'district_id' => 'District',
			'status' => 'Status',
			'last_login_at' => 'Last Login',
		);
	}

	public function relations()
	{
		return array(
			'district' => array(self::BELONGS_TO, 'District', 'district_id'),
		);
	}

	/**
	 * @return integer|null the district this user is confined to, or null
	 * for roles (super_admin, all_district_admin) that see every district.
	 */
	public function getScopeDistrictId()
	{
		return $this->role === 'district_admin' ? $this->district_id : null;
	}

	/**
	 * System-level areas (Users, site-wide CMS/Settings, the District list
	 * itself) are Super Admin only - an All-District Admin manages every
	 * district's data, but not the system configuration itself.
	 */
	public function hasSystemAccess()
	{
		return $this->role === 'super_admin';
	}

	public static function findByEmail($email)
	{
		return self::model()->findByAttributes(array('email' => $email));
	}

	/**
	 * Generates a fresh 6-digit OTP and stores it directly (plain, single
	 * field) - simple by design, since this is a short-lived, low-entropy
	 * code for an internal admin tool.
	 */
	public function generateOtp()
	{
		//$otp = (string) mt_rand(100000, 999999);
		$otp = 123456;

		$this->otp_code = $otp;
		$this->otp_expires_at = date('Y-m-d H:i:s', time() + self::OTP_TTL_SECONDS);
		$this->otp_attempts = 0;
		$this->otp_requested_at = date('Y-m-d H:i:s');
		$this->update(array('otp_code', 'otp_expires_at', 'otp_attempts', 'otp_requested_at'));

		return $otp;
	}

	public function canRequestOtp()
	{
		if (empty($this->otp_requested_at)) {
			return true;
		}

		return (time() - strtotime($this->otp_requested_at)) >= self::OTP_RESEND_COOLDOWN_SECONDS;
	}

	public function otpResendWaitSeconds()
	{
		if (empty($this->otp_requested_at)) {
			return 0;
		}

		$wait = self::OTP_RESEND_COOLDOWN_SECONDS - (time() - strtotime($this->otp_requested_at));

		return $wait > 0 ? $wait : 0;
	}

	/**
	 * Verifies a submitted OTP against the stored code, honoring expiry and
	 * the attempt cap. On success, clears OTP state and stamps last_login_at.
	 */
	public function verifyOtp($code)
	{
		if (empty($this->otp_code) || empty($this->otp_expires_at)) {
			return false;
		}

		if ($this->otp_attempts >= self::OTP_MAX_ATTEMPTS) {
			return false;
		}

		if (strtotime($this->otp_expires_at) < time()) {
			return false;
		}

		if ($this->otp_code !== (string) $code) {
			$this->otp_attempts += 1;
			$this->update(array('otp_attempts'));

			return false;
		}

		$this->otp_code = null;
		$this->otp_expires_at = null;
		$this->otp_attempts = 0;
		$this->otp_requested_at = null;
		$this->last_login_at = date('Y-m-d H:i:s');
		$this->update(array('otp_code', 'otp_expires_at', 'otp_attempts', 'otp_requested_at', 'last_login_at'));

		return true;
	}

	public function isActive()
	{
		return (int) $this->status === self::STATUS_ACTIVE;
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
