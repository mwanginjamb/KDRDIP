<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organizations".
 *
 * @property int $OrganizationID
 * @property string $OrganizationName
 * @property string $RegistrationDate
 * @property int|null $LivelihoodActivityID
 * @property float|null $GrantAmount 
 * @property float|null $TotalAmountRequired
 * @property float|null $CommunityContribution
 * @property float|null $CountyContribution 
 * @property float|null $BalanceRequired
 * @property int|null $MaleMembers
 * @property int|null $FemaleMembers
 * @property int|null $PWDMembers
 * @property string|null $TradingName
 * @property string|null $PostalAddress
 * @property string|null $PostalCode
 * @property string|null $Town
 * @property int|null $CountryID
 * @property string|null $PhysicalLocation
 * @property string|null $Telephone
 * @property string|null $Mobile
 * @property string|null $Email
 * @property string|null $Url
 * @property int|null $CountyID
 * @property int|null $SubCountyID
 * @property int|null $WardID
 * @property int|null $SubLocationID
 * @property string|null $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 *
 * @property OrganizationActivities[] $organizationActivities
 * @property LivelihoodActivity[] $livelihoodActivities
 * @property OrganizationFudingYears[] $organizationFudingYears
 * @property FundingYears[] $fundingYears
 * @property Counties $county
 * @property Users $createdBy
 * @property Subcounties $subCounty
 * @property Sublocations $subLocation
 * @property Wards $ward
 */

class Organizations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organizations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['OrganizationName', 'RegistrationDate', 'CreatedBy', 'LivelihoodActivityID', 'TotalAmountRequired', 'CommunityContribution', 'CountyContribution', 'BalanceRequired'], 'required'],
            [['RegistrationDate', 'CreatedDate'], 'safe'],
            [['LivelihoodActivityID', 'MaleMembers', 'FemaleMembers', 'PWDMembers', 'CountryID', 'CountyID', 'SubCountyID', 'WardID', 'SubLocationID', 'CreatedBy', 'Deleted'], 'integer'],
            [['OrganizationName', 'TradingName'], 'string', 'max' => 200],
            [['GrantAmount', 'TotalAmountRequired', 'CommunityContribution', 'CountyContribution', 'BalanceRequired'], 'number'],
            [['PostalAddress', 'PostalCode', 'Town', 'Telephone', 'Mobile'], 'string', 'max' => 45],
            [['PhysicalLocation', 'Email', 'Url'], 'string', 'max' => 300],
            [['CountyID'], 'exist', 'skipOnError' => true, 'targetClass' => Counties::className(), 'targetAttribute' => ['CountyID' => 'CountyID']],
            [['CreatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['CreatedBy' => 'UserID']],
            [['SubCountyID'], 'exist', 'skipOnError' => true, 'targetClass' => Subcounties::className(), 'targetAttribute' => ['SubCountyID' => 'SubCountyID']],
            [['SubLocationID'], 'exist', 'skipOnError' => true, 'targetClass' => Sublocations::className(), 'targetAttribute' => ['SubLocationID' => 'SubLocationID']],
            [['WardID'], 'exist', 'skipOnError' => true, 'targetClass' => Wards::className(), 'targetAttribute' => ['WardID' => 'WardID']],
            ['OrganizationName', 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'OrganizationID' => 'Community Group ID',
            'OrganizationName' => 'Community Group Name',
            'RegistrationDate' => 'Registration Date',
            'LivelihoodActivityID' => 'Livelihood Activity',
            'MaleMembers' => 'Male Members',
            'FemaleMembers' => 'Female Members',
            'PWDMembers' => 'PWD Members',
            'GrantAmount' => 'Grant Amount',
            'TradingName' => 'Trading Name',
            'PostalAddress' => 'Postal Address',
            'PostalCode' => 'Postal Code',
            'Town' => 'Nearest Shopping Center',
            'CountryID' => 'Country',
            'PhysicalLocation' => 'Physical Location',
            'Telephone' => 'Telephone',
            'Mobile' => 'Contacts (Mobile Number)',
            'Email' => 'Email',
            'Url' => 'Url',
            'CountyID' => 'County',
            'SubCountyID' => 'Sub County',
            'WardID' => 'Ward',
            'SubLocationID' => 'Village',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
            'totalMembers' => 'No. of Members',
            'TotalAmountRequired' => 'Total Amount Required',
            'CommunityContribution' => 'Community Contribution',
            'CountyContribution' => 'County Contribution',
            'BalanceRequired' => 'Balance Required'
        ];
    }

    /**
     * Gets query for [[OrganizationActivities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationActivities()
    {
        return $this->hasMany(OrganizationActivities::className(), ['OrganizationID' => 'OrganizationID']);
    }

    /**
     * Gets query for [[OrganizationFudingYears]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationFudingYears()
    {
        return $this->hasMany(OrganizationFudingYears::className(), ['OrganizationID' => 'OrganizationID']);
    }

    /**
     * Gets query for [[FundingYears]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFundingYears()
    {
        return $this->hasMany(FundingYears::className(), ['FundingYearID' => 'FundingYearID'])->viaTable('organization_fuding_years', ['OrganizationID' => 'OrganizationID']);
    }


    /**
     * Gets query for [[County]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['CountryID' => 'CountryID']);
    }

    /**
     * Gets query for [[County]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCounty()
    {
        return $this->hasOne(Counties::className(), ['CountyID' => 'CountyID']);
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
     * Gets query for [[SubCounty]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubCounty()
    {
        return $this->hasOne(Subcounties::className(), ['SubCountyID' => 'SubCountyID']);
    }

    /**
     * Gets query for [[SubLocation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubLocation()
    {
        return $this->hasOne(Sublocations::className(), ['SubLocationID' => 'SubLocationID']);
    }

    /**
     * Gets query for [[SubLocation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLivelihoodActivity()
    {
        return $this->hasOne(LivelihoodActivities::className(), ['LivelihoodActivityID' => 'LivelihoodActivityID']);
    }

    /**
     * Gets query for [[Ward]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWard()
    {
        return $this->hasOne(Wards::className(), ['WardID' => 'WardID']);
    }

    public function getTotalMembers()
    {
        return $this->FemaleMembers + $this->MaleMembers;
    }

    public function getFemalePercentage()
    {
        $divisor = (($this->FemaleMembers + $this->MaleMembers)) < 1 ? 1 : ($this->FemaleMembers + $this->MaleMembers);
        return $this->FemaleMembers / $divisor  * 100;
    }

    public function getMalePercentage()
    {
        $divisor = (($this->FemaleMembers + $this->MaleMembers)) < 1 ? 1 : ($this->FemaleMembers + $this->MaleMembers);
        return $this->MaleMembers / $divisor * 100;
    }

    // Calculate Actual Gender Clustering

    public function getMales()
    {
        $count  = OrganizationMembers::find()->where(['Gender' => 'M', 'OrganizationMemberID' => $this->OrganizationID])->count();
        return $count;
    }

    public function getFemales()
    {
        $count  = OrganizationMembers::find()->where(['Gender' => 'F', 'OrganizationMemberID' => $this->OrganizationID])->count();
        return $count;
    }
}
