<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Company".
 *
 * @property integer $CompanyID
 * @property string $CompanyName
 * @property string $CompanyLogo
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
class Company extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'company';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['CompanyName', 'CompanyLogo', 'PostalAddress', 'PostalCode', 'Town', 'VATNo', 'PIN', 'Telephone', 'Mobile', 'Fax', 'Email'], 'string'],
			[['CountryID', 'Deleted', 'CreatedBy'], 'integer'],
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
			'CompanyID' => 'Company ID',
			'CompanyName' => 'Company Name',
			'CompanyLogo' => 'Company Logo',
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
		];
	}

	public function getCountry()
	{
		return $this->hasOne(Countries::className(), ['CountryID' => 'CountryID'])->from(countries::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
