<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "storerequisition".
 *
 * @property int $StoreRequisitionID
 * @property string $Notes
 * @property int $Posted
 * @property string $PostingDate
 * @property int $ApprovalStatusID
 * @property int $CompanyID
 * @property string $ApprovalDate
 * @property int $ApprovedBy
 * @property int $StoreID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class StoreRequisition extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'storerequisition';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Notes'], 'string'],
			[['Posted', 'ApprovalStatusID', 'CompanyID', 'ApprovedBy', 'StoreID', 'CreatedBy', 'Deleted'], 'integer'],
			[['PostingDate', 'ApprovalDate', 'CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'StoreRequisitionID' => 'Store Requisition ID',
			'Notes' => 'Notes',
			'Posted' => 'Posted',
			'PostingDate' => 'Posting Date',
			'ApprovalStatusID' => 'Approval Status ID',
			'CompanyID' => 'Company ID',
			'ApprovalDate' => 'Approval Date',
			'ApprovedBy' => 'Approved By',
			'StoreID' => 'Store ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	
	public function getApprovalstatus()
	{
		return $this->hasOne(Approvalstatus::className(), ['ApprovalStatusID' => 'ApprovalStatusID'])->from(approvalstatus::tableName());
	}
	
	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getStores()
	{
		return $this->hasOne(Stores::className(), ['StoreID' => 'StoreID'])->from(stores::tableName());
	}
}
