<?php

class m260810_000011_notifications extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('notifications', array(
			'id' => 'pk',
			'title' => 'varchar(200) NOT NULL',
			'message' => 'text NOT NULL',
			'audience' => "enum('all','district','role') NOT NULL DEFAULT 'all'",
			'audience_value' => 'varchar(100) NULL',
			'link_url' => 'varchar(255) NULL',
			'status' => 'tinyint(1) NOT NULL DEFAULT 1',
			'created_at' => 'datetime NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

		$this->createIndex('idx_notifications_status', 'notifications', 'status');
	}

	public function safeDown()
	{
		$this->dropTable('notifications');
	}
}
