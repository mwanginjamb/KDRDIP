<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "budget".
 *
 * @property int $BudgetID
 * @property string $FinancialPeriod
 * @property string $Description
 * @property int $ProjectID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Budget extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'budget';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectID', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['FinancialPeriod'], 'string', 'max' => 45],
			[['Description'], 'string', 'max' => 300],
			[['FinancialPeriod','Description'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'BudgetID' => 'Budget ID',
			'FinancialPeriod' => 'Financial Period',
			'Description' => 'Description',
			'ProjectID' => 'Project ID',
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
