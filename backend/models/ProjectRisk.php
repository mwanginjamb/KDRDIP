<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectrisk".
 *
 * @property int $ProjectRiskID
 * @property string $ProjectRiskName
 * @property int $RiskRatingID
 * @property int $RiskLikelihoodID
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

	public static function find()
	{
		return parent::find()->andWhere(['=', 'projectrisk.Deleted', 0]);
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
			[['ProjectRiskName'], 'string'],
			[['RiskRatingID', 'ProjectID', 'CreatedBy', 'Deleted', 'RiskLikelihoodID'], 'integer'],
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
			'ProjectRiskName' => 'Project Risk',
			'RiskRatingID' => 'Risk Rating',
			'RiskLikelihoodID' => 'Risk Likelihood',
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

	public function getRiskLikelihood()
	{
		return $this->hasOne(RiskLikelihood::className(), ['RiskLikelihoodID' => 'RiskLikelihoodID'])->from(risklikelihood::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
