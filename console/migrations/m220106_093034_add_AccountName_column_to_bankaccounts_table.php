<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%bankaccounts}}`.
 */
class m220106_093034_add_AccountName_column_to_bankaccounts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%bankaccounts}}', 'AccountName', $this->string(150));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%bankaccounts}}', 'AccountName');
    }
}
