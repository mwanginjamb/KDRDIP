<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%lipw_households}}`.
 */
class m220205_211209_add_mpesa_account_no_column_to_lipw_households_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%lipw_households}}', 'mpesa_account_no', $this->integer(10));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%lipw_households}}', 'mpesa_account_no');
    }
}
