<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "RequisitionLine".
 *
 * @property integer $RequisitionLineID
 * @property string $CreatedDate
 * @property integer $CreatedBy
 * @property integer $Deleted
 * @property integer $RequisitionID
 * @property integer $ProductID
 * @property double $Quantity
 * @property string $Description
 */
class RequisitionLine extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'requisitionline';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted', 'RequisitionID', 'ProductID'], 'integer'],
			[['Quantity'], 'number'],
			[['Description'], 'string'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'RequisitionLineID' => 'Requisition Line ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'RequisitionID' => 'Requisition ID',
			'ProductID' => 'Product ID',
			'Quantity' => 'Quantity',
			'Description' => 'Description',
		];
	}

	public function getProduct() 
	{
		return $this->hasOne(Product::className(), ['ProductID' => 'ProductID'])->from(product::tableName());
	}
}
