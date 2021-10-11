<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth_assignment}}`.
 */
class m211011_191000_create_auth_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auth_assignment}}', [
            'id' => $this->primaryKey(),
            'item_name' => $this->string(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auth_assignment}}');
    }
}
