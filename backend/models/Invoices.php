<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoices".
 *
 * @property int $InvoiceID
 * @property int $SupplierID
 * @property int $PurchaseID
 * @property string $InvoiceNumber
 * @property string $InvoiceDate
 * @property string $Amount
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */
class Invoices extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'invoices';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['SupplierID', 'PurchaseID', 'CreatedBy', 'Deleted'], 'integer'],
			[['InvoiceDate', 'CreatedDate'], 'safe'],
			[['Amount'], 'number'],
			[['InvoiceNumber'], 'string', 'max' => 45],
			[['SupplierID', 'PurchaseID', 'InvoiceNumber', 'Amount', 'InvoiceDate'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'InvoiceID' => 'Invoice ID',
			'SupplierID' => 'Supplier',
			'PurchaseID' => 'PO. No.',
			'InvoiceNumber' => 'Invoice Number',
			'InvoiceDate' => 'Invoice Date',
			'Amount' => 'Amount',
			'CreatedBy' => 'Created By',
			'CreatedDate' => 'Created Date',
			'Deleted' => 'Deleted',
		];
	}

	public function getPurchases()
	{
		return $this->hasOne(Purchases::className(), ['PurchaseID' => 'PurchaseID'])->from(purchases::tableName());
	}

	public function getSuppliers()
	{
		return $this->hasOne(Suppliers::className(), ['SupplierID' => 'SupplierID'])->from(suppliers::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
