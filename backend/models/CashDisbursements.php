<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cash_disbursements".
 *
 * @property int $CashDisbursementID
 * @property string $DisbursementDate
 * @property string $SerialNumber
 * @property int $CountyID
 * @property int $DisbursementTypeID
 * @property int $OrganizationID
 * @property int $CommunityID
 * @property int $ProjectID
 * @property string $Description
 * @property int $SourceAccountID
 * @property int $DestinationAccountID
 * @property string $Amount
 * @property int $Posted
 * @property string $PostingDate
 * @property int $ApprovalStatusID
 * @property int $ApprovedBy
 * @property string $ApprovalDate
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted

 */
class CashDisbursements extends \yii\db\ActiveRecord
{
	public $imageFile;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'cash_disbursements';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['DisbursementDate', 'SerialNumber', 'CountyID', 'DisbursementTypeID'], 'required'],
			[['DisbursementDate', 'PostingDate', 'ApprovalDate', 'CreatedDate'], 'safe'],
			[
                ['CountyID', 'CommunityID', 'ProjectID', 'SourceAccountID', 'DestinationAccountID', 
                    'Posted', 'ApprovalStatusID', 'ApprovedBy', 'CreatedBy', 'Deleted', 'DisbursementTypeID',
                    'OrganizationID'
                ], 'integer'
            ],
			[['Description'], 'string'],
			[['Amount'], 'number'],
			[['SerialNumber'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'CashDisbursementID' => 'Cash Disbursement ID',
			'DisbursementDate' => 'Date',
			'SerialNumber' => 'Serial Number',
			'CountyID' => 'County',
			'CommunityID' => 'Community',
            'OrganizationID' => 'Organization',
            'DisbursementTypeID' => 'Disbursement Type',
			'ProjectID' => 'Project',
			'Description' => 'Description',
			'SourceAccountID' => 'Source Account',
			'DestinationAccountID' => 'Destination Account',
			'Amount' => 'Amount',
			'Posted' => 'Posted',
			'PostingDate' => 'Posting Date',
			'ApprovalStatusID' => 'Approval Status',
			'ApprovedBy' => 'Approved By',
			'ApprovalDate' => 'Approval Date',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function formatImage()
	{
		$tmpfile_contents = file_get_contents($this->imageFile->tempName);
		$type = $this->imageFile->type;
		return 'data:' . $type . ';base64,' . base64_encode($tmpfile_contents);
	}

	public static function paidDisbursement($id)
	{
		return CashBook::find()->where(['ProjectDisbursementID' => $id])->sum('Credit');
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getApprovedByusers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'ApprovedBy'])->from(['approvedByuser' => users::tableName()]);
	}	

	public function getProjects()
	{
		return $this->hasOne(Projects::className(), ['ProjectID' => 'ProjectID'])->from(projects::tableName());
	}	

	public function getCommunities()
	{
		return $this->hasOne(Communities::className(), ['CommunityID' => 'CommunityID']);
	}

	public function getCounties()
	{
		return $this->hasOne(Counties::className(), ['CountyID' => 'CountyID']);
	}

	public function getProjectDisbursement()
	{
		return $this->hasOne(ProjectDisbursement::className(), ['ProjectDisbursementID' => 'ProjectDisbursementID'])->from(projectdisbursement::tableName());
	}

	public function getSourceBankAccount()
	{
		return $this->hasOne(BankAccounts::className(), ['BankAccountID' => 'SourceAccountID'])->from(['sourceaccount' => bankaccounts::tableName()]);
	}

	public function getDestinationBankAccount()
	{
		return $this->hasOne(BankAccounts::className(), ['BankAccountID' => 'DestinationAccountID'])->from(['destinationaccount' => bankaccounts::tableName()]);
	}
	
	public function getApprovalstatus()
	{
		return $this->hasOne(ApprovalStatus::className(), ['ApprovalStatusID' => 'ApprovalStatusID'])->from(approvalstatus::tableName());
	}

    public function getDisbursementTypes()
	{
		return $this->hasOne(DisbursementTypes::className(), ['DisbursementTypeID' => 'DisbursementTypeID']);
	}

    public function getOrganizations()
	{
		return $this->hasOne(Organizations::className(), ['OrganizationID' => 'OrganizationID']);
	}

    public function getRecipientName() {
       if ($this->DisbursementTypeID == 1) {
            $model = Projects::findOne($this->ProjectID);
            return ($model) ? $model->ProjectName : '';
        } elseif ($this->DisbursementTypeID == 2) {
            $model = Organizations::findOne($this->OrganizationID);
            return ($model) ? $model->OrganizationName : '';
        } elseif ($this->DisbursementTypeID == 3) {
            $model = Counties::findOne($this->CountyID);
            return ($model) ? $model->CountyName : '';
        }
    }
}
