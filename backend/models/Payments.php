<?php

namespace app\models;

use app\models\Invoices;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property int $PaymentID
 * @property string $Date
 * @property int $SupplierID
 * @property int $InvoiceID
 * @property int $PaymentMethodID
 * @property int $BankAccountID
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
			[['SupplierID', 'InvoiceID', 'PaymentMethodID', 'CreatedBy', 'Deleted', 'BankAccountID'], 'integer'],
			[['Amount'], 'number'],
			[['RefNumber'], 'string', 'max' => 45],
			[['Description'], 'string', 'max' => 500],
			[['SupplierID', 'InvoiceID', 'PaymentMethodID', 'Amount', 'Date' ], 'required'],
			[['Amount'], 'validateAmount']
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
			'SupplierID' => 'Supplier',
			'InvoiceID' => 'Invoice Number',
			'PaymentMethodID' => 'Payment Method',
			'Amount' => 'Amount',
			'RefNumber' => 'Ref Number',
			'BankAccountID' => 'Bank Account',
			'Description' => 'Description',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function validateAmount($attribute, $params)
	{
		// print_r($attribute); exit;
		// no real check at the moment to be sure that the error is triggered
		$invoiceAmount = Invoices::find()->where(['InvoiceID' => $this->InvoiceID])->sum('Amount');
		$totalPayments = Payments::find()->where(['InvoiceID' => $this->InvoiceID])->sum('Amount');
		if (($invoiceAmount - $totalPayments) < $this->Amount) {
			$this->addError($attribute, 'The Amount is more than the invoice amount');
		}
	}

	public function getPaymentMethods()
	{
		return $this->hasOne(PaymentMethods::className(), ['PaymentMethodID' => 'PaymentMethodID'])->from(paymentmethods::tableName());
	}

	public function getSuppliers()
	{
		return $this->hasOne(Suppliers::className(), ['SupplierID' => 'SupplierID'])->from(suppliers::tableName());
	}

	public function getInvoices()
	{
		return $this->hasOne(Invoices::className(), ['InvoiceID' => 'InvoiceID'])->from(invoices::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getBankAccounts()
	{
		return $this->hasOne(BankAccounts::className(), ['BankAccountID' => 'BankAccountID'])->from(bankaccounts::tableName());
	}
}
