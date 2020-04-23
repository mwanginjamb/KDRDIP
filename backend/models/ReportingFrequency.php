<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reportingfrequency".
 *
 * @property int $ReportingFrequencyID
 * @property string $ReportingFrequencyName
 * @property string $Notes
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */
class ReportingFrequency extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'reportingfrequency';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Notes'], 'string'],
			[['CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['ReportingFrequencyName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ReportingFrequencyID' => 'Reporting Frequency ID',
			'ReportingFrequencyName' => 'Reporting Frequency Name',
			'Notes' => 'Notes',
			'CreatedBy' => 'Created By',
			'CreatedDate' => 'Created Date',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
