<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cash_disbursements}}`.
 */
class m220119_054859_add_filePath_column_to_cash_disbursements_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%cash_disbursements}}', 'filePath', $this->string(100));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%cash_disbursements}}', 'filePath');
    }
}
