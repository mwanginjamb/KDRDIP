<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lipw_households".
 *
 * @property int $HouseholdID
 * @property string $HouseholdName
 * @property int $SubLocationID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class LipwHouseholds extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'lipw_households';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['SubLocationID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['HouseholdName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'HouseholdID' => 'Household ID',
			'HouseholdName' => 'Household Name',
			'SubLocationID' => 'Sub Location ID',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
	}

	public function getSubLocations()
	{
		return $this->hasOne(SubLocations::className(), ['SubLocationID' => 'SubLocationID']);
	}
}
