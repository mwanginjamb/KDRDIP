<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterindicators".
 *
 * @property int $MasterIndicatorID
 * @property string $MasterIndicatorName
 * @property string $DataSource
 * @property int $ReportingFrequencyID
 * @property int $BaseLineYear
 * @property string $ContributingTo
 * @property string $Responsibility
 * @property string $Definition
 * @property string $CalculationMethodology
 * @property string $DataCollectionMethod
 * @property int $IndicatorTypeID
 * @property int $ComponentID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class MasterIndicators extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'masterindicators';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['DataSource', 'ContributingTo', 'Responsibility', 'Definition', 'CalculationMethodology', 'DataCollectionMethod'], 'string'],
			[['ReportingFrequencyID', 'BaseLineYear', 'IndicatorTypeID', 'ComponentID', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['MasterIndicatorName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'MasterIndicatorID' => 'Master Indicator ID',
			'MasterIndicatorName' => 'Master Indicator Name',
			'DataSource' => 'Data Source',
			'ReportingFrequencyID' => 'Reporting Frequency',
			'BaseLineYear' => 'Base Line Year',
			'ContributingTo' => 'Contributing To',
			'Responsibility' => 'Responsibility',
			'Definition' => 'Definition',
			'CalculationMethodology' => 'Calculation Methodology',
			'DataCollectionMethod' => 'Data Collection Method',
			'IndicatorTypeID' => 'Indicator Type',
			'ComponentID' => 'Component',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getReportingFrequency()
	{
		return $this->hasOne(ReportingFrequency::className(), ['ReportingFrequencyID' => 'ReportingFrequencyID'])->from(reportingfrequency::tableName());
	}

	public function getIndicatorTypes()
	{
		return $this->hasOne(IndicatorTypes::className(), ['IndicatorTypeID' => 'IndicatorTypeID'])->from(indicatortypes::tableName());
	}

	public function getComponents()
	{
		return $this->hasOne(Components::className(), ['ComponentID' => 'ComponentID'])->from(components::tableName());
	}
}
