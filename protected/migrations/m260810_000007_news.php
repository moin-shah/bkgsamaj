<?php

class m260810_000007_news extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('news', array(
			'id' => 'pk',
			'title' => 'varchar(200) NOT NULL',
			'slug' => 'varchar(150) NOT NULL',
			'excerpt' => 'varchar(500) NULL',
			'content' => 'longtext NULL',
			'published_at' => 'datetime NULL',
			'status' => 'tinyint(1) NOT NULL DEFAULT 1',
			'created_at' => 'datetime NOT NULL',
			'updated_at' => 'datetime NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

		$this->createIndex('uq_news_slug', 'news', 'slug', true);
		$this->createIndex('idx_news_status', 'news', 'status');
		$this->createIndex('idx_news_published', 'news', 'published_at');
	}

	public function safeDown()
	{
		$this->dropTable('news');
	}
}
