<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organization_meetings".
 *
 * @property int $OrganizationMeetingID
 * @property string $Description
 * @property int $OrganizationID
 * @property string $Date
 * @property int|null $Present
 * @property int|null $Absent
 * @property float|null $Savings
 * @property float|null $Loans
 * @property float|null $Repayment
 * @property string|null $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 *
 * @property Users $createdBy
 * @property Organizations $organization
 */
class OrganizationMeetings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization_meetings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Description', 'OrganizationID', 'Date', 'CreatedBy'], 'required'],
            [['OrganizationID', 'Present', 'Absent', 'CreatedBy', 'Deleted'], 'integer'],
            [['Date', 'CreatedDate'], 'safe'],
            [['Savings', 'Loans', 'Repayment'], 'number'],
            [['Description'], 'string', 'max' => 200],
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
            'OrganizationMeetingID' => 'Organization Meeting ID',
            'Description' => 'Description',
            'OrganizationID' => 'Organization ID',
            'Date' => 'Date',
            'Present' => 'Present',
            'Absent' => 'Absent',
            'Savings' => 'Group Savings',
            'Loans' => 'Total Loans Provided',
            'Repayment' => 'Amount Repaid',
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
    public function getCreatedBy()
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
}
