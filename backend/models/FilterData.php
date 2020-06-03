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
	public $ProjectSectorID;
	public $ComponentID;
	public $CountyID;
	public $SubCountyID;
	public $LocationID;
	public $SubLocationID;
	public $StartDate;
	public $EndDate;

	public function rules()
	{
		return [
			[['Month', 'Year', 'ProductCategoryID'], 'required'],
			[['Month', 'Year', 'ProductCategoryID', 'StockTakeID', 'SupplierID', 'ProjectStatusID', 'ComponentID',
				'CountyID', 'SubCountyID', 'LocationID', 'SubLocationID', 'ProjectSectorID'], 'integer'],
			[['StartDate', 'EndDate'], 'safe']
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
			'ComponentID' => 'Component',
			'CountyID' => 'County',
			'SubCountyID' => 'SubCounty',
			'LocationID' => 'Location',
			'SubLocationID' => 'Village',
			'ProjectSectorID' => 'Project Sector',
			'EndDate' => 'End Date',
			'StartDate' => 'Start Date',
		];
	}
}
