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
 * @property int $PaymentTypeID
 * @property int $ProjectID
 * @property int $ProcurementPlanLineID
 * @property string $Amount
 * @property string $RefNumber
 * @property string $Description
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 * @property string $Supplier
 * @property string $InvoiceNumber
 * @property string $InvoiceDate
 */
class Payments extends \yii\db\ActiveRecord
{
	public $imageFile;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'payments';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'payments.Deleted', 0]);
	}

	/*public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		// $m->deletedTime = time();
		return $m->save();
	}*/

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Date', 'CreatedDate', 'InvoiceDate'], 'safe'],
			[['SupplierID', 'InvoiceID', 'PaymentMethodID', 'CreatedBy', 'Deleted', 'BankAccountID', 'PaymentTypeID', 'ProcurementPlanLineID', 'ProjectID'], 'integer'],
			[['Amount'], 'number'],
			[['RefNumber', 'InvoiceNumber'], 'string', 'max' => 45],
			[['Supplier'], 'string', 'max' => 300],
			[['Description'], 'string', 'max' => 500],
			[[ 'PaymentMethodID', 'Amount', 'Date', 'BankAccountID', 'PaymentTypeID', 'ProcurementPlanLineID', 'ProjectID', 'InvoiceDate', 'InvoiceNumber', 'Supplier'], 'required'],
			[['Amount'], 'validateAmount'],
			[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf'],
		// 	[['SupplierID', 'InvoiceID',], 'required', 'when' => function($model) {
		// 		return $model->PaymentTypeID == 1;
		//   }]
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'PaymentID' => 'Payment Voucher Number',
			'Date' => 'Date',
			'SupplierID' => 'Supplier',
			'InvoiceID' => 'Invoice Number',
			'PaymentMethodID' => 'Payment Method',
			'PaymentTypeID' => 'Payment Type',
			'ProcurementPlanLineID' => 'Procurement Plan Line',
			'ProjectID' => 'Sub-Project',
			'Amount' => 'Amount',
			'RefNumber' => 'Ref Number',
			'BankAccountID' => 'Bank Account',
			'Description' => 'Description',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
            'Supplier' => 'Supplier',
            'InvoiceNumber' => 'Invoice Number',
            'InvoiceDate' => 'Invoice Date',
		];
	}

	public function formatImage()
	{
		$tmpfile_contents = file_get_contents($this->imageFile->tempName);
		$type = $this->imageFile->type;
		return 'data:' . $type . ';base64,' . base64_encode($tmpfile_contents);
	}

	public function validateAmount($attribute, $params)
	{
		// print_r($this->ApprovalStatusID); exit;
		if ($this->ApprovalStatusID < 1) {
			// no real check at the moment to be sure that the error is triggered
			$invoiceAmount = Invoices::find()->where(['InvoiceID' => $this->InvoiceID])->sum('Amount');
			$totalPayments = Payments::find()->where(['InvoiceID' => $this->InvoiceID])->sum('Amount');
			if (($invoiceAmount - $totalPayments) < $this->Amount) {
				// $this->addError($attribute, 'The Amount is more than the invoice amount');
			}
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

	public function getProjects()
	{
		return $this->hasOne(Projects::className(), ['ProjectID' => 'ProjectID'])->from(projects::tableName());
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

	public function getApprovers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'ApprovedBy'])->from(users::tableName());
	}

	public function getApprovalstatus()
	{
		return $this->hasOne(ApprovalStatus::className(), ['ApprovalStatusID' => 'ApprovalStatusID'])->from(approvalstatus::tableName());
	}
}
