<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth_item}}`.
 */
class m211011_190759_create_auth_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auth_item}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'type' => $this->integer(),
            'description' => $this->text(),
            'rule_name' => $this->string(),
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
        $this->dropTable('{{%auth_item}}');
    }
}
