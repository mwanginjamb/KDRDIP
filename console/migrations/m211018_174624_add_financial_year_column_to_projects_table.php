<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%projects}}`.
 */
class m211018_174624_add_financial_year_column_to_projects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%projects}}', 'financial_year', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%projects}}', 'financial_year');
    }
}
