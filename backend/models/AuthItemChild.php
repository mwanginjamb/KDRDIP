<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "auth_item_child".
 *
 * @property int $id
 * @property string|null $parent
 * @property string|null $child
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class AuthItemChild extends \yii\db\ActiveRecord
{
    public $permissions;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item_child';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['parent', 'child'], 'string', 'max' => 255],
            ['child', 'validateChild'],
            ['permissions', 'safe']
        ];
    }


    public function validateChild($attribute, $params)
    {
        $result = $this::findOne(['parent' => $this->parent, 'child' => $this->child]);
        if($result)
        {
            $this->addError($attribute, 'Role Permission is already assigned.');
        }

    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent' => 'Parent',
            'child' => 'Child',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\AuthItemChildQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\AuthItemChildQuery(get_called_class());
    }
}
