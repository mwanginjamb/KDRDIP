<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "youthplacement".
 *
 * @property int $YouthPlacementID
 * @property string $YouthPlacementName
 * @property string $PostalAddress
 * @property string $PostalCode
 * @property string $Town
 * @property int $CountryID
 * @property string $Telephone
 * @property string $Mobile
 * @property string $Email
 * @property string $Url
 * @property string $PhysicalLocation
 * @property int $CountyID
 * @property int $SubCountyID
 * @property int $WardID
 * @property string $Village
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class YouthPlacement extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'youthplacement';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['CountryID', 'CountyID', 'SubCountyID', 'WardID', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['YouthPlacementName'], 'string', 'max' => 200],
			[['PostalAddress', 'PostalCode', 'Town', 'Telephone', 'Mobile', 'Village'], 'string', 'max' => 45],
			[['Email', 'Url', 'PhysicalLocation'], 'string', 'max' => 300],
			[['YouthPlacementName', 'CountyID', 'SubCountyID','WardID', 'Mobile' ], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'YouthPlacementID' => 'Youth Placement ID',
			'YouthPlacementName' => 'Youth Placement Name',
			'PostalAddress' => 'Postal Address',
			'PostalCode' => 'Postal Code',
			'Town' => 'Town',
			'CountryID' => 'Country',
			'Telephone' => 'Telephone',
			'Mobile' => 'Mobile',
			'Email' => 'Email',
			'Url' => 'Url',
			'PhysicalLocation' => 'Physical Location',
			'CountyID' => 'County',
			'SubCountyID' => 'Sub County',
			'WardID' => 'Ward',
			'Village' => 'Village',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
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

	public function getCountries()
	{
		return $this->hasOne(Countries::className(), ['CountryID' => 'CountryID'])->from(countries::tableName());
	}
}
