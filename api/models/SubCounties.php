<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subcounties".
 *
 * @property int $SubCountyID
 * @property string $SubCountyName
 * @property int $CountyID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class SubCounties extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'subcounties';
	}

	public function fields()
	{
		return [
			'SubCountyID',
			'SubCountyName',
			'CountyID',
		];
	}

	/**
	 * Added by Joseph Ngugi
	 * Filter Deleted Items
	 */
	public static function find()
	{
		return parent::find()->andWhere(['=', 'subcounties.Deleted', 0]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['CountyID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['SubCountyName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'SubCountyID' => 'Sub County ID',
			'SubCountyName' => 'Sub County Name',
			'CountyID' => 'County ID',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}
}
