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

	public function fields()
	{
		return [
			'CountyID',
			'CountyName',
		];
	}

	/**
	 * Added by Joseph Ngugi
	 * Filter Deleted Items
	 */
	// public static function find()
	// {
	// 	// return parent::find()->andWhere(['=', 'counties.Deleted', 0]);
	// }

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Notes'], 'string'],
			[['RegionID', 'CreatedBy'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['CountyName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'CountyID' => 'County ID',
			'CountyName' => 'County Name',
			'Notes' => 'Notes',
			'RegionID' => 'Region ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
		];
	}
}
