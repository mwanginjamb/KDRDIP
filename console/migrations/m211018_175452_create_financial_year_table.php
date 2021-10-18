<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%financial_year}}`.
 */
class m211018_175452_create_financial_year_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%financial_year}}', [
            'id' => $this->primaryKey(),
            'year' => $this->string(),
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
        $this->dropTable('{{%financial_year}}');
    }
}
