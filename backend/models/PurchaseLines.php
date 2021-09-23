<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PurchaseLines".
 *
 * @property integer $PurchaseLineID
 * @property string $PurchaseID
 * @property string $CreatedDate
 * @property integer $CreatedBy
 * @property integer $Deleted
 * @property integer $ProductID
 * @property double $Quantity
 * @property double $UnitPrice
 * @property integer $UsageUnitID
 */
class PurchaseLines extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'purchaselines';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'purchaselines.Deleted', 0]);
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
			[['PurchaseID', 'UsageUnitID'], 'integer'],
		[['SupplierCode'],'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted', 'ProductID'], 'integer'],
			[['Quantity', 'UnitPrice'], 'number'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'PurchaseLineID' => 'Purchase Line ID',
			'PurchaseID' => 'Purchase ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'ProductID' => 'Product ID',
			'Quantity' => 'Quantity',
			'UnitPrice' => 'Unit Price',
		'SupplierCode' => 'Supplier Code',
		'UsageUnitID' => 'Usage Unit',
		];
	}

public function getProduct() 
{
		return $this->hasOne(Product::className(), ['ProductID' => 'ProductID'])->from(product::tableName());
	}

public function getUnit_Total()
{
	return $this->Quantity * $this->UnitPrice;
}	

public function getUsageunit() 
{
		return $this->hasOne(UsageUnit::className(), ['UsageUnitID' => 'UsageUnitID'])->from(usageunit::tableName());
	}
}
