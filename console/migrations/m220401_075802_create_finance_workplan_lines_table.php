<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%finance_workplan_lines}}`.
 */
class m220401_075802_create_finance_workplan_lines_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%finance_workplan_lines}}', [
            'id' => $this->primaryKey(),
            'workplan_id' => $this->integer(),
            'subproject' => $this->integer(5),
            'financial_year' => $this->integer(),
            'period' => $this->string(10),
            'sector' => $this->integer(),
            'component' => $this->integer(),
            'subcomponent' => $this->integer(),
            'county' => $this->integer(),
            'subcounty' => $this->integer(),
            'ward' => $this->integer(),
            'village' => $this->integer(),
            'site' => $this->string(100),
            'Ha-No' => $this->integer(),
            'project_cost' => $this->double(),
            'remark' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%finance_workplan_lines}}');
    }
}
