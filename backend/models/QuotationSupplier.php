<?php

namespace app\models;

use Yii;
use app\models\QuotationResponseLines;

/**
 * This is the model class for table "QuotationSupplier".
 *
 * @property integer $QuotationSupplierID
 * @property integer $QuotationID
 * @property integer $SupplierID
 */
class QuotationSupplier extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'quotationsupplier';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['QuotationID', 'SupplierID'], 'integer'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'QuotationSupplierID' => 'Quotation Supplier ID',
			'QuotationID' => 'Quotation ID',
			'SupplierID' => 'Supplier ID',
		];
	}

	public function getSuppliers()
	{
		return $this->hasOne(Suppliers::className(), ['SupplierID' => 'SupplierID'])->from(Suppliers::tableName());
	}

	public function getQuotation()
	{
		return $this->hasOne(Quotation::className(), ['QuotationID' => 'QuotationID'])->from(quotation::tableName());
	}

	public function getTotalValue()
	{
		// $id = $this->QuotationSupplierID;
		$supplierID = $this->SupplierID;
		$quotationID = $this->QuotationID;
		// $sql = "SELECT sum(UnitPrice * Quantity) as Total FROM quotationresponselines line
		// LEFT JOIN quotationproducts ON quotationproducts.QuotationProductID = line.QuotationProductID
		// LEFT JOIN quotationsupplier ON quotationsupplier.QuotationID = quotationproducts.QuotationID
		// WHERE QuotationSupplierID = $id";
		$sql = "SELECT sum(UnitPrice * Quantity) as Total  from quotationresponselines line
					JOIN quotationresponse response on response.QuotationResponseID = line.QuotationResponseID
					LEFT JOIN quotationproducts ON quotationproducts.QuotationProductID = line.QuotationProductID
					WHERE SupplierID = $supplierID AND response.QuotationID = $quotationID";
		// echo $sql; exit;
		return QuotationResponseLines::findBySql($sql)->asArray()->sum('Total');
	}
}
