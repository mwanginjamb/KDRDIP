<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quarterly_targets}}`.
 */
class m220218_090704_create_quarterly_targets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quarterly_targets}}', [
            'id' => $this->primaryKey(),
            'targetID' => $this->integer(),
            'Q1' => $this->integer(),
            'Q2' => $this->integer(),
            'Q3' => $this->integer(),
            'Q4' => $this->integer(),
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
        $this->dropTable('{{%quarterly_targets}}');
    }
}
