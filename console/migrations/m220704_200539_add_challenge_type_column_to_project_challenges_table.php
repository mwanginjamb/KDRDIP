<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%project_challenges}}`.
 */
class m220704_200539_add_challenge_type_column_to_project_challenges_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%project_challenges}}', 'challenge_type', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%project_challenges}}', 'challenge_type');
    }
}
