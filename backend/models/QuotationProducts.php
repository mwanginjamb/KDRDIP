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
 * @property integer $QuotationTypeID
 * @property integer $AccountID
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
			[['QuotationID', 'ProductID', 'QuotationTypeID', 'AccountID'], 'integer'],
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
			'AccountID' => 'Account',
			'QuotationTypeID' => 'Quotation Types'
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

	public function getAccounts()
	{
		return $this->hasOne(Accounts::className(), ['AccountID' => 'AccountID'])->from(accounts::tableName());
	}

	public function getQuotationTypes()
	{
		return $this->hasOne(QuotationTypes::className(), ['QuotationTypeID' => 'QuotationTypeID'])->from(quotationtypes::tableName());
	}
}
