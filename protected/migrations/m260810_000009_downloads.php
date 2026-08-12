<?php

class m260810_000009_downloads extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('downloads', array(
			'id' => 'pk',
			'title' => 'varchar(200) NOT NULL',
			'category' => "enum('rules_regulations','forms','circulars','other') NOT NULL DEFAULT 'other'",
			'file_url' => 'varchar(255) NOT NULL',
			'district_id' => 'int unsigned NULL',
			'display_order' => 'int NOT NULL DEFAULT 0',
			'status' => 'tinyint(1) NOT NULL DEFAULT 1',
			'created_at' => 'datetime NOT NULL',
			'updated_at' => 'datetime NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

		$this->createIndex('idx_downloads_category', 'downloads', 'category');
		$this->createIndex('idx_downloads_district', 'downloads', 'district_id');
		$this->createIndex('idx_downloads_status', 'downloads', 'status');
	}

	public function safeDown()
	{
		$this->dropTable('downloads');
	}
}
