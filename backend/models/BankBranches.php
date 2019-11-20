<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bankbranches".
 *
 * @property int $BankBranchID
 * @property string $BankBranchName
 * @property int $BankID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class BankBranches extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'bankbranches';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['BankID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['BankBranchName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'BankBranchID' => 'Bank Branch ID',
			'BankBranchName' => 'Bank Branch Name',
			'BankID' => 'Bank ID',
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
}
