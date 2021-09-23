<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indicatoractuals".
 *
 * @property int $IndicatorActualID
 * @property int $IndicatorID
 * @property int $ReportingPeriodID
 * @property string $Actual
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class IndicatorActuals extends \yii\db\ActiveRecord
{
	public $IndicatorName;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'indicatoractuals';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'indicatoractuals.Deleted', 0]);
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
			[['IndicatorID', 'ReportingPeriodID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Actual'], 'number'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'IndicatorActualID' => 'Indicator Actual ID',
			'IndicatorID' => 'Indicator ID',
			'ReportingPeriodID' => 'Reporting Period ID',
			'Actual' => 'Actual',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getIndicators()
	{
		return $this->hasOne(Indicators::className(), ['IndicatorID' => 'IndicatorID'])->from(indicators::tableName());
	}

	public function getReportingPeriods()
	{
		return $this->hasOne(ReportingPeriods::className(), ['ReportingPeriodID' => 'ReportingPeriodID'])->from(reportingperiods::tableName());
	}
}
