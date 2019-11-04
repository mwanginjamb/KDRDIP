<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Quotation".
 *
 * @property integer $QuotationID
 * @property string $CreatedDate
 * @property integer $CreatedBy
 * @property string $Description
 * @property integer ApprovalStatusID
 * @property string ApprovalDate
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
			[['CreatedDate', 'ApprovalDate'], 'safe'],
			[['CreatedBy', 'ApprovalStatusID', 'ApprovedBy'], 'integer'],
			[['Description', 'Notes'], 'string'],
			[['Description'], 'required'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'QuotationID' => 'Quotation ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Description' => 'Description',
		'ApprovalStatusID' => 'Status',
		'ApprovalDate' => 'Approval Date',
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
}
