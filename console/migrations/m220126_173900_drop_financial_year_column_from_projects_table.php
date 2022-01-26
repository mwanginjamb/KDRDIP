<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%projects}}`.
 */
class m220126_173900_drop_financial_year_column_from_projects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%projects}}', 'financial_year');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%projects}}', 'financial_year', $this->integer());
    }
}
