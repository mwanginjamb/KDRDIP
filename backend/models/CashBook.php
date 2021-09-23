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
 * @property int $ProjectID
 * @property int $OrganizationID
 * @property int $ProjectDisbursementID
 * @property string $DocumentReference
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
	public $CountyID;
	public $CommunityID;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'cashbook';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'cashbook.Deleted', 0]);
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
			[['Date', 'CreatedDate'], 'safe'],
			[['TypeID', 'BankAccountID', 'AccountID', 'CreatedBy', 'Deleted', 'ProjectID', 'CommunityID', 'CountyID', 'ProjectDisbursementID', 'OrganizationID'], 'integer'],
			[['Description'], 'string'],
			[['Debit', 'Credit', 'Amount'], 'number'],
			[['DocumentReference'], 'string', 'max' => 45],
			[['Amount', 'Date', 'DocumentReference', 'AccountID', 'ProjectDisbursementID'], 'required'],
			['Amount', 'validateAmount'],
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
			'TypeID' => 'Type',
			'BankAccountID' => 'Bank Account',
			'AccountID' => 'Account',
			'DocumentReference' => 'S/No.',
			'Description' => 'Description',
			'Debit' => 'Debit',
			'Credit' => 'Credit',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'ProjectID' => 'Project',
			'CountyID' => 'County',
			'CommunityID' => 'Community',
			'ProjectDisbursementID' => 'Disbursement',
            'OrganizationID' => 'Community Group',
		];
	}

	/**
	 * {@inheritdoc}
	 * Total transfers should not be more than the allocated amount for a particular disbursement
	 */
	public function validateAmount($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$total = $this->totalDisbursement($this->ProjectDisbursementID);
			$paid = $this->paidDisbursement($this->ProjectDisbursementID);
			$expectedPaid = $paid + $this->Amount;
			if ($expectedPaid > $total) {
				// $this->addError($attribute, 'Amount Exceeds Expected Disbursement');
			}
		}
	}

	public static function totalDisbursement($id)
	{
		$model = ProjectDisbursement::findOne($id);
		if (!empty($model)) {
			return $model->Amount;
		}
		return 0;
	}

	public static function paidDisbursement($id)
	{
		return CashBook::find()->where(['ProjectDisbursementID' => $id])->sum('Credit');
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getProjects()
	{
		return $this->hasOne(Projects::className(), ['ProjectID' => 'ProjectID'])->from(projects::tableName());
	}

	public function getProjectDisbursement()
	{
		return $this->hasOne(ProjectDisbursement::className(), ['ProjectDisbursementID' => 'ProjectDisbursementID'])->from(projectdisbursement::tableName());
	}

	public function getAccount()
	{
		return $this->hasOne(BankAccounts::className(), ['bankaccounts.BankAccountID' => 'AccountID']);
	}
}
