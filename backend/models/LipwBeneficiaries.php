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
 * @property int $HouseholdID
 * @property string $BankAccountNumber
 * @property string $BankAccountName
 * @property int $BankID
 * @property int $BankBranchID
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

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		// $m->deletedTime = time();
		return $m->save();
	}

	public function save($runValidation = true, $attributeNames = null)
	{
		//this record is always new
		if ($this->isNewRecord) {
			$this->CreatedBy = Yii::$app->user->identity->UserID;
			$this->CreatedDate = date('Y-m-d h:i:s');
		}
		return parent::save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['DateOfBirth', 'CreatedDate'], 'safe'],
			[['AlternativeID', 'HouseholdID', 'BankID', 'BankBranchID', 'CreatedBy', 'Deleted'], 'integer'],
			[['FirstName', 'MiddleName', 'LastName', 'IDNumber', 'Mobile', 'BankAccountNumber', 'BankAccountName'], 'string', 'max' => 45],
			[['Gender'], 'string', 'max' => 1],
			[['FirstName', 'LastName', 'IDNumber', 'Mobile', 'DateOfBirth', 'Gender'], 'required']
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
			'IDNumber' => 'ID Number',
			'Mobile' => 'Mobile',
			'Gender' => 'Gender',
			'DateOfBirth' => 'Date Of Birth',
			'AlternativeID' => 'Alternative',
			'HouseholdID' => 'Household',
			'BankAccountNumber' => 'Bank Account Number',
			'BankAccountName' => 'Bank Account Name',
			'BankID' => 'Bank',
			'BankBranchID' => 'Branch',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getBeneficiaryName()
	{
		return $this->FirstName . ' ' . $this->MiddleName . ' ' . $this->LastName;
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
	}

	public function getLipwHouseHolds()
	{
		return $this->hasOne(LipwHouseholds::className(), ['HouseholdID' => 'HouseholdID']);
	}

	public function getBanks()
	{
		return $this->hasOne(Banks::className(), ['BankID' => 'BankID']);
	}

	public function getBankBranches()
	{
		return $this->hasOne(BankBranches::className(), ['BankBranchID' => 'BankBranchID']);
	}

	public function getLipwMasterRollRegister()
	{
		return $this->hasOne(LipwMasterRollRegister::className(), ['BeneficiaryID' => 'BeneficiaryID']);
	}
}
