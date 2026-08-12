<?php

class m260810_000006_events extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('events', array(
			'id' => 'pk',
			'title' => 'varchar(200) NOT NULL',
			'slug' => 'varchar(150) NOT NULL',
			'description' => 'text NULL',
			'district_id' => 'int unsigned NULL',
			'venue' => 'varchar(255) NULL',
			'start_at' => 'datetime NOT NULL',
			'end_at' => 'datetime NULL',
			'banner_url' => 'varchar(255) NULL',
			'status' => 'tinyint(1) NOT NULL DEFAULT 1',
			'created_at' => 'datetime NOT NULL',
			'updated_at' => 'datetime NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

		$this->createIndex('uq_events_slug', 'events', 'slug', true);
		$this->createIndex('idx_events_district', 'events', 'district_id');
		$this->createIndex('idx_events_status', 'events', 'status');
		$this->createIndex('idx_events_start', 'events', 'start_at');
	}

	public function safeDown()
	{
		$this->dropTable('events');
	}
}
