<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unitsofmeasure".
 *
 * @property int $UnitOfMeasureID
 * @property string $UnitOfMeasureName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class UnitsOfMeasure extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'unitsofmeasure';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted'], 'integer'],
			[['UnitOfMeasureName'], 'string', 'max' => 45],
			[['UnitOfMeasureName'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'UnitOfMeasureID' => 'Unit Of Measure ID',
			'UnitOfMeasureName' => 'Unit Of Measure',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
