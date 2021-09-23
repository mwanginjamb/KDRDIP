<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indicatortargets".
 *
 * @property int $IndicatorTargetID
 * @property string $IndicatorTargetName
 * @property int $IndicatorID
 * @property int $ReportingPeriodID
 * @property string $Target
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class IndicatorTargets extends \yii\db\ActiveRecord
{
	public $ReportingPeriodName;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'indicatortargets';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'indicatortargets.Deleted', 0]);
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
			[['Target'], 'number'],
			[['CreatedDate'], 'safe'],
			[['IndicatorTargetName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'IndicatorTargetID' => 'Indicator Target ID',
			'IndicatorTargetName' => 'Indicator Target Name',
			'IndicatorID' => 'Indicator ID',
			'ReportingPeriodID' => 'Reporting Period ID',
			'Target' => 'Target',
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
