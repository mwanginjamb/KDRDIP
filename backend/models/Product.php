<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Product".
 *
 * @property integer $ProductID
 * @property string $ProductName
 * @property integer $Deleted
 * @property string $CreatedDate
 * @property integer $CreatedBy
 * @property integer $ProductCategoryID
 * @property integer $ProductCategory2ID
 * @property integer $ProductCategory3ID
 * @property integer $UsageUnitID
 * @property integer $ReOrderLevel
 * @property double $UnitPrice
 * @property integer $Active
 * @property double $VATRate
 * @property double $ServiceRate
 * @property double $SalesRate
 * @property string $Image
 * @property integer $QtyPerUnit
 * @property string $Description
 */
class Product extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'product';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'product.Deleted', 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		// $m->deletedTime = time();
		return $m->save();
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['ProductName', 'Image', 'Description'], 'string'],
			[['CreatedBy', 'ProductCategoryID', 'ProductCategory2ID', 'ProductCategory3ID', 'UsageUnitID', 'ReOrderLevel', 
			'Active', 'QtyPerUnit'], 'integer'],
			[['Deleted'], 'boolean'],
			[['CreatedDate'], 'safe'],
			[['UnitPrice', 'VATRate', 'ServiceRate', 'SalesRate'], 'number'],
			[['ProductName', 'UnitPrice','ProductCategoryID'], 'required']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'ProductID' => 'Item ID',
			'ProductName' => 'Item Name',
			'Deleted' => 'Deleted',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'ProductCategoryID' => 'Item Category',
			'ProductCategory2ID' => 'Item Category 2',
			'ProductCategory3ID' => 'Item Category 3',
			'UsageUnitID' => 'Usage Unit',
			'ReOrderLevel' => 'Re Order Level',
			'UnitPrice' => 'Unit Price',
			'Active' => 'Active',
			'VATRate' => 'Vatrate',
			'ServiceRate' => 'Service Rate',
			'SalesRate' => 'Sales Rate',
			'Image' => 'Image',
			'QtyPerUnit' => 'Qty Per Unit',
			'Description' => 'Description',
		];
	}

	public function getProductcategory()
	{
		return $this->hasOne(ProductCategory::className(), ['ProductCategoryID' => 'ProductCategoryID'])->from(productcategory::tableName());
	}

	public function getProductcategory2()
	{
		return $this->hasOne(ProductCategory::className(), ['ProductCategoryID' => 'ProductCategory2ID'])->from(['origin' => productcategory::tableName()]);
	}

	public function getProductcategory3()
	{
		return $this->hasOne(ProductCategory::className(), ['ProductCategoryID' => 'ProductCategory3ID'])->from(['origin' => productcategory::tableName()]);
	}

	public function getUsageunit()
	{
		return $this->hasOne(UsageUnit::className(), ['UsageUnitID' => 'UsageUnitID'])->from(usageunit::tableName());
	}

	public function getProduct_Active()
	{
		return $this->Active==1 ? 'True' : 'False';
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
