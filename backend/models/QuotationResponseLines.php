<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quotationresponselines".
 *
 * @property int $QuotationResponseLineID
 * @property int $QuotationResponseID
 * @property int $QuotationProductID
 * @property string $UnitPrice
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */
class QuotationResponseLines extends \yii\db\ActiveRecord
{
	public $ProductID;
	public $Quantity;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'quotationresponselines';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'quotationresponselines.Deleted', 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		// $m->deletedTime = time();
		return $m->save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['QuotationResponseID', 'QuotationProductID', 'CreatedBy', 'Deleted'], 'integer'],
			[['UnitPrice'], 'number'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'QuotationResponseLineID' => 'Quotation Response Line ID',
			'QuotationResponseID' => 'Quotation Response ID',
			'QuotationProductID' => 'Quotation Product ID',
			'UnitPrice' => 'Unit Price',
			'CreatedBy' => 'Created By',
			'CreatedDate' => 'Created Date',
			'Deleted' => 'Deleted',
			'ProductID' => 'Product',
			'Quantity' => 'Quantity'
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

	public function getQuotationProducts()
	{
		return $this->hasOne(QuotationProducts::className(), ['QuotationProductID' => 'QuotationProductID'])->from(quotationproducts::tableName());
	}

	public function getQuotationResponse()
	{
		return $this->hasOne(QuotationResponse::className(), ['QuotationResponseID' => 'QuotationResponseID'])->from(quotationresponse::tableName());
	}
}
