<?php

/**
 * Replaces the ad hoc super_admin/admin/editor/district_admin roles with
 * the three access levels actually specified: Super Admin (everything,
 * including users/settings/districts), All-District Admin (all districts'
 * content, no system-level access), District Admin (one district only).
 */
class m260810_000013_role_model extends CDbMigration
{
	public function safeUp()
	{
		$this->getDbConnection()->createCommand(
			"UPDATE users SET role = 'all_district_admin' WHERE role IN ('admin', 'editor')"
		)->execute();

		$this->alterColumn('users', 'role', "enum('super_admin','all_district_admin','district_admin') NOT NULL DEFAULT 'district_admin'");
	}

	public function safeDown()
	{
		$this->getDbConnection()->createCommand(
			"UPDATE users SET role = 'admin' WHERE role = 'all_district_admin'"
		)->execute();

		$this->alterColumn('users', 'role', "enum('super_admin','admin','editor','district_admin') NOT NULL DEFAULT 'admin'");
	}
}
