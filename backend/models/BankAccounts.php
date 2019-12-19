<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bankaccounts".
 *
 * @property int $BankAccountID
 * @property int $BankID
 * @property int $BranchID
 * @property string $AccountName
 * @property string $AccountNumber
 * @property int $BankTypeID
 * @property int $CountyID
 * @property int $CommunityID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class BankAccounts extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'bankaccounts';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['BankID', 'BranchID', 'BankTypeID', 'CountyID', 'CommunityID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['AccountName', 'AccountNumber'], 'string', 'max' => 45],
			[['AccountName', 'AccountNumber', 'BankID', 'BranchID', 'BankTypeID' ], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'BankAccountID' => 'Bank Account ID',
			'BankID' => 'Bank',
			'BranchID' => 'Branch',
			'AccountName' => 'Account Name',
			'AccountNumber' => 'Account Number',
			'BankTypeID' => 'Bank Type',
			'CountyID' => 'County',
			'CommunityID' => 'Community',
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
	
	public function getBanks()
	{
		return $this->hasOne(Banks::className(), ['BankID' => 'BankID'])->from(banks::tableName());
	}
	
	public function getBankBranches()
	{
		return $this->hasOne(BankBranches::className(), ['BankBranchID' => 'BranchID'])->from(bankbranches::tableName());
	}

	public function getCommunities()
	{
		return $this->hasOne(Communities::className(), ['CommunityID' => 'CommunityID'])->from(communities::tableName());
	}

	public function getCounties()
	{
		return $this->hasOne(Counties::className(), ['CountyID' => 'CountyID'])->from(counties::tableName());
	}
}
