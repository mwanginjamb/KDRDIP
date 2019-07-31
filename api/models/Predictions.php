<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "predictions".
 *
 * @property int $PredictionID
 * @property int $RegionID
 * @property int $LeagueID
 * @property string $GameTime
 * @property string $Teams
 * @property string $Prediction
 * @property string $FinalOutcome
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Predictions extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'predictions';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['RegionID', 'LeagueID', 'CreatedBy', 'Deleted'], 'integer'],
			[['GameTime', 'CreatedDate'], 'safe'],
			[['Teams'], 'string', 'max' => 250],
			[['Prediction', 'FinalOutcome'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'PredictionID' => 'Prediction ID',
			'RegionID' => 'Region ID',
			'LeagueID' => 'League ID',
			'GameTime' => 'Game Time',
			'Teams' => 'Teams',
			'Prediction' => 'Prediction',
			'FinalOutcome' => 'Final Outcome',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getRegions() 
	{
		return $this->hasOne(Regions::className(), ['RegionID' => 'RegionID'])->from(regions::tableName());
	}

	public function getLeagues() 
	{
		return $this->hasOne(Leagues::className(), ['LeagueID' => 'LeagueID'])->from(leagues::tableName());
	}
}
