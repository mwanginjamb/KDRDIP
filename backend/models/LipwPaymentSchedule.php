<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lipw_payment_schedule".
 *
 * @property int $PaymentScheduleID
 * @property int $PaymentRequestID
 * @property int $BeneficiaryID
 * @property string $Amount
 * @property int $PaymentScheduleStatusID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class LipwPaymentSchedule extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'lipw_payment_schedule';
	}

	public static function find()
	{
		return parent::find()->andWhere(['lipw_payment_schedule.Deleted' => 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->deleted = 1;
		$m->deletedTime = time();
		return $m->save();
	}

	public function save($runValidation = true, $attributeNames = null)
	{
		//this record is always new
		if ($this->isNewRecord) {
			$this->CreatedBy = Yii::$app->user->identity->UserID;
			$this->CreatedDate = date('Y-m-d h:i:s');
		}
		return parent::save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['PaymentRequestID', 'BeneficiaryID', 'PaymentScheduleStatusID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Amount'], 'number'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'PaymentScheduleID' => 'Payment Schedule ID',
			'PaymentRequestID' => 'Payment Request ID',
			'BeneficiaryID' => 'Beneficiary ID',
			'Amount' => 'Amount',
			'PaymentScheduleStatusID' => 'Payment Schedule Status ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
	}

	public function getLipwPaymentRequest()
	{
		return $this->hasOne(LipwPaymentRequest::className(), ['PaymentRequestID' => 'PaymentRequestID']);
	}

	public function getLipwBeneficiaries()
	{
		return $this->hasOne(LipwBeneficiaries::className(), ['BeneficiaryID' => 'BeneficiaryID']);
	}

	public function getLipwPaymentScheduleStatus()
	{
		return $this->hasOne(LipwPaymentScheduleStatus::className(), ['PaymentScheduleStatusID' => 'PaymentScheduleStatusID']);
	}
}
