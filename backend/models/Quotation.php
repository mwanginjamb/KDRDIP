<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Quotation".
 *
 * @property integer $QuotationID
 * @property integer $RequisitionID
 * @property string $CreatedDate
 * @property integer $CreatedBy
 * @property string $Description
 * @property integer ApprovalStatusID
 * @property string ApprovalDate
 * @property string StartDate
 * @property string ExpiryDate
 * @property integer ApprovedBy
 * @property string Notes
 */
class Quotation extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'quotation';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['CreatedDate', 'ApprovalDate', 'StartDate', 'ExpiryDate'], 'safe'],
			[['CreatedBy', 'ApprovalStatusID', 'ApprovedBy', 'RequisitionID'], 'integer'],
			[['Description', 'Notes'], 'string'],
			[['Description', 'RequisitionID'], 'required'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'QuotationID' => 'Quotation ID',
			'RequisitionID' => 'Requisition',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Description' => 'Description',
			'ApprovalStatusID' => 'Status',
			'ApprovalDate' => 'Approval Date',
			'StartDate' => 'Start Date',
			'ExpiryDate' => 'Expiry Date',
			'ApprovedBy' => 'Approved By',
			'Notes' => 'Notes',
		];
	}

	public function getApprovers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'ApprovedBy'])->from(users::tableName());
	}

	public function getApprovalstatus()
	{
		return $this->hasOne(ApprovalStatus::className(), ['ApprovalStatusID' => 'ApprovalStatusID'])->from(approvalstatus::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getRequisition()
	{
		return $this->hasOne(Requisition::className(), ['RequisitionID' => 'RequisitionID'])->from(requisition::tableName());
	}
}
