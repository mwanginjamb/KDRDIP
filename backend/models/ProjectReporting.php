<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectreporting".
 *
 * @property int $ProjectReportingID
 * @property int $ProjectID
 * @property string $Period
 * @property int $ProjectPeriodID
 * @property string $Target
 * @property string $Actual
 * @property int $IndicatorID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectReporting extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'projectreporting';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'projectreporting.Deleted', 0]);
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
			[['ProjectID', 'ProjectPeriodID', 'IndicatorID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Target', 'Actual'], 'number'],
			[['CreatedDate'], 'safe'],
			[['Period'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectReportingID' => 'Project Reporting ID',
			'ProjectID' => 'Project ID',
			'Period' => 'Period',
			'ProjectPeriodID' => 'Project Period ID',
			'Target' => 'Target',
			'Actual' => 'Actual',
			'IndicatorID' => 'Indicator ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}
}
