<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%finance_workplan}}`.
 */
class m220401_074547_create_finance_workplan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%finance_workplan}}', [
            'id' => $this->primaryKey(),
            'workplan_title' => $this->string(150),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%finance_workplan}}');
    }
}
