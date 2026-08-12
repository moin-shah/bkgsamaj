<?php

class m260810_000008_raja_chithi extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('raja_chithi', array(
			'id' => 'pk',
			'title' => 'varchar(200) NOT NULL',
			'description' => 'text NULL',
			'district_id' => 'int unsigned NULL',
			'attachment_url' => 'varchar(255) NULL',
			'issued_date' => 'date NOT NULL',
			'status' => 'tinyint(1) NOT NULL DEFAULT 1',
			'created_at' => 'datetime NOT NULL',
			'updated_at' => 'datetime NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

		$this->createIndex('idx_raja_chithi_district', 'raja_chithi', 'district_id');
		$this->createIndex('idx_raja_chithi_status', 'raja_chithi', 'status');
	}

	public function safeDown()
	{
		$this->dropTable('raja_chithi');
	}
}
