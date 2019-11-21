<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indicatortargets".
 *
 * @property int $IndicatorTargetID
 * @property string $IndicatorTargetName
 * @property string $Target
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class IndicatorTargets extends \yii\db\ActiveRecord
{
	public $ReportingPeriodName;
	public $RPID;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'indicatortargets';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Target'], 'number'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted'], 'integer'],
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
			'Target' => 'Target',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}
}
