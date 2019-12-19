<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banktypes".
 *
 * @property int $BankTypeID
 * @property string $BankTypeName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class BankTypes extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'banktypes';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted'], 'integer'],
			[['BankTypeName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'BankTypeID' => 'Bank Type ID',
			'BankTypeName' => 'Bank Type',
			'Notes' => 'Notes',
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
