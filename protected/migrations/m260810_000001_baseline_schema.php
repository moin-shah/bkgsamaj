<?php

/**
 * Codifies the Phase 1 schema (users, districts, cms_pages, settings) that
 * already exists live in the bkgs_portal database. Uses CREATE TABLE IF NOT
 * EXISTS so it is a safe no-op against a database that already has these
 * tables, and reproducible from scratch on a fresh database.
 */
class m260810_000001_baseline_schema extends CDbMigration
{
	public function safeUp()
	{
		$this->getDbConnection()->createCommand("
			CREATE TABLE IF NOT EXISTS `users` (
				`id` int unsigned NOT NULL AUTO_INCREMENT,
				`name` varchar(100) NOT NULL,
				`email` varchar(150) NOT NULL,
				`password_hash` varchar(255) NOT NULL,
				`role` enum('super_admin','admin','editor') NOT NULL DEFAULT 'admin',
				`status` tinyint(1) NOT NULL DEFAULT '1',
				`reset_token` varchar(64) DEFAULT NULL,
				`reset_token_expires_at` datetime DEFAULT NULL,
				`last_login_at` datetime DEFAULT NULL,
				`created_at` datetime NOT NULL,
				`updated_at` datetime NOT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY `uq_users_email` (`email`),
				KEY `idx_users_status` (`status`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
		")->execute();

		$this->getDbConnection()->createCommand("
			CREATE TABLE IF NOT EXISTS `districts` (
				`id` int unsigned NOT NULL AUTO_INCREMENT,
				`name` varchar(150) NOT NULL,
				`description` text,
				`status` tinyint(1) NOT NULL DEFAULT '1',
				`display_order` int NOT NULL DEFAULT '0',
				`created_at` datetime NOT NULL,
				`updated_at` datetime NOT NULL,
				PRIMARY KEY (`id`),
				KEY `idx_districts_status` (`status`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
		")->execute();

		$this->getDbConnection()->createCommand("
			CREATE TABLE IF NOT EXISTS `cms_pages` (
				`id` int unsigned NOT NULL AUTO_INCREMENT,
				`slug` varchar(100) NOT NULL,
				`title` varchar(255) NOT NULL,
				`content` longtext,
				`meta_json` text,
				`status` tinyint(1) NOT NULL DEFAULT '1',
				`updated_by` int unsigned DEFAULT NULL,
				`created_at` datetime NOT NULL,
				`updated_at` datetime NOT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY `uq_cms_pages_slug` (`slug`),
				KEY `idx_cms_pages_status` (`status`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
		")->execute();

		$this->getDbConnection()->createCommand("
			CREATE TABLE IF NOT EXISTS `settings` (
				`id` int unsigned NOT NULL AUTO_INCREMENT,
				`setting_key` varchar(100) NOT NULL,
				`setting_value` text,
				`setting_group` varchar(50) DEFAULT 'general',
				`updated_at` datetime NOT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY `uq_settings_key` (`setting_key`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
		")->execute();
	}

	public function safeDown()
	{
		$this->dropTable('settings');
		$this->dropTable('cms_pages');
		$this->dropTable('districts');
		$this->dropTable('users');
	}
}
