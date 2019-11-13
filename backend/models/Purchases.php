<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Purchases".
 *
 * @property integer $PurchaseID
 * @property string $CreatedDate
 * @property integer $CreatedBy
 * @property integer $Deleted
 * @property string $Notes
 * @property integer $Posted
 * @property string $PostingDate
 * @property integer $ApprovalStatusID
 * @property integer $SupplierID
 * @property integer $ApprovedBy
 * @property string $ApprovalDate
 * @property integer $Closed
 */
class Purchases extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'purchases';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['CreatedDate', 'PostingDate', 'ApprovalDate'], 'safe'],
			[['CreatedBy', 'Deleted', 'Posted', 'ApprovalStatusID', 'SupplierID', 'ApprovedBy', 'Closed'], 'integer'],
			[['Notes'], 'string'],
		['SupplierID','required'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'PurchaseID' => 'Purchase ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'Notes' => 'Notes',
			'Posted' => 'Posted',
			'PostingDate' => 'Posting Date',
			'ApprovalStatusID' => 'Approval Status',
			'SupplierID' => 'Supplier',
			'Postedstring' => 'Posted',
			'ApprovedBy' => 'Approved By',
			'ApprovalDate' => 'Approval Date',
			'Closed' => 'Closed',
			'ClosedString' => 'Closed',
		];
	}
	
	public function getPostedstring()
	{
		return ($this->Posted == 0) ? 'NO' : 'YES';
	}
	
	public function getClosedstring()
	{
		return ($this->Closed == 0) ? 'NO' : 'YES';
	}
	
	public function getSuppliers()
	{
		return $this->hasOne(Suppliers::className(), ['SupplierID' => 'SupplierID'])->from(suppliers::tableName());
	}

	public function getApprovalstatus()
	{
		return $this->hasOne(ApprovalStatus::className(), ['ApprovalStatusID' => 'ApprovalStatusID'])->from(approvalstatus::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
	
	public function getApprovers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'ApprovedBy'])->from(users::tableName());
	}
	
	public function getPurchaseName()
	{
	   return isset($this->suppliers) ? $this->PurchaseID. ' - ' . $this->suppliers->SupplierName : $this->PurchaseID;
	}
}
