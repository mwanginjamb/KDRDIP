<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "auth_item_type".
 *
 * @property int $id
 * @property string|null $type
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class AuthItemType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\AuthItemTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\AuthItemTypeQuery(get_called_class());
    }
}
