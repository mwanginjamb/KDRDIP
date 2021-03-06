<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lipw_payment_request_lines".
 *
 * @property int $PaymentRequestLineID
 * @property int $PaymentRequestID
 * @property int $WorkRegisterID
 * @property string $Amount
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class LipwPaymentRequestLines extends \yii\db\ActiveRecord
{
	public $BeneficiaryID;
	public $Total;
	public $Name;
	public $Days;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'lipw_payment_request_lines';
	}

	public static function find()
	{
		return parent::find()->andWhere(['lipw_payment_request_lines.Deleted' => 0]);
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
		}
		return parent::save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['PaymentRequestID', 'WorkRegisterID', 'CreatedBy', 'Deleted'], 'integer'],
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
			'PaymentRequestLineID' => 'Payment Request Line ID',
			'PaymentRequestID' => 'Payment Request ID',
			'WorkRegisterID' => 'Work Register ID',
			'Amount' => 'Amount',
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

	public function getLipwWorkRegister()
	{
		return $this->hasOne(LipwWorkRegister::className(), ['WorkRegisterID' => 'WorkRegisterID']);
	}

	public function getBeneficiary()
	{
		return $this->hasOne(LipwBeneficiaries::class,['BeneficiaryID' => 'BeneficaryID']);
	}

	

}
