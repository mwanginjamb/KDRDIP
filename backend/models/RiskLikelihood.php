<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "risklikelihood".
 *
 * @property int $RiskLikelihoodID
 * @property string $RiskLikelihoodName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class RiskLikelihood extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'risklikelihood';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'risklikelihood.Deleted', 0]);
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
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted'], 'integer'],
			[['RiskLikelihoodName'], 'string', 'max' => 45],
			[['RiskLikelihoodName'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'RiskLikelihoodID' => 'Risk Likelihood ID',
			'RiskLikelihoodName' => 'Risk Likelihood',
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
