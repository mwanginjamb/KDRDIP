<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organization_members".
 *
 * @property int $OrganizationMemberID
 * @property int $OrganizationID
 * @property string $FirstName
 * @property string $LastName
 * @property string $Mobile
 * @property string $IDNumber
 * @property string $AgeGroupID
 * @property string $Gender
 * @property string $CreatedDate
 * @property int|null $CreatedBy
 * @property int $Deleted
 *
 * @property Users $createdBy
 * @property Organizations $organization
 */
class OrganizationMembers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization_members';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['OrganizationID', 'FirstName', 'LastName', 'IDNumber', 'AgeGroupID', 'Gender'], 'required'],
            [['OrganizationID', 'CreatedBy', 'Deleted'], 'integer'],
            [['CreatedDate'], 'safe'],
            [['FirstName', 'LastName', 'Mobile', 'IDNumber'], 'string', 'max' => 45],
            [['CreatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['CreatedBy' => 'UserID']],
            [['OrganizationID'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['OrganizationID' => 'OrganizationID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'OrganizationMemberID' => 'Organization Member ID',
            'OrganizationID' => 'Organization ID',
            'FirstName' => 'First Name',
            'LastName' => 'Last Name',
            'Mobile' => 'Mobile',
            'IDNumber' => 'ID Number',
            'AgeGroupID' => 'Age Group',
            'Gender' => 'Gender',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
    }

    /**
     * Gets query for [[Organization]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organizations::className(), ['OrganizationID' => 'OrganizationID']);
    }

        /**
     * Gets query for [[Organization]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAgeGroup()
    {
        return $this->hasOne(AgeGroups::className(), ['AgeGroupID' => 'AgeGroupID']);
    }
}
