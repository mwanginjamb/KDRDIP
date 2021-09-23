<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "funding_years".
 *
 * @property int $FundingYearID
 * @property string|null $FundingYearName
 * @property string|null $Notes
 * @property string $CreatedDate
 * @property int|null $CreatedBy
 * @property int $Deleted
 *
 * @property Users $createdBy
 * @property OrganizationFudingYears[] $organizationFudingYears
 * @property Organizations[] $organizations
 */
class FundingYears extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'funding_years';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['CreatedBy', 'Deleted'], 'integer'],
            [['FundingYearName'], 'string', 'max' => 45],
            [['CreatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['CreatedBy' => 'UserID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'FundingYearID' => 'Funding Year ID',
            'FundingYearName' => 'Funding Year Name',
            'Notes' => 'Notes',
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
     * Gets query for [[OrganizationFudingYears]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationFudingYears()
    {
        return $this->hasMany(OrganizationFudingYears::className(), ['FundingYearID' => 'FundingYearID']);
    }

    /**
     * Gets query for [[Organizations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations()
    {
        return $this->hasMany(Organizations::className(), ['OrganizationID' => 'OrganizationID'])->viaTable('organization_fuding_years', ['FundingYearID' => 'FundingYearID']);
    }
}
