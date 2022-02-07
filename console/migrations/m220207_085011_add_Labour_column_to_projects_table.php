<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%projects}}`.
 */
class m220207_085011_add_Labour_column_to_projects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%projects}}', 'Labour', $this->double());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%projects}}', 'Labour');
    }
}
