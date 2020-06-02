<?php

namespace app\models;
use app\models\ActivityBudget;
use app\models\FundsRequisition;
use app\models\Payments;

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
 * @property string $Justification
 * @property int $ReportingPeriodID
 * @property int $ComponentID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 * @property int $CurrencyID
 * @property string $Longitude
 * @property string $Latitude
 * @property int $CommunityID
 * @property int $CountyID
 * @property string $SafeguardsRecommendedAction
 * @property int $SubCountyID
 * @property int $WardID
 * @property int $LocationID
 * @property int $SubLocationID
 * @property int $OrganizationID
 * @property int $EnterpriseTypeID
 * @property string $IntegrationID
 * @property int $ProjectSectorID
 * @property int $SubComponentID
 * @property int $SubComponentCategoryID
 * @property int $SectorInterventionID
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

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectParentID', 'ProjectStatusID', 'CreatedBy', 'Deleted', 'ReportingPeriodID', 'WardID',
				'ComponentID', 'CurrencyID', 'CommunityID', 'CountyID', 'SubCountyID', 'LocationID', 'SubLocationID',
				'OrganizationID', 'EnterpriseTypeID', 'ProjectSectorID', 'SubComponentID', 'SubComponentCategoryID'], 'integer'],
			[['Objective', 'Justification', 'SafeguardsRecommendedAction', 'IntegrationID', 'SectorInterventionID'], 'string'],
			[['StartDate', 'EndDate', 'ApprovalDate', 'CreatedDate'], 'safe'],
			[['ProjectCost', 'Longitude', 'Latitude'], 'number'],
			[['ProjectName'], 'string', 'max' => 300],
			[['ProjectName', 'Objective', 'Justification', 'StartDate', 'CountyID',
				'EndDate', 'ApprovalDate', 'ProjectStatusID', 'ComponentID', 'CurrencyID', 'CommunityID', 'SubCountyID',
				'LocationID', 'SubLocationID', 'WardID'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectID' => 'Project ID',
			'ProjectName' => 'Sub-Project',
			'ProjectParentID' => 'Parent Project',
			'Objective' => 'Objective',
			'StartDate' => 'Date of Formation',
			'EndDate' => 'Date Wound Up',
			'ProjectCost' => 'Project Cost',
			'ReportingPeriodID' => 'Reporting Period',
			'ApprovalDate' => 'Approval Date',
			'ProjectStatusID' => 'Project Status',
			'Justification' => 'Justification',
			'ComponentID' => 'Component',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'CurrencyID' => 'Currency',
			'Longitude' => 'Longitude',
			'Latitude' => 'Latitude',
			'CommunityID' => 'Community',
			'CountyID' => 'County',
			'SafeguardsRecommendedAction' => 'If there is at least one ‘Yes’, which course of action do you recommend?',
			'SubCountyID'  => 'Sub County',
			'LocationID'  => 'Location',
			'SubLocationID'  => 'Sub Location',
			'WardID' => 'Ward',
			'OrganizationID' => 'Organization',
			'EnterpriseTypeID' => 'Enterprise Type',
			'IntegrationID' => 'Integration',
			'ProjectSectorID' => 'Project Sector',
			'SubComponentID' => 'Sub Component',
			'SubComponentCategoryID' => 'Sub Component Category',
			'SectorInterventionID' => 'Sector Intervention',
		];
	}

	public function getParentProject()
	{
		return $this->hasOne(Projects::className(), ['ProjectID' => 'ProjectParentID'])->from(['parentProject' => projects::tableName()]);
	}

	public function getProjectStatus()
	{
		return $this->hasOne(ProjectStatus::className(), ['ProjectStatusID' => 'ProjectStatusID'])->from(projectstatus::tableName());
	}

	public function getComponents()
	{
		return $this->hasOne(Components::className(), ['ComponentID' => 'ComponentID'])->from(components::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getCurrencies()
	{
		return $this->hasOne(Currencies::className(), ['CurrencyID' => 'CurrencyID'])->from(currencies::tableName());
	}

	public function getCommunities()
	{
		return $this->hasOne(Communities::className(), ['CommunityID' => 'CommunityID'])->from(communities::tableName());
	}

	public function getCounties()
	{
		return $this->hasOne(Counties::className(), ['CountyID' => 'CountyID'])->from(counties::tableName());
	}

	public function getSubCounties()
	{
		return $this->hasOne(SubCounties::className(), ['SubCountyID' => 'SubCountyID'])->from(subcounties::tableName());
	}

	public function getLocations()
	{
		return $this->hasOne(Locations::className(), ['LocationID' => 'LocationID'])->from(locations::tableName());
	}

	public function getSubLocations()
	{
		return $this->hasOne(SubLocations::className(), ['SubLocationID' => 'SubLocationID'])->from(sublocations::tableName());
	}

	public function getWards()
	{
		return $this->hasOne(Wards::className(), ['WardID' => 'WardID'])->from(wards::tableName());
	}

	public function getProjectSectors()
	{
		return $this->hasOne(ProjectSectors::className(), ['ProjectSectorID' => 'ProjectSectorID']);
	}

	public function getBudgetedAmount()
	{
		return ActivityBudget::find()->joinWith('activities')
												->joinWith('activities.indicators')
												->where(['indicators.ProjectID' => $this->ProjectID])->sum('activitybudget.Amount');
	}

	public function getDisbursedAmount()
	{
		return FundsRequisition::find()->where(['ProjectID' => $this->ProjectID])->sum('Amount');
	}

	public function getAmountSpent()
	{
		return Payments::find()->joinWith('invoices')->joinWith('invoices.purchases')->where(['purchases.ProjectID' => $this->ProjectID])->sum('payments.Amount');
	}

	public function getEnterpriseTypes()
	{
		return $this->hasOne(EnterpriseTypes::className(), ['EnterpriseTypeID' => 'EnterpriseTypeID'])->from(enterprisetypes::tableName());
	}

	public function getSubComponents()
	{
		return $this->hasOne(SubComponents::className(), ['SubComponentID' => 'SubComponentID']);
	}

	public function getSubComponentCategories()
	{
		return $this->hasOne(SubComponentCategories::className(), ['SubComponentCategoryID' => 'SubComponentCategoryID']);
	}

	public function getProjectSectorInterventions()
	{
		return $this->hasOne(ProjectSectorInterventions::className(), ['SectorInterventionID' => 'SectorInterventionID']);
	}

	public function getOrganizationName()
	{
		$etid = $this->EnterpriseTypeID;
		if ($etid == 1) {
			$organization = CommunityGroups::find()->where(['CommunityGroupID' => $this->OrganizationID])->select('CommunityGroupID as OrganizationID, CommunityGroupName as OrganizationName')->asArray()->one();
		} elseif ($etid == 2) {
			$organization = Businesses::find()->where(['BusinessID' => $this->OrganizationID])->select('BusinessID as OrganizationID, BusinessName as OrganizationName')->asArray()->one();
		} elseif ($etid == 3) {
			$organization = ProducerOrganizations::find()->where(['ProducerOrganizationID' => $this->OrganizationID])->select('ProducerOrganizationID as OrganizationID, ProducerOrganizationName as OrganizationName')->asArray()->one();
		} elseif ($etid == 4) {
			$organization = YouthPlacement::find()->where(['YouthPlacementID' => $this->OrganizationID])->select('YouthPlacementID as OrganizationID, YouthPlacementName as OrganizationName')->asArray()->one();
		} else {
			$organization = [];
		}
		return (!empty($organization)) ? $organization['OrganizationName'] : '';
	}
}
