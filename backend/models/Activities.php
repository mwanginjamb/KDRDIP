<?php

namespace app\models;

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
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Activities extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'activities';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['IndicatorID', 'ResponsibilityID', 'CreatedBy', 'Deleted'], 'integer'],
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
			'ResponsibilityID' => 'Responsibility ID',
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
}
