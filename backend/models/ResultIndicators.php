<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "result_indicators".
 *
 * @property int $ResultIndicatorID
 * @property string $ResultIndicatorName
 * @property int $IndicatorTypeID
 * @property int $UnitOfMeasureID
 * @property string $Notes
 * @property string $Baseline
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ResultIndicators extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'result_indicators';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'result_indicators.Deleted', 0]);
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
			[['ResultIndicatorName', 'IndicatorTypeID', 'Baseline', 'UnitOfMeasureID'], 'required'],
			[['IndicatorTypeID', 'CreatedBy', 'Deleted', 'UnitOfMeasureID'], 'integer'],
			[['ResultIndicatorName', 'Notes'], 'string'],
			[['Baseline'], 'number'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ResultIndicatorID' => 'Result Indicator ID',
			'ResultIndicatorName' => 'Result Indicator Name',
			'IndicatorTypeID' => 'Indicator Type',
			'UnitOfMeasureID' => 'Unit Of Measure',
			'Notes' => 'Notes',
			'Baseline' => 'Baseline',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::class, ['UserID' => 'CreatedBy']);
	}

	public function getIndicatorTypes()
	{
		return $this->hasOne(IndicatorTypes::class, ['IndicatorTypeID' => 'IndicatorTypeID']);
	}

	public function getResultIndicatorTargets()
	{
		return $this->hasMany(ResultIndicatorTargets::class, ['ResultIndicatorID' => 'ResultIndicatorID']);
	}

	

	public function getUnitsOfMeasure()
	{
		return $this->hasOne(UnitsOfMeasure::class, ['UnitOfMeasureID' => 'UnitOfMeasureID']);
	}
}
