<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projects".
 *
 * @property int $ProjectID
 * @property string $ProjectName
 * @property int $ProjectParentID
 * @property string $Objective
 * @property string $StartDate
 * @property string $EndDate
 * @property string $ProjectCost
 * @property string $ApprovalDate
 * @property int $ProjectStatusID
 * @property int $ComponentID
 * @property int $SubComponentID
 * @property int $SubComponentCategoryID
 * @property int $ReportingPeriodID
 * @property string $Justification
 * @property string $Longitude
 * @property string $Latitude
 * @property int $CurrencyID
 * @property int $CommunityID
 * @property string $SafeguardsRecommendedAction
 * @property int $CountyID
 * @property int $SubCountyID
 * @property int $WardID
 * @property int $LocationID
 * @property int $SubLocationID
 * @property int $EnterpriseTypeID
 * @property int $OrganizationID
 * @property string $IntegrationID
 * @property int $ProjectSectorID
 * @property int $SectorInterventionID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Projects extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'projects';
	}

	public function fields()
	{
		return [
			'SubProjectID' => 'ProjectID',
			'SubProjectName' => 'ProjectName',
			'CountyID',
			'SubCountyID',
			'WardID',
			'CreatedDate',
		];
	}

	public function extraFields()
	{
		return [
			'county',
			'subcounty',
			'ward',
		];
	}

	/**
	 * Added by Joseph Ngugi
	 * Filter Deleted Items
	 */
	public static function find()
	{
		return parent::find()
		->andWhere(['=', 'projects.Deleted', 0]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectParentID', 'ProjectStatusID', 'ComponentID', 'SubComponentID', 'SubComponentCategoryID', 'ReportingPeriodID', 'CurrencyID', 'CommunityID', 'CountyID', 'SubCountyID', 'WardID', 'LocationID', 'SubLocationID', 'EnterpriseTypeID', 'OrganizationID', 'ProjectSectorID', 'SectorInterventionID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Objective', 'Justification', 'SafeguardsRecommendedAction'], 'string'],
			[['StartDate', 'EndDate', 'ApprovalDate', 'CreatedDate'], 'safe'],
			[['ProjectCost', 'Longitude', 'Latitude'], 'number'],
			[['ProjectName'], 'string', 'max' => 300],
			[['IntegrationID'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectID' => 'Project ID',
			'ProjectName' => 'Project Name',
			'ProjectParentID' => 'Project Parent ID',
			'Objective' => 'Objective',
			'StartDate' => 'Start Date',
			'EndDate' => 'End Date',
			'ProjectCost' => 'Project Cost',
			'ApprovalDate' => 'Approval Date',
			'ProjectStatusID' => 'Project Status ID',
			'ComponentID' => 'Component ID',
			'SubComponentID' => 'Sub Component ID',
			'SubComponentCategoryID' => 'Sub Component Category ID',
			'ReportingPeriodID' => 'Reporting Period ID',
			'Justification' => 'Justification',
			'Longitude' => 'Longitude',
			'Latitude' => 'Latitude',
			'CurrencyID' => 'Currency ID',
			'CommunityID' => 'Community ID',
			'SafeguardsRecommendedAction' => 'Safeguards Recommended Action',
			'CountyID' => 'County ID',
			'SubCountyID' => 'Sub County ID',
			'WardID' => 'Ward ID',
			'LocationID' => 'Location ID',
			'SubLocationID' => 'Sub Location ID',
			'EnterpriseTypeID' => 'Enterprise Type ID',
			'OrganizationID' => 'Organization ID',
			'IntegrationID' => 'Integration ID',
			'ProjectSectorID' => 'Project Sector ID',
			'SectorInterventionID' => 'Sector Intervention ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}
	
	/**
	* Gets query for [[County]].`1`
	*
	* @return \yii\db\ActiveQuery
	*/
	public function getCounty()
	{
		return $this->hasOne(Counties::class, ['CountyID' => 'CountyID']);
	}

	
	/**
	* Gets query for [[SubCounty]].
	*
	* @return \yii\db\ActiveQuery
	*/
	public function getSubCounty()
	{
		return $this->hasOne(SubCounties::class, ['SubCountyID' => 'SubCountyID']);
	}

	
	/**
	* Gets query for [[Wards]].
	*
	* @return \yii\db\ActiveQuery
	*/
	public function getWard()
	{
		return $this->hasOne(Wards::class, ['WardID' => 'WardID']);
	}
}
