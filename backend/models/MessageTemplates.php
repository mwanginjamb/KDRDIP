<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "MessageTemplates".
 *
 * @property integer $MessageTemplateID
 * @property string $Code
 * @property string $Description
 * @property string $Subject
 * @property string $Message
 * @property string $CreatedDate
 * @property integer $CreatedBy
 */
class MessageTemplates extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'messagetemplates';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['Code', 'Description', 'Subject', 'Message'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy'], 'integer'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'MessageTemplateID' => 'Message Template ID',
			'Code' => 'Code',
			'Description' => 'Description',
			'Subject' => 'Subject',
			'Message' => 'Message',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
