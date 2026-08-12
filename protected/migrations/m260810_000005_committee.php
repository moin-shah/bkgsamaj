<?php

class m260810_000005_committee extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('committee_positions', array(
			'id' => 'pk',
			'title' => 'varchar(150) NOT NULL',
			'district_id' => 'int unsigned NULL',
			'display_order' => 'int NOT NULL DEFAULT 0',
			'status' => 'tinyint(1) NOT NULL DEFAULT 1',
			'created_at' => 'datetime NOT NULL',
			'updated_at' => 'datetime NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
		$this->createIndex('idx_committee_positions_district', 'committee_positions', 'district_id');
		$this->createIndex('idx_committee_positions_status', 'committee_positions', 'status');

		$this->createTable('committee_members', array(
			'id' => 'pk',
			'position_id' => 'int unsigned NOT NULL',
			'member_id' => 'int unsigned NOT NULL',
			'term_start' => 'date NULL',
			'term_end' => 'date NULL',
			'status' => 'tinyint(1) NOT NULL DEFAULT 1',
			'created_at' => 'datetime NOT NULL',
			'updated_at' => 'datetime NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
		$this->createIndex('idx_committee_members_position', 'committee_members', 'position_id');
		$this->createIndex('idx_committee_members_member', 'committee_members', 'member_id');
	}

	public function safeDown()
	{
		$this->dropTable('committee_members');
		$this->dropTable('committee_positions');
	}
}
