<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "currencies".
 *
 * @property int $CurrencyID
 * @property string $CurrencyName
 * @property string $Symbol
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Currencies extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'currencies';
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
			[['CurrencyName', 'Symbol'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'CurrencyID' => 'Currency ID',
			'CurrencyName' => 'Currency',
			'Symbol' => 'Symbol',
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
