<?php

namespace app\models;

use Yii;
use app\models\LipwPaymentRequestLines;

/**
 * This is the model class for table "lipw_payment_request".
 *
 * @property int $PaymentRequestID
 * @property int $MasterRollID
 * @property string $StartDate
 * @property string $EndDate
 * @property int $PaymentRequestStatusID
 * @property string $Total
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 * @property int $Posted
 * @property string $PostingDate
 * @property int ApprovalStatusID
 * @property int ApprovalStatusID
 * @property string ApprovalDate
 */

class LipwPaymentRequest extends \yii\db\ActiveRecord
{
	public $submit;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'lipw_payment_request';
	}

	public static function find()
	{
		return parent::find()->andWhere(['lipw_payment_request.Deleted' => 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		// $m->deletedTime = time();
		return $m->save();
	}

	public function save($runValidation = true, $attributeNames = null)
	{
		//this record is always new
		if ($this->isNewRecord) {
			$this->CreatedBy = Yii::$app->user->identity->UserID;
			$this->CreatedDate = date('Y-m-d h:i:s');
			$this->PaymentRequestStatusID = 1;
			$this->ApprovalStatusID = 0;
		}
		return parent::save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['MasterRollID', 'PaymentRequestStatusID', 'CreatedBy', 'Deleted', 'Posted', 'ApprovalStatusID', 'ApprovedBy'], 'integer'],
			[['StartDate', 'EndDate', 'CreatedDate', 'PostingDate', 'ApprovalDate'], 'safe'],
			[['Notes'], 'string'],
			[['Total'], 'number'],
			[['MasterRollID', 'StartDate', 'EndDate'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'PaymentRequestID' => 'Payment Request ID',
			'MasterRollID' => 'Master Roll ID',
			'StartDate' => 'Start Date',
			'EndDate' => 'End Date',
			'PaymentRequestStatusID' => 'Payment Request Status',
			'Total' => 'Total',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'Posted' => 'Posted',
			'PostingDate' => 'Posting Date',
			'ApprovalStatusID' => 'Approval Status',
			'ApprovedBy' => 'Approved By',
			'ApprovalDate' => 'Approval Date',
		];
	}

	public function getTransferStatus()
	{
		$pending = LipwPaymentSchedule::find()->andWhere(['PaymentRequestID' => $this->PaymentRequestID, 'PaymentScheduleStatusID' => 1])->count();
		return ($pending > 0) ? 1 : 2;
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
	}

	public function getLipwMasterRoll()
	{
		return $this->hasOne(LipwMasterRoll::className(), ['MasterRollID' => 'MasterRollID']);
	}

	public function getLipwPaymentRequestStatus()
	{
		return $this->hasOne(LipwPaymentRequestStatus::className(), ['PaymentRequestStatusID' => 'PaymentRequestStatusID']);
	}

	public function getCalculatedTotal()
	{
		return LipwPaymentRequestLines::find()->andWhere(['PaymentRequestID' =>  $this->PaymentRequestID])->sum('Amount');
	}

	public function getApprover()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'ApprovedBy']);
	}

	public function getApprovalStatus()
	{
		return $this->hasOne(ApprovalStatus::className(), ['ApprovalStatusID' => 'ApprovalStatusID']);
	}
}
