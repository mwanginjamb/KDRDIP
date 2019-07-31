<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "planbenefits".
 *
 * @property int $PlanBenefitID
 * @property int $PlanID
 * @property int $BenefitID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class PlanBenefits extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'planbenefits';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['PlanID', 'BenefitID', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'PlanBenefitID' => 'Plan Benefit ID',
			'PlanID' => 'Plan ID',
			'BenefitID' => 'Benefit ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getBenefits() 
	{
		return $this->hasOne(Benefits::className(), ['BenefitID' => 'BenefitID'])->from(benefits::tableName());
	}
}
