<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "requisitionline".
 *
 * @property int $RequisitionLineID
 * @property int $RequisitionID
 * @property int $QuotationTypeID
 * @property int $ProductID
 * @property int $AccountID
 * @property double $Quantity
 * @property string $Description
 * @property int $ProjectID
 * @property int $CompanyID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property bool $Deleted
 */
class RequisitionLine extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'requisitionline';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['RequisitionID', 'QuotationTypeID', 'ProductID', 'CompanyID', 'CreatedBy', 'AccountID', 'ProjectID'], 'integer'],
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
			'RequisitionID' => 'Requisition ID',
			'QuotationTypeID' => 'Quotation Type ID',
			'ProductID' => 'Product ID',
			'AccountID' => 'Account',
			'Quantity' => 'Quantity',
			'Description' => 'Description',
			'CompanyID' => 'Company ID',
			'ProjectID' => 'Project ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getProduct()
	{
		return $this->hasOne(Product::className(), ['ProductID' => 'ProductID'])->from(product::tableName());
	}

	public function getAccounts()
	{
		return $this->hasOne(Accounts::className(), ['AccountID' => 'AccountID'])->from(accounts::tableName());
	}

	public function getQuotationTypes()
	{
		return $this->hasOne(QuotationTypes::className(), ['QuotationTypeID' => 'QuotationTypeID'])->from(quotationtypes::tableName());
	}

	public function getProjects()
	{
		return $this->hasOne(Projects::className(), ['ProjectID' => 'ProjectID'])->from(projects::tableName());
	}
}
