<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leagues".
 *
 * @property int $LeagueID
 * @property string $LeagueName
 * @property int $RegionID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Leagues extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'leagues';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['RegionID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['LeagueName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'LeagueID' => 'League ID',
			'LeagueName' => 'League Name',
			'RegionID' => 'Region',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getRegions()
	{
		return $this->hasOne(Regions::className(), ['RegionID' => 'RegionID'])->from(regions::tableName());
	}
}
