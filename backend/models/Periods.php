<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "periods".
 *
 * @property int $PeriodID
 * @property string $PeriodName
 * @property string $Notes
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */
class Periods extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'periods';
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
			[['PeriodName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'PeriodID' => 'Period ID',
			'PeriodName' => 'Period Name',
			'Notes' => 'Notes',
			'CreatedBy' => 'Created By',
			'CreatedDate' => 'Created Date',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
	}
}
