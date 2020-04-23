<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mastertargets".
 *
 * @property int $MasterTargetID
 * @property string $Period
 * @property string $Value
 * @property int $MasterIndicatorID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class MasterTargets extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'mastertargets';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Value'], 'number'],
			[['MasterIndicatorID', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['Period'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'MasterTargetID' => 'Master Target ID',
			'Period' => 'Period',
			'Value' => 'Value',
			'MasterIndicatorID' => 'Master Indicator ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
