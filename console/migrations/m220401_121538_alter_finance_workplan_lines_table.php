<?php

use yii\db\Migration;

/**
 * Class m220401_121538_alter_finance_workplan_lines_table
 */
class m220401_121538_alter_finance_workplan_lines_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%finance_workplan_lines}}','subproject', $this->string(150));
        $this->alterColumn('{{%finance_workplan_lines}}','financial_year', $this->string(150));
        $this->alterColumn('{{%finance_workplan_lines}}','sector', $this->string(150));
        $this->alterColumn('{{%finance_workplan_lines}}','component', $this->string(150));
        $this->alterColumn('{{%finance_workplan_lines}}','subcomponent', $this->string(150));
        $this->alterColumn('{{%finance_workplan_lines}}','county', $this->string(150));
        $this->alterColumn('{{%finance_workplan_lines}}','subcounty', $this->string(150));
        $this->alterColumn('{{%finance_workplan_lines}}','county', $this->string(150));
        $this->alterColumn('{{%finance_workplan_lines}}','ward', $this->string(150));
        $this->alterColumn('{{%finance_workplan_lines}}','village', $this->string(150));
        $this->alterColumn('{{%finance_workplan_lines}}','Ha-No', $this->string(150));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220401_121538_alter_finance_workplan_lines_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220401_121538_alter_finance_workplan_lines_table cannot be reverted.\n";

        return false;
    }
    */
}
