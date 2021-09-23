<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "procurement_plan".
 *
 * @property int $ProcurementPlanID
 * @property int $ProjectID
 * @property string $FinancialYear
 * @property string $Comments
 * @property integer ApprovalStatusID
 * @property string ApprovalDate
 * @property integer ApprovedBy
 * @property string $CreatedDate
 * @property string $UpdatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProcurementPlan extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'procurement_plan';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectID', 'FinancialYear'], 'required'],
			[['ProjectID', 'CreatedBy', 'Deleted', 'ApprovalStatusID', 'ApprovedBy'], 'integer'],
			[['Comments'], 'string'],
			[['CreatedDate', 'UpdatedDate', 'ApprovalDate'], 'safe'],
			[['FinancialYear'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProcurementPlanID' => 'Procurement Plan ID',
			'ProjectID' => 'Project ID',
			'FinancialYear' => 'Financial Year',
			'Comments' => 'Comments',
			'ApprovalStatusID' => 'Status',
			'ApprovalDate' => 'Approval Date',
			'ApprovedBy' => 'Approved By',
			'CreatedDate' => 'Created Date',
			'UpdatedDate' => 'Updated Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getProjects()
	{
		return $this->hasOne(Projects::className(), ['ProjectID' => 'ProjectID']);
	}

	public function getApprovers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'ApprovedBy'])->from(['approvers' => users::tableName()]);
	}

	public function getApprovalstatus()
	{
		return $this->hasOne(ApprovalStatus::className(), ['ApprovalStatusID' => 'ApprovalStatusID'])->from(approvalstatus::tableName());
	}
}
