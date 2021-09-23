<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "StockTakeLines".
 *
 * @property integer $StockTakeLineID
 * @property integer $StockTakeID
 * @property integer $ProductID
 * @property double $Quantity
 */
class StockTakeLines extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'stocktakelines';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['StockTakeID', 'ProductID'], 'integer'],
			[['CurrentStock', 'PhysicalStock'], 'number'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'StockTakeLineID' => 'Stock Take Line ID',
			'StockTakeID' => 'Stock Take ID',
			'ProductID' => 'Product ID',
			'CurrentStock' => 'Current Stock',
		'PhysicalStock' => 'Physical sStock',
		'Variance' => 'Variance'
		];
	}

public function getProduct() 
{
		return $this->hasOne(Product::className(), ['ProductID' => 'ProductID'])->from(Product::tableName());
	}
}
