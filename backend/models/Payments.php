<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property int $PaymentID
 * @property string $Date
 * @property int $SupplierID
 * @property int $PaymentMethodID
 * @property string $Amount
 * @property string $RefNumber
 * @property string $Description
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Payments extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'payments';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Date', 'CreatedDate'], 'safe'],
			[['SupplierID', 'PaymentMethodID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Amount'], 'number'],
			[['RefNumber'], 'string', 'max' => 45],
			[['Description'], 'string', 'max' => 500],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'PaymentID' => 'Payment ID',
			'Date' => 'Date',
			'SupplierID' => 'Supplier ID',
			'PaymentMethodID' => 'Payment Method ID',
			'Amount' => 'Amount',
			'RefNumber' => 'Ref Number',
			'Description' => 'Description',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getPaymentMethods()
	{
		return $this->hasOne(PaymentMethods::className(), ['PaymentMethodID' => 'PaymentMethodID'])->from(paymentmethods::tableName());
	}

	public function getSuppliers()
	{
		return $this->hasOne(Suppliers::className(), ['SupplierID' => 'SupplierID'])->from(suppliers::tableName());
	}
}
