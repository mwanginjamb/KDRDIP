<?php
namespace app\models;

use yii\base\Model;

class FilterData extends Model
{
	public $Month;
	public $Year;
	public $ProductCategoryID;
	public $StockTakeID;
	public $SupplierID;

	public function rules()
	{
		return [
			[['Month', 'Year', 'ProductCategoryID'], 'required'],
		[['Month', 'Year', 'ProductCategoryID', 'StockTakeID', 'SupplierID'], 'integer'],
		];
	}

	public function attributeLabels()
	{
		return [
			'Month' => 'Month',
		'Year' => 'Year',
		'ProductCategoryID' => 'Product Category',
		'StockTakeID' => 'Stock Take',
		'SupplierID' => 'Supplier',
		];
	}
}
