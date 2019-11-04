<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "QuotationProducts".
 *
 * @property integer $QuotationProductID
 * @property integer $QuotationID
 * @property integer $ProductID
 * @property double $Quantity
 */
class QuotationProducts extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'quotationproducts';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['QuotationID', 'ProductID'], 'integer'],
			[['Quantity'], 'number'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'QuotationProductID' => 'Quotation Product ID',
			'QuotationID' => 'Quotation ID',
			'ProductID' => 'Product ID',
			'Quantity' => 'Quantity',
		];
	}

	public function getProduct()
	{
		return $this->hasOne(Product::className(), ['ProductID' => 'ProductID'])->from(product::tableName());
	}

	public function getUnitPrice()
	{
		return '';
	}

	public function getUnit_Total()
	{
		return '';
	}	

}
