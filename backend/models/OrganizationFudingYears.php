<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organization_fuding_years".
 *
 * @property int $OrganizationID
 * @property int $FundingYearID
 * @property string $CreatedDate
 * @property int|null $CreatedBy
 * @property int $Deleted
 *
 * @property Users $createdBy
 * @property FundingYears $fundingYear
 * @property Organizations $organization
 */
class OrganizationFudingYears extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization_fuding_years';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['OrganizationID', 'FundingYearID'], 'required'],
            [['OrganizationID', 'FundingYearID', 'CreatedBy', 'Deleted'], 'integer'],
            [['CreatedDate'], 'safe'],
            [['OrganizationID', 'FundingYearID'], 'unique', 'targetAttribute' => ['OrganizationID', 'FundingYearID']],
            [['CreatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['CreatedBy' => 'UserID']],
            [['FundingYearID'], 'exist', 'skipOnError' => true, 'targetClass' => FundingYears::className(), 'targetAttribute' => ['FundingYearID' => 'FundingYearID']],
            [['OrganizationID'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['OrganizationID' => 'OrganizationID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'OrganizationID' => 'Organization ID',
            'FundingYearID' => 'Funding Year ID',
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
     * Gets query for [[FundingYear]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFundingYear()
    {
        return $this->hasOne(FundingYears::className(), ['FundingYearID' => 'FundingYearID']);
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
