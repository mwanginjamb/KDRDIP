<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cashbook".
 *
 * @property int $CashBookID
 * @property string $Date
 * @property int $TypeID
 * @property int $BankAccountID
 * @property int $AccountID
 * @property string $Description
 * @property string $Debit
 * @property string $Credit
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class CashBook extends \yii\db\ActiveRecord
{
	public $Amount; 
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'cashbook';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Date', 'CreatedDate'], 'safe'],
			[['TypeID', 'BankAccountID', 'AccountID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Description'], 'string'],
			[['Debit', 'Credit'], 'number'],
			[['Date', 'AccountID', 'Amount'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'CashBookID' => 'Cash Book ID',
			'Date' => 'Date',
			'TypeID' => 'Type ID',
			'BankAccountID' => 'Bank Account ID',
			'AccountID' => 'Account',
			'Description' => 'Description',
			'Debit' => 'Debit',
			'Credit' => 'Credit',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'Amount' => 'Amount'
		];
	}
	
	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getAccount()
	{
		return $this->hasOne(BankAccounts::className(), ['BankAccountID' => 'AccountID'])
						->from(['account' => bankaccounts::tableName()]);
	}
}
