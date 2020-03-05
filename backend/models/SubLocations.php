<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sublocations".
 *
 * @property int $SubLocationID
 * @property string $SubLocationName
 * @property int $LocationID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class SubLocations extends \yii\db\ActiveRecord
{
	public $CountyID;
	public $SubCountyID;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'sublocations';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['LocationID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['SubLocationName'], 'string', 'max' => 45],
			[['SubLocationName', 'LocationID', 'SubCountyID', 'CountyID'], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'SubLocationID' => 'Sub Location ID',
			'SubLocationName' => 'Sub Location Name',
			'LocationID' => 'Location',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'SubCountyID' => 'Sub County',
			'CountyID' => 'County',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getLocations()
	{
		return $this->hasOne(Locations::className(), ['LocationID' => 'LocationID'])->from(locations::tableName());
	}
}
