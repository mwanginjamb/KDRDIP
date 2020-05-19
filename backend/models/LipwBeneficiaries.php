<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lipw_beneficiaries".
 *
 * @property int $BeneficiaryID
 * @property string $FirstName
 * @property string $MiddleName
 * @property string $LastName
 * @property string $IDNumber
 * @property string $Mobile
 * @property string $Gender
 * @property string $DateOfBirth
 * @property int $AlternativeID
 * @property int $HouseHoldID
 * @property string $BankAccountNumber
 * @property string $BankAccountName
 * @property int $BankID
 * @property int $BranchID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class LipwBeneficiaries extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'lipw_beneficiaries';
	}

	public static function find()
	{
		return parent::find()->andWhere(['lipw_beneficiaries.Deleted' => 0]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['DateOfBirth', 'CreatedDate'], 'safe'],
			[['AlternativeID', 'HouseHoldID', 'BankID', 'BranchID', 'CreatedBy', 'Deleted'], 'integer'],
			[['FirstName', 'MiddleName', 'LastName', 'IDNumber', 'Mobile', 'BankAccountNumber', 'BankAccountName'], 'string', 'max' => 45],
			[['Gender'], 'string', 'max' => 1],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'BeneficiaryID' => 'Beneficiary ID',
			'FirstName' => 'First Name',
			'MiddleName' => 'Middle Name',
			'LastName' => 'Last Name',
			'IDNumber' => 'Id Number',
			'Mobile' => 'Mobile',
			'Gender' => 'Gender',
			'DateOfBirth' => 'Date Of Birth',
			'AlternativeID' => 'Alternative ID',
			'HouseHoldID' => 'House Hold ID',
			'BankAccountNumber' => 'Bank Account Number',
			'BankAccountName' => 'Bank Account Name',
			'BankID' => 'Bank ID',
			'BranchID' => 'Branch ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
	}

	public function getLipwHouseHolds()
	{
		return $this->hasOne(LipwHouseHolds::className(), ['HouseHoldID' => 'HouseHoldID']);
	}

	public function getBanks()
	{
		return $this->hasOne(Banks::className(), ['BankID' => 'BankID']);
	}

	public function getBankBranches()
	{
		return $this->hasOne(BankBranches::className(), ['BranchID' => 'BranchID']);
	}
}
