<?php

/**
 * Simplifies OTP storage from a hash to the plain 6-digit code, per request -
 * this is an internal admin tool with a short-lived, low-entropy code, so the
 * extra hashing step was unnecessary complexity.
 */
class m260810_000003_simplify_otp extends CDbMigration
{
	public function safeUp()
	{
		$this->renameColumn('users', 'otp_hash', 'otp_code');
		$this->alterColumn('users', 'otp_code', 'varchar(6) NULL');
	}

	public function safeDown()
	{
		$this->alterColumn('users', 'otp_code', 'varchar(64) NULL');
		$this->renameColumn('users', 'otp_code', 'otp_hash');
	}
}
