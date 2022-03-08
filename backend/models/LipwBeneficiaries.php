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
 * @property int $Principal
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
			[['AlternativeID', 'HouseholdID', 'BankID', 'BankBranchID', 'CreatedBy', 'Deleted', 'BeneficiaryTypeID', 'Principal'], 'integer'],
			[['FirstName', 'MiddleName', 'LastName', 'Mobile','BankAccountName'], 'string', 'max' => 45],
			[['Gender'], 'string', 'max' => 1],
			[['BankAccountNumber','IDNumber'],'safe'],
			['IDNumber', 'is8NumbersOnly'],
			[['FirstName', 'LastName', 'IDNumber', 'Mobile', 'DateOfBirth', 'Gender'], 'required'],
			['BeneficiaryTypeID', 'validateBeneficiatyType'],
			['Mobile','unique'],
			['Mobile','isMobile'],

		];
	}


	public function is8NumbersOnly($attribute)
	{
		if (!preg_match('/^[0-9]{8}$/', $this->$attribute)) {
			$this->addError($attribute, 'must contain exactly 8 digits.');
		}
	}

	public function isMobile($attribute)
	{
		if (!preg_match('/^[0-9]{10}$/', $this->$attribute)) {
			$this->addError($attribute, $attribute.'must contain exactly 10 digits.');
		}
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
			'AlternativeID' => 'Alternate Beneficiary',
			'HouseholdID' => 'Household',
			'BankAccountNumber' => 'Bank Account Number',
			'BankAccountName' => 'Bank Account Name',
			'BankID' => 'Bank',
			'BankBranchID' => 'Branch',
			'Principal' => 'Principal',
			'BeneficiaryTypeID' => 'Beneficiary Type',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

		/**
	 * {@inheritdoc}
	 * Total transfers should not be more than the allocated amount for a particular disbursement
	 */
	public function validateBeneficiatyType($attribute, $params)
	{
		if (!$this->hasErrors()) {
			if ($this->BeneficiaryTypeID == 1) {
				if ($this->getAge() > 70) {
					$this->addError($attribute, 'The Beneficiary is not eligible Age is more than 70');
				} elseif ($this->getAge() < 18) {
					$this->addError($attribute, 'The Beneficiary is not eligible Age is less than 18');
				}
			}
		}
		if (!$this->hasErrors()) {
			if ($this->BeneficiaryTypeID == 1) {
				$m = LipwHouseholds::findOne($this->HouseholdID);
				$total = !empty($m) ? $m->TotalBeneficiaries : 0;
				if ($this->isNewRecord) {
					$total ++;
				}
				if ($this->BeneficiaryID) {
					$eligible = parent::find()->andWhere(['HouseholdID' => $this->HouseholdID, 'BeneficiaryTypeID' => 1])->andWhere('BeneficiaryID <> ' . $this->BeneficiaryID)->count();
				} else {
					$eligible = parent::find()->andWhere(['HouseholdID' => $this->HouseholdID, 'BeneficiaryTypeID' => 1])->count();
				}
				$total = ($total) ? $total : 0;
				if ($total <= 5 && $eligible >= 1) {
					$this->addError($attribute, 'Your Household is only allowed 1 (One) Eligible Beneficiary');
				} elseif ($total > 5 && $total <= 10 && $eligible >= 2) {
					$this->addError($attribute, 'Your Household is only allowed 2 (Two) Eligible Beneficiary');
				} elseif ($total > 10 && $eligible >= 3) {
					$this->addError($attribute, 'Your Household is only allowed 3 (Three) Eligible Beneficiary');
				}
			}
		}
	}

	public function getBeneficiaryName()
	{
		return $this->FirstName . ' ' . $this->MiddleName . ' ' . $this->LastName;
	}

	public function getAge()
	{
		$diff = date_diff(date_create($this->DateOfBirth), date_create());
		return $diff->y;
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

	public function getLipwBeneficiaryTypes()
	{
		return $this->hasOne(LipwBeneficiaryTypes::className(), ['BeneficiaryTypeID' => 'BeneficiaryTypeID']);
	}
}
