<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wards".
 *
 * @property int $WardID
 * @property string $WardName
 * @property int $SubCountyID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Wards extends \yii\db\ActiveRecord
{
	public $CountyID;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'wards';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['SubCountyID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['WardName'], 'string', 'max' => 45],
			[['WardName', 'CountyID', 'SubCountyID'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'WardID' => 'Ward ID',
			'WardName' => 'Ward',
			'SubCountyID' => 'Sub County',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'CountyID' => 'County'
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
}
