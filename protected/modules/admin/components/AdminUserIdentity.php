<?php

/**
 * Identity for an admin already verified via OTP (protected/models/User.php).
 * Credential checking happens in User::verifyOtp() before this is
 * constructed - this class only carries the verified user into the session.
 */
class AdminUserIdentity extends CUserIdentity
{
	private $_user;

	public function __construct(User $user)
	{
		$this->_user = $user;
		parent::__construct($user->email, null);
	}

	public function authenticate()
	{
		$this->setState('user_id', $this->_user->id);
		$this->setState('name', $this->_user->name);
		$this->setState('email', $this->_user->email);
		$this->setState('role', $this->_user->role);
		$this->errorCode = self::ERROR_NONE;

		return true;
	}

	public function getId()
	{
		return $this->_user->id;
	}
}
