<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth_rule}}`.
 */
class m211011_190639_create_auth_rule_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auth_rule}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auth_rule}}');
    }
}
