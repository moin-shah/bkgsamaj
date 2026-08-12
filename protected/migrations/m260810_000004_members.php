<?php

class m260810_000004_members extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('members', array(
			'id' => 'pk',
			'first_name' => 'varchar(100) NOT NULL',
			'last_name' => 'varchar(100) NOT NULL',
			'gender' => "enum('male','female','other') NULL",
			'date_of_birth' => 'date NULL',
			'phone' => 'varchar(20) NULL',
			'email' => 'varchar(150) NULL',
			'address' => 'text NULL',
			'district_id' => 'int unsigned NULL',
			'photo_url' => 'varchar(255) NULL',
			'registration_source' => "enum('admin_added','self_registered') NOT NULL DEFAULT 'admin_added'",
			'status' => "enum('pending','active','inactive') NOT NULL DEFAULT 'active'",
			'created_at' => 'datetime NOT NULL',
			'updated_at' => 'datetime NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

		$this->createIndex('idx_members_district', 'members', 'district_id');
		$this->createIndex('idx_members_status', 'members', 'status');
	}

	public function safeDown()
	{
		$this->dropTable('members');
	}
}
