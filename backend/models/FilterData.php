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
	public $BankAccountID;
	public $ProjectID;
	public $ProjectStatusID;

	public function rules()
	{
		return [
			[['Month', 'Year', 'ProductCategoryID'], 'required'],
			[['Month', 'Year', 'ProductCategoryID', 'StockTakeID', 'SupplierID', 'ProjectStatusID'], 'integer'],
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
			'ProjectID' => 'Project',
			'ProjectStatusID' => 'Project Status',
		];
	}
}
