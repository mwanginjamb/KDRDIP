<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $ProfileID
 * @property string $FirstName
 * @property string $LastName
 * @property string $Email
 * @property string $Mobile
 * @property string $PasswordHash
 * @property string $AuthKey
 * @property string $ValidationCode
 * @property int $ProfileStatusID
 * @property int $PlanID
 * @property int $PlanOptionID
 * @property string $PlanExpiry
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Profiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ProfileStatusID', 'PlanID', 'PlanOptionID', 'CreatedBy', 'Deleted'], 'integer'],
            [['PlanExpiry', 'CreatedDate'], 'safe'],
            [['FirstName', 'LastName', 'Mobile', 'ValidationCode'], 'string', 'max' => 45],
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
            'ProfileID' => 'Profile ID',
            'FirstName' => 'First Name',
            'LastName' => 'Last Name',
            'Email' => 'Email',
            'Mobile' => 'Mobile',
            'PasswordHash' => 'Password Hash',
            'AuthKey' => 'Auth Key',
            'ValidationCode' => 'Validation Code',
            'ProfileStatusID' => 'Profile Status ID',
            'PlanID' => 'Plan ID',
            'PlanOptionID' => 'Plan Option ID',
            'PlanExpiry' => 'Plan Expiry',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
