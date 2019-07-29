<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $UserID
 * @property string $FirstName
 * @property string $LastName
 * @property string $Email
 * @property string $Mobile
 * @property string $PasswordHash
 * @property string $AuthKey
 * @property string $ValidationCode
 * @property string $ResetCode
 * @property int $UserStatusID
 * @property int $UserGroupID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['UserStatusID', 'UserGroupID', 'CreatedBy', 'Deleted'], 'integer'],
            [['CreatedDate'], 'safe'],
            [['FirstName', 'LastName', 'Mobile', 'ValidationCode', 'ResetCode'], 'string', 'max' => 45],
            [['Email'], 'string', 'max' => 250],
            [['PasswordHash', 'AuthKey'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'UserID' => 'User ID',
            'FirstName' => 'First Name',
            'LastName' => 'Last Name',
            'Email' => 'Email',
            'Mobile' => 'Mobile',
            'PasswordHash' => 'Password Hash',
            'AuthKey' => 'Auth Key',
            'ValidationCode' => 'Validation Code',
            'ResetCode' => 'Reset Code',
            'UserStatusID' => 'User Status ID',
            'UserGroupID' => 'User Group ID',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
