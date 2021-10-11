<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth_item_child}}`.
 */
class m211011_190909_create_auth_item_child_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auth_item_child}}', [
            'id' => $this->primaryKey(),
            'parent' => $this->string(),
            'child' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auth_item_child}}');
    }
}
