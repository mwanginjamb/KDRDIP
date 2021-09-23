<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "procurement_plan_lines".
 *
 * @property int $ProcurementPlanLineID
 * @property int $ProcurementPlanID
 * @property string $ServiceDescription
 * @property int $UnitOfMeasureID
 * @property double $Quantity
 * @property int $ProcurementMethodID
 * @property string $SourcesOfFunds
 * @property string $EstimatedCost
 * @property string $ActualCost
 * @property string $CreatedDate
 * @property string $UpdatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProcurementPlanLines extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'procurement_plan_lines';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'procurement_plan_lines.Deleted', 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		// $m->deletedTime = time();
		return $m->save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProcurementPlanID'], 'required'],
			[['ProcurementPlanID', 'UnitOfMeasureID', 'ProcurementMethodID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Quantity', 'EstimatedCost', 'ActualCost'], 'number'],
			[['CreatedDate', 'UpdatedDate'], 'safe'],
			[['ServiceDescription', 'SourcesOfFunds'], 'string', 'max' => 300],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProcurementPlanLineID' => 'Procument Plan Line ID',
			'ProcurementPlanID' => 'Procument Plan ID',
			'ServiceDescription' => 'Activity Description',
			'UnitOfMeasureID' => 'Unit Of Measure ID',
			'Quantity' => 'Quantity',
			'ProcurementMethodID' => 'Procument Method ID',
			'SourcesOfFunds' => 'Sources Of Funds',
			'EstimatedCost' => 'Estimated Cost',
			'ActualCost' => 'Actual Cost',
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

	public function getUnitsOfMeasure()
	{
		return $this->hasOne(UnitsOfMeasure::className(), ['UnitOfMeasureID' => 'UnitOfMeasureID']);
	}

	public function getProcurementMethods()
	{
		return $this->hasOne(ProcurementMethods::className(), ['ProcurementMethodID' => 'ProcurementMethodID']);
	}

	public function getProcurementActivityLines()
	{
		return $this->hasMany(ProcurementActivityLines::className(), ['ProcurementPlanLineID' => 'ProcurementPlanLineID']);
	}

	public function getProcurementPlan()
	{
		return $this->hasOne(ProcurementPlan::className(), ['ProcurementPlanID' => 'ProcurementPlanID']);
	}
	
	public function getApprovers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'ApprovedBy'])->from(['approvers' => users::tableName()]);
	}

	public function getApprovalstatus()
	{
		return $this->hasOne(ApprovalStatus::className(), ['ApprovalStatusID' => 'ApprovalStatusID'])->from(approvalstatus::tableName());
	}

    public function getActualExpenditure()
    {
        return Payments::find()->andWhere(['ProcurementPlanLineID' => $this->ProcurementPlanLineID])->sum('Amount');
    }
}
