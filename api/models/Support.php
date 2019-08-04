<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support".
 *
 * @property int $SupportID
 * @property string $Mobile
 * @property string $Email
 * @property string $Message
 * @property string $SupportStatusID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Support extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'support';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Message'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted'], 'integer'],
			[['Mobile', 'Email', 'SupportStatusID'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'SupportID' => 'Support ID',
			'Mobile' => 'Mobile',
			'Email' => 'Email',
			'Message' => 'Message',
			'SupportStatusID' => 'Support Status ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getSupportstatus() 
	{
		return $this->hasOne(SupportStatus::className(), ['SupportStatusID' => 'SupportStatusID'])->from(supportstatus::tableName());
	}
}
