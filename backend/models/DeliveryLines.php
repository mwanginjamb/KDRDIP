<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "DeliveryLines".
 *
 * @property integer $DeliveryLineID
 * @property integer $DeliveryID
 * @property integer $Quantity
 * @property integer $PurchaseLineID
 */
class DeliveryLines extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'deliverylines';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['DeliveryID', 'PurchaseLineID'], 'integer'],
		[['DeliveredQuantity',], 'number'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'DeliveryLineID' => 'Delivery Line ID',
			'DeliveryID' => 'Delivery ID',
			'DeliveredQuantity' => 'Delivered Quantity',
			'PurchaseLineID' => 'Purchase Line ID',
		];
	}

public function getPurchaseLines() 
{
		return $this->hasOne(PurchaseLines::className(), ['PurchaseLineID' => 'PurchaseLineID'])->from(PurchaseLines::tableName());
	}
}
