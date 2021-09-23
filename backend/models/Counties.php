<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "counties".
 *
 * @property int $CountyID
 * @property string $CountyName
 * @property string $Notes
 * @property int $RegionID
 * @property string $CreatedDate
 * @property int $CreatedBy
 */
class Counties extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'counties';
	}

    /**
	 * Added by Joseph Ngugi
	 * Filter Deleted Items
	 */
	public static function find()
	{
		return parent::find()->andWhere(['=', 'counties.Active', 1]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['RegionID', 'CreatedBy'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CountyName'], 'string', 'max' => 45],
			[['CountyName'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'CountyID' => 'County ID',
			'CountyName' => 'County',
			'Notes' => 'Notes',
			'RegionID' => 'Region',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
