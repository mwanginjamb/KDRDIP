<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%bankaccounts}}`.
 */
class m220106_092917_drop_AccountName_column_from_bankaccounts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%bankaccounts}}', 'AccountName');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%bankaccounts}}', 'AccountName', $this->string());
    }
}
