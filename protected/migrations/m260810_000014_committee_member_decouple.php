<?php

/**
 * Per explicit request, Committee and Member must be completely separate
 * entities with no relationship between them - a committee position no
 * longer references the members table. This backfills each existing
 * assignment's name/phone/email from its linked member before dropping the
 * foreign key, so no data is lost.
 */
class m260810_000014_committee_member_decouple extends CDbMigration
{
	public function safeUp()
	{
		$this->addColumn('committee_members', 'full_name', "varchar(150) NOT NULL DEFAULT '' AFTER position_id");
		$this->addColumn('committee_members', 'phone', 'varchar(20) NULL AFTER full_name');
		$this->addColumn('committee_members', 'email', 'varchar(150) NULL AFTER phone');

		$this->getDbConnection()->createCommand("
			UPDATE committee_members cm
			LEFT JOIN members m ON m.id = cm.member_id
			SET cm.full_name = TRIM(CONCAT(COALESCE(m.first_name, ''), ' ', COALESCE(m.last_name, ''))),
			    cm.phone = m.phone,
			    cm.email = m.email
			WHERE cm.member_id IS NOT NULL
		")->execute();

		$this->dropColumn('committee_members', 'member_id');
	}

	public function safeDown()
	{
		$this->addColumn('committee_members', 'member_id', 'int unsigned NULL AFTER position_id');
		$this->createIndex('idx_committee_members_member', 'committee_members', 'member_id');
		$this->dropColumn('committee_members', 'email');
		$this->dropColumn('committee_members', 'phone');
		$this->dropColumn('committee_members', 'full_name');
	}
}
