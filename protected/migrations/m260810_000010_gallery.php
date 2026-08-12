<?php

class m260810_000010_gallery extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('gallery_albums', array(
			'id' => 'pk',
			'title' => 'varchar(200) NOT NULL',
			'district_id' => 'int unsigned NULL',
			'cover_image_url' => 'varchar(255) NULL',
			'display_order' => 'int NOT NULL DEFAULT 0',
			'status' => 'tinyint(1) NOT NULL DEFAULT 1',
			'created_at' => 'datetime NOT NULL',
			'updated_at' => 'datetime NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
		$this->createIndex('idx_gallery_albums_district', 'gallery_albums', 'district_id');
		$this->createIndex('idx_gallery_albums_status', 'gallery_albums', 'status');

		$this->createTable('gallery_images', array(
			'id' => 'pk',
			'album_id' => 'int unsigned NOT NULL',
			'image_url' => 'varchar(255) NOT NULL',
			'caption' => 'varchar(255) NULL',
			'display_order' => 'int NOT NULL DEFAULT 0',
			'created_at' => 'datetime NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
		$this->createIndex('idx_gallery_images_album', 'gallery_images', 'album_id');
	}

	public function safeDown()
	{
		$this->dropTable('gallery_images');
		$this->dropTable('gallery_albums');
	}
}
