<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ApprovalStatus".
 *
 * @property integer $ApprovalStatusID
 * @property string $ApprovalStatusName
 * @property string $CreatedDate
 * @property integer $CreatedBy
 * @property integer $Deleted
 * @property integer $ApprovalTypeID
 * @property integer $ApproverTypeID
 * @property integer $Approver
 */
class ApprovalStatus extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'approvalstatus';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['ApprovalStatusName'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted', 'ApprovalTypeID', 'ApproverTypeID', 'Approver'], 'integer'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'ApprovalStatusID' => 'Approval Status ID',
			'ApprovalStatusName' => 'Approval Status',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'ApprovalTypeID' => 'Approval Type ID',
			'ApproverTypeID' => 'Approver Type ID',
			'Approver' => 'Approver',
		];
	}
}
