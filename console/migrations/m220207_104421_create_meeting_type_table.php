<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%meeting_type}}`.
 */
class m220207_104421_create_meeting_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%meeting_type}}', [
            'id' => $this->primaryKey(),
            'meeting_type' => $this->string(50)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%meeting_type}}');
    }
}
