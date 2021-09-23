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
 * @property integer $ProjectID
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

	public static function find()
	{
		return parent::find()->andWhere(['=', 'requisition.Deleted', 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		// $m->deletedTime = time();
		return $m->save();
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['CreatedDate', 'PostingDate'], 'safe'],
			[['CreatedBy', 'Deleted', 'Posted', 'ApprovalStatusID', 'StoreID', 'ProjectID'], 'integer'],
			[['Notes', 'Description'], 'string'],
			[['Description', 'ProjectID'], 'required'],
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
			'Description' => 'Description',
			'ProjectID' => 'Sub Project',
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
		return $this->hasOne(Stores::className(), ['StoreID' => 'StoreID'])->from(stores::tableName());
	}

	public function getProjects()
	{
		return $this->hasOne(Projects::className(), ['ProjectID' => 'ProjectID'])->from(projects::tableName());
	}
}
