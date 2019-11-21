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
 * @property string $Justification
 * @property int $ReportingPeriodID
 * @property int $ComponentID
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

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectParentID', 'ProjectStatusID', 'CreatedBy', 'Deleted', 'ReportingPeriodID', 'ComponentID'], 'integer'],
			[['Objective', 'Justification'], 'string'],
			[['StartDate', 'EndDate', 'ApprovalDate', 'CreatedDate'], 'safe'],
			[['ProjectCost'], 'number'],
			[['ProjectName'], 'string', 'max' => 300],
			[['ProjectName', 'Objective', 'Justification', 'StartDate', 'EndDate', 'ApprovalDate', 'ProjectStatusID', 'ComponentID'], 'required']
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
			'ProjectParentID' => 'Parent Project',
			'Objective' => 'Objective',
			'StartDate' => 'Start Date',
			'EndDate' => 'End Date',
			'ProjectCost' => 'Project Cost',
			'ReportingPeriodID' => 'Reporting Period',
			'ApprovalDate' => 'Approval Date',
			'ProjectStatusID' => 'Project Status',
			'Justification' => 'Justification',
			'ComponentID' => 'Component',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getParentProject()
	{
		return $this->hasOne(Projects::className(), ['ProjectID' => 'ProjectParentID'])->from(['origin' => projects::tableName()]);
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
}
