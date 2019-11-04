<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PriceList".
 *
 * @property integer $PriceListID
 * @property integer $SupplierID
 * @property string $Code
 * @property string $ProductName
 * @property string $UnitofMeasure
 * @property double $Price
 */
class PriceList extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'PriceList';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['SupplierID'], 'integer'],
			[['SupplierCode', 'ProductName', 'UnitofMeasure'], 'string'],
			[['Price'], 'number'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'PriceListID' => 'Price List ID',
			'SupplierID' => 'Supplier ID',
			'SupplierCode' => 'Supplier Code',
			'ProductName' => 'Product Name',
			'UnitofMeasure' => 'Unitof Measure',
			'Price' => 'Price',
		];
	}
}
