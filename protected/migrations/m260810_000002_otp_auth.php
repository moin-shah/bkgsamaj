<?php

/**
 * Evolves `users` for OTP-only (passwordless) admin login: password_hash is
 * no longer required, and reset_token/reset_token_expires_at are renamed to
 * their OTP equivalents with attempt/cooldown tracking added.
 */
class m260810_000002_otp_auth extends CDbMigration
{
	public function safeUp()
	{
		$this->alterColumn('users', 'password_hash', 'varchar(255) NULL');
		$this->renameColumn('users', 'reset_token', 'otp_hash');
		$this->alterColumn('users', 'otp_hash', 'varchar(64) NULL');
		$this->renameColumn('users', 'reset_token_expires_at', 'otp_expires_at');
		$this->addColumn('users', 'otp_attempts', 'tinyint(3) unsigned NOT NULL DEFAULT 0 AFTER otp_expires_at');
		$this->addColumn('users', 'otp_requested_at', 'datetime NULL AFTER otp_attempts');
	}

	public function safeDown()
	{
		$this->dropColumn('users', 'otp_requested_at');
		$this->dropColumn('users', 'otp_attempts');
		$this->renameColumn('users', 'otp_expires_at', 'reset_token_expires_at');
		$this->renameColumn('users', 'otp_hash', 'reset_token');
		$this->alterColumn('users', 'reset_token', 'varchar(64) NULL');
		$this->alterColumn('users', 'password_hash', 'varchar(255) NOT NULL');
	}
}
