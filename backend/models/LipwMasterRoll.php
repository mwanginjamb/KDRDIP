<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lipw_master_roll".
 *
 * @property int $MasterRollID
 * @property int $SubLocationID
 * @property string $MasterRollName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class LipwMasterRoll extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'lipw_master_roll';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['SubLocationID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['MasterRollName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'MasterRollID' => 'Master Roll ID',
			'SubLocationID' => 'Sub Location ID',
			'MasterRollName' => 'Master Roll Name',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
	}

	public function getSubLocations()
	{
		return $this->hasOne(SubLocations::className(), ['SubLocationID' => 'SubLocationID']);
	}
}
