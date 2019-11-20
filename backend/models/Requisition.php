<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Requisition".
 *
 * @property integer $RequisitionID
 * @property string $CreatedDate
 * @property integer $CreatedBy
 * @property integer $Deleted
 * @property string $Notes
 * @property integer $Posted
 * @property string $PostingDate
 * @property integer $ApprovalStatusID
 * @property integer $StoreID
 */
class Requisition extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'requisition';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['CreatedDate', 'PostingDate'], 'safe'],
			[['CreatedBy', 'Deleted', 'Posted', 'ApprovalStatusID', 'StoreID'], 'integer'],
			[['Notes'], 'string'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'RequisitionID' => 'Requisition ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'Notes' => 'Notes',
			'Posted' => 'Posted',
			'PostingDate' => 'Posting Date',
			'ApprovalStatusID' => 'Approval Status',
		'StoreID' => 'Store',
		];
	}
	
	public function getApprovalstatus()
	{
		return $this->hasOne(ApprovalStatus::className(), ['ApprovalStatusID' => 'ApprovalStatusID'])->from(approvalstatus::tableName());
	}
	
	public function getUsers() 
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getStores() 
	{
		return $this->hasOne(Stores::className(), ['StoreID' => 'StoreID'])->from(Stores::tableName());
	}
}
