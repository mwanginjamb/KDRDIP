<?php

namespace app\models;

use Yii;

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
}
