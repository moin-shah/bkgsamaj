<?php

/**
 * Collapses committee_positions + committee_members into one table: a
 * committee entry is now (district, position, office-holder) directly,
 * with Position and District chosen from a form instead of navigating into
 * a position to manage its members. Enforces one row per (position,
 * district) pair - no two Presidents for the same district.
 *
 * Rows that can't be backfilled (an orphaned position_id, or the pre-existing
 * "empty selection saved as district_id=0" bug) have no valid district to
 * migrate to and are dropped rather than assigned a guessed district.
 */
class m260810_000015_committee_flatten extends CDbMigration
{
	public function safeUp()
	{
		$this->addColumn('committee_members', 'district_id', 'int unsigned NULL AFTER position_id');
		$this->addColumn('committee_members', 'position', 'varchar(50) NULL AFTER district_id');

		$this->getDbConnection()->createCommand("
			UPDATE committee_members cm
			JOIN committee_positions cp ON cp.id = cm.position_id
			JOIN districts d ON d.id = cp.district_id
			SET cm.district_id = cp.district_id, cm.position = cp.title
		")->execute();

		$this->getDbConnection()->createCommand(
			'DELETE FROM committee_members WHERE district_id IS NULL OR position IS NULL'
		)->execute();

		$this->alterColumn('committee_members', 'district_id', 'int unsigned NOT NULL');
		$this->alterColumn('committee_members', 'position', 'varchar(50) NOT NULL');

		$this->dropColumn('committee_members', 'position_id');
		$this->createIndex('uq_committee_position_district', 'committee_members', 'position, district_id', true);

		$this->dropTable('committee_positions');

		$this->renameTable('committee_members', 'committee');
	}

	public function safeDown()
	{
		$this->renameTable('committee', 'committee_members');

		$this->createTable('committee_positions', array(
			'id' => 'pk',
			'title' => 'varchar(150) NOT NULL',
			'district_id' => 'int unsigned NULL',
			'display_order' => 'int NOT NULL DEFAULT 0',
			'status' => 'tinyint(1) NOT NULL DEFAULT 1',
			'created_at' => 'datetime NOT NULL',
			'updated_at' => 'datetime NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

		$this->getDbConnection()->createCommand("
			INSERT INTO committee_positions (title, district_id, display_order, status, created_at, updated_at)
			SELECT DISTINCT position, district_id, 0, 1, NOW(), NOW() FROM committee_members
		")->execute();

		$this->addColumn('committee_members', 'position_id', 'int unsigned NULL AFTER id');
		$this->getDbConnection()->createCommand("
			UPDATE committee_members cm
			JOIN committee_positions cp ON cp.title = cm.position AND cp.district_id = cm.district_id
			SET cm.position_id = cp.id
		")->execute();
		$this->alterColumn('committee_members', 'position_id', 'int unsigned NOT NULL');

		$this->dropIndex('uq_committee_position_district', 'committee_members');
		$this->dropColumn('committee_members', 'position');
		$this->dropColumn('committee_members', 'district_id');
	}
}
