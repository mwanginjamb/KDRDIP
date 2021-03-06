<?php

namespace app\models;
use app\models\ActivityBudget;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "activities".
 *
 * @property int $ActivityID
 * @property int $IndicatorID
 * @property string $ActivityName
 * @property string $StartDate
 * @property string $EndDate
 * @property string $ActualStartDate
 * @property string $ActualEndDate
 * @property int $ResponsibilityID
 * @property string $CreatedDate
 * @property int $ProcurementItem
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Activities extends \yii\db\ActiveRecord
{
	// public $Total = $this->getCalculateTotal();

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'activities';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'activities.Deleted', 0]);
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
			[['IndicatorID', 'ResponsibilityID', 'CreatedBy', 'Deleted', 'ProcurementItem'], 'integer'],
			[['StartDate', 'EndDate', 'ActualStartDate', 'ActualEndDate', 'CreatedDate'], 'safe'],
			[['ActivityName'], 'string', 'max' => 500],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ActivityID' => 'Activity ID',
			'IndicatorID' => 'Indicator ID',
			'ActivityName' => 'Activity Name',
			'StartDate' => 'Start Date',
			'EndDate' => 'End Date',
			'ActualStartDate' => 'Actual Start Date',
			'ActualEndDate' => 'Actual End Date',
			'ResponsibilityID' => 'Responsibility',
			'ProcurementItem' => '',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getEmployees()
	{
		return $this->hasOne(Employees::className(), ['EmployeeID' => 'ResponsibilityID'])->from(employees::tableName());
	}

	public function getIndicators()
	{
		return $this->hasOne(Indicators::className(), ['IndicatorID' => 'IndicatorID'])->from(indicators::tableName());
	}

	public function getActivityBudget()
	{
		return $this->hasMany(ActivityBudget::className(), ['ActivityID' => 'ActivityID']);
	}

	public function getActivityOutputs()
	{
		return $this->hasMany(ActivityOutputs::className(), ['ActivityID' => 'ActivityID']);
	}

	public static function totals($projectID)
	{
		$sql = "SELECT sum(Amount) as Total, activitybudget.ActivityID FROM activitybudget
					JOIN activities on activities.ActivityID = activitybudget.ActivityID
					JOIN indicators on indicators.IndicatorID = activities.IndicatorID
					WHERE indicators.ProjectID = $projectID
					Group By activitybudget.ActivityID";
		// return ActivityBudget::findBySql($sql)->asArray()->all();
		return ArrayHelper::index(ActivityBudget::findBySql($sql)->asArray()->all(), 'ActivityID');
	}

	public static function getCalculateTotal()
	{
		return 0;
	}
}
