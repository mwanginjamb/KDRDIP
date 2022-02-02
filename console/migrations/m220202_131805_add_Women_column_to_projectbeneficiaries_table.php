<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%projectbeneficiaries}}`.
 */
class m220202_131805_add_Women_column_to_projectbeneficiaries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%projectbeneficiaries}}', 'Women', $this->integer(7));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%projectbeneficiaries}}', 'Women');
    }
}
