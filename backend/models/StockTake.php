<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "StockTake".
 *
 * @property integer $StockTakeID
 * @property string $CreatedDate
 * @property integer $CreatedBy
 * @property string $Notes
 */
class StockTake extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'stocktake';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['CreatedDate', 'PostingDate'], 'safe'],
			[['CreatedBy', 'CompanyID', 'Posted', 'ApprovalStatusID'], 'integer'],
			[['Notes', 'Reason'], 'string'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'StockTakeID' => 'Stock Take ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Notes' => 'Notes',
			'Reason' => 'Reason',
			'CompanyID' => 'CompanyID',
			'Posted' => 'Posted',
			'PostingDate' => 'Posting Date',
			'ApprovalStatusID' => 'Approval Status ID',
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
}
