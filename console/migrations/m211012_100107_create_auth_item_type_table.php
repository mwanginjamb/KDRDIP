<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth_item_type}}`.
 */
class m211012_100107_create_auth_item_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auth_item_type}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auth_item_type}}');
    }
}
