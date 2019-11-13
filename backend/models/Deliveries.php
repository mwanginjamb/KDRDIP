<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Deliveries".
 *
 * @property integer $DeliveryID
 * @property string $CreatedDate
 * @property integer $CreatedBy
 * @property integer $PurchaseID
 * @property string $DeliveryNoteNumber
 * @property string $Notes
 * @property integer $CompanyID
 * @property integer $Posted
 * @property string $PostingDate
 * @property integer $ApprovalStatusID
 */
class Deliveries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deliveries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CreatedDate', 'PostingDate'], 'safe'],
            [['CreatedBy', 'PurchaseID', 'CompanyID', 'Posted', 'ApprovalStatusID'], 'integer'],
            [['DeliveryNoteNumber', 'Notes'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DeliveryID' => 'Delivery ID',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'PurchaseID' => 'Purchase Order No.',
            'DeliveryNoteNumber' => 'Delivery Note Number',
            'Notes' => 'Notes',
            'CompanyID' => 'Company ID',
            'Posted' => 'Posted',
            'PostingDate' => 'Posting Date',
            'ApprovalStatusID' => 'Approval Status ID',
        ];
    }
	
	public function getPurchases() 
	{
        return $this->hasOne(Purchases::className(), ['PurchaseID' => 'PurchaseID'])->from(Purchases::tableName());
    }
	
	public function getUsers() 
	{
        return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
    }

	public function getApprovalstatus() 
	{
        return $this->hasOne(Approvalstatus::className(), ['ApprovalStatusID' => 'ApprovalStatusID'])->from(approvalstatus::tableName());
    }
	
	public function getPostedName()
	{
	   return $this->Posted ? 'True' : 'False';
	}
	
	public function getApprovers() 
	{
        return $this->hasOne(Users::className(), ['UserID' => 'ApprovedBy'])->from(users::tableName());
    }	
}
