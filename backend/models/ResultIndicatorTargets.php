<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "result_indicator_targets".
 *
 * @property int $ResultIndicatorTargetID
 * @property int $ResultIndicatorID
 * @property int $Year
 * @property string $Target
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ResultIndicatorTargets extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'result_indicator_targets';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ResultIndicatorID', 'Year', 'CreatedBy', 'Deleted'], 'integer'],
			[['Target'], 'number'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ResultIndicatorTargetID' => 'Result Indicator Target ID',
			'ResultIndicatorID' => 'Result Indicator ID',
			'Year' => 'Year',
			'Target' => 'Target',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getQuarterlyTargets()
	{
		return $this->hasOne(QuarterlyTargets::class, ['targetID' => 'ResultIndicatorTargetID']);
	}

	public static function find()
	{
		return parent::find()->joinWith('quarterlyTargets');
	}
}
