<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectfunding".
 *
 * @property int $ProjectFundingID
 * @property int $ProjectID
 * @property int $FundingSourceID
 * @property int $BaseCurrencyID
 * @property int $CurrencyID
 * @property string $Rate
 * @property string $Amount
 * @property string $BaseAmount
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectFunding extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'projectfunding';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectID', 'FundingSourceID', 'BaseCurrencyID', 'CurrencyID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Rate', 'Amount', 'BaseAmount'], 'number'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectFundingID' => 'Project Funding ID',
			'ProjectID' => 'Project ID',
			'FundingSourceID' => 'Funding Source ID',
			'BaseCurrencyID' => 'Base Currency ID',
			'CurrencyID' => 'Currency ID',
			'Rate' => 'Rate',
			'Amount' => 'Amount',
			'BaseAmount' => 'Base Amount',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getFundingSources()
	{
		return $this->hasOne(FundingSources::className(), ['FundingSourceID' => 'FundingSourceID'])->from(fundingsources::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getCurrencies()
	{
		return $this->hasOne(Currencies::className(), ['CurrencyID' => 'CurrencyID'])->from(currencies::tableName());
	}
}
