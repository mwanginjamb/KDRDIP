<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usertypes".
 *
 * @property int $UserTypeID
 * @property string $UserTypeName
 * @property string $Notes
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */
class UserTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usertypes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Notes'], 'string'],
            [['CreatedBy', 'Deleted'], 'integer'],
            [['CreatedDate'], 'safe'],
            [['UserTypeName'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'UserTypeID' => 'User Type ID',
            'UserTypeName' => 'User Type Name',
            'Notes' => 'Notes',
            'CreatedBy' => 'Created By',
            'CreatedDate' => 'Created Date',
            'Deleted' => 'Deleted',
        ];
    }
}
