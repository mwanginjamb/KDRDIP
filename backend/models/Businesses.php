<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "businesses".
 *
 * @property int $BusinessID
 * @property string $BusinessName
 * @property string $TradingName
 * @property string $PostalAddress
 * @property string $PostalCode
 * @property string $Town
 * @property int $CountryID
 * @property string $PhysicalLocation
 * @property string $Telephone
 * @property string $Mobile
 * @property string $Email
 * @property string $Url
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Businesses extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'businesses';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'businesses.Deleted', 0]);
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
			[['CountryID', 'CreatedBy', 'Deleted', 'CountyID', 'SubCountyID', 'WardID', 'SubLocationID'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['BusinessName', 'TradingName'], 'string', 'max' => 200],
			[['PostalAddress', 'PostalCode', 'Town', 'Telephone', 'Mobile', 'Village'], 'string', 'max' => 45],
			[['PhysicalLocation', 'Email', 'Url'], 'string', 'max' => 300],
			[['BusinessName', 'TradingName', 'Mobile', 'CountyID', 'SubCountyID', 'WardID', 'SubLocationID'], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'BusinessID' => 'Business ID',
			'BusinessName' => 'Business Name',
			'TradingName' => 'Trading Name',
			'PostalAddress' => 'Postal Address',
			'PostalCode' => 'Postal Code',
			'Town' => 'Town',
			'CountryID' => 'Country',
			'PhysicalLocation' => 'Physical Location',
			'Telephone' => 'Telephone',
			'Mobile' => 'Mobile',
			'Email' => 'Email',
			'Url' => 'Url',
			'CountyID' => 'County',
			'SubCountyID' => 'Sub County',
			'WardID' => 'Ward',
			'Village' => 'Village',
			'SubLocationID' => 'Village',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
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

	public function getCounties()
	{
		return $this->hasOne(Counties::className(), ['CountyID' => 'CountyID'])->from(counties::tableName());
	}

	public function getSubCounties()
	{
		return $this->hasOne(SubCounties::className(), ['SubCountyID' => 'SubCountyID'])->from(subcounties::tableName());
	}

	public function getWards()
	{
		return $this->hasOne(Wards::className(), ['WardID' => 'WardID'])->from(wards::tableName());
	}

	public function getSubLocations()
	{
		return $this->hasOne(SubLocations::className(), ['SubLocationID' => 'SubLocationID']);
	}
}
