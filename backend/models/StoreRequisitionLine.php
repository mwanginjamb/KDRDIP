<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "storerequisitionline".
 *
 * @property int $RequisitionLineID
 * @property int $StoreRequisitionID
 * @property int $ProductID
 * @property double $Quantity
 * @property string $Description
 * @property int $CompanyID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property bool $Deleted
 */
class StoreRequisitionLine extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'storerequisitionline';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['StoreRequisitionID', 'ProductID', 'CompanyID', 'CreatedBy'], 'integer'],
			[['Quantity'], 'number'],
			[['CreatedDate'], 'safe'],
			[['Deleted'], 'boolean'],
			[['Description'], 'string', 'max' => 50],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'RequisitionLineID' => 'Requisition Line ID',
			'StoreRequisitionID' => 'Store Requisition ID',
			'ProductID' => 'Product ID',
			'Quantity' => 'Quantity',
			'Description' => 'Description',
			'CompanyID' => 'Company ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	
	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getProduct()
	{
		return $this->hasOne(Product::className(), ['ProductID' => 'ProductID'])->from(product::tableName());
	}
}
