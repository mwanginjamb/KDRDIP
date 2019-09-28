<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectrisk".
 *
 * @property int $ProjectRiskID
 * @property string $ProjectRiskName
 * @property int $RiskRatingID
 * @property int $ProjectID
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */
class ProjectRisk extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'projectrisk';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectRiskName'], 'string'],
			[['RiskRatingID', 'ProjectID', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectRiskID' => 'Project Risk ID',
			'ProjectRiskName' => 'Project Risk Name',
			'RiskRatingID' => 'Risk Rating ID',
			'ProjectID' => 'Project ID',
			'CreatedBy' => 'Created By',
			'CreatedDate' => 'Created Date',
			'Deleted' => 'Deleted',
		];
	}

	public function getRiskRating()
	{
		return $this->hasOne(RiskRating::className(), ['RiskRatingID' => 'RiskRatingID'])->from(riskrating::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
