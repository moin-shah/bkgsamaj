<?php

/**
 * Phase 3: district-wise management. No new content tables - every Phase 2
 * table already carries a nullable district_id. This migration only adds
 * the admin side of the scope: which district (if any) a user is confined
 * to, and the district_admin role that triggers the confinement.
 */
class m260810_000012_district_scoping extends CDbMigration
{
	public function safeUp()
	{
		$this->alterColumn('users', 'role', "enum('super_admin','admin','editor','district_admin') NOT NULL DEFAULT 'admin'");
		$this->addColumn('users', 'district_id', 'int unsigned NULL AFTER role');
		$this->createIndex('idx_users_district', 'users', 'district_id');
	}

	public function safeDown()
	{
		$this->dropIndex('idx_users_district', 'users');
		$this->dropColumn('users', 'district_id');
		$this->alterColumn('users', 'role', "enum('super_admin','admin','editor') NOT NULL DEFAULT 'admin'");
	}
}
