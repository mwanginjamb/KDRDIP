<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reportingperiods".
 *
 * @property int $ReportingPeriodID
 * @property string $ReportingPeriodName
 * @property int $ProjectID
 * @property string $ExpectedDate
 * @property string $ActualDate
 * @property int $ReportingStatusID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ReportingPeriods extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'reportingperiods';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'reportingperiods.Deleted', 0]);
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
			[['ProjectID', 'ReportingStatusID', 'CreatedBy', 'Deleted'], 'integer'],
			[['ExpectedDate', 'ActualDate', 'CreatedDate'], 'safe'],
			[['Notes'], 'string'],
			[['ReportingPeriodName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ReportingPeriodID' => 'Reporting Period ID',
			'ReportingPeriodName' => 'Reporting Period Name',
			'ProjectID' => 'Project ID',
			'ExpectedDate' => 'Expected Date',
			'ActualDate' => 'Actual Date',
			'ReportingStatusID' => 'Reporting Status ID',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getProjects()
	{
		return $this->hasOne(Projects::className(), ['ProjectID' => 'ProjectID'])->from(projects::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
