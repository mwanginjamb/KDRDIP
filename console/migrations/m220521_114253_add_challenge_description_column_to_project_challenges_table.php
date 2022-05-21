<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%project_challenges}}`.
 */
class m220521_114253_add_challenge_description_column_to_project_challenges_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%project_challenges}}', 'challenge_description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%project_challenges}}', 'challenge_description');
    }
}
