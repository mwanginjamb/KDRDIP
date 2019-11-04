<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Suppliers".
 *
 * @property integer $SupplierID
 * @property string $SupplierName
 * @property string $PostalAddress
 * @property string $PostalCode
 * @property string $Town
 * @property integer $CountryID
 * @property double $VATRate
 * @property string $VATNo
 * @property string $PIN
 * @property string $Telephone
 * @property string $Mobile
 * @property string $Fax
 * @property string $Email
 * @property integer $Deleted
 * @property string $CreatedDate
 * @property integer $CreatedBy
 */
class Suppliers extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'suppliers';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['SupplierName', 'PostalAddress', 'PostalCode', 'Town', 'VATNo', 'PIN', 'Telephone', 'Mobile', 'Fax', 'Email'], 'string'],
			[['CountryID', 'Deleted', 'CreatedBy', 'CreditPeriod'], 'integer'],
			[['VATRate'], 'number'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'SupplierID' => 'Supplier ID',
			'SupplierName' => 'Supplier Name',
			'PostalAddress' => 'Postal Address',
			'PostalCode' => 'Postal Code',
			'Town' => 'Town',
			'CountryID' => 'Country',
			'VATRate' => 'VAT Rate',
			'VATNo' => 'VAT No.',
			'PIN' => 'PIN',
			'Telephone' => 'Telephone',
			'Mobile' => 'Mobile',
			'Fax' => 'Fax',
			'Email' => 'Email',
			'Deleted' => 'Deleted',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
		'CreditPeriod' => 'Credit Period',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getCountries()
	{
		return $this->hasOne(Countries::className(), ['CountryID' => 'CountryID'])->from(countries::tableName());
	}
}
