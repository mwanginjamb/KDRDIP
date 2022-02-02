<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%projectbeneficiaries}}`.
 */
class m220202_131941_add_Minority_column_to_projectbeneficiaries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%projectbeneficiaries}}', 'Minority', $this->integer(7));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%projectbeneficiaries}}', 'Minority');
    }
}
