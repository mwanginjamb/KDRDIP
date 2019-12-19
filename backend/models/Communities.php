<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "communities".
 *
 * @property int $CommunityID
 * @property string $CommunityName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Communities extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'communities';
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
			[['CommunityName'], 'string', 'max' => 200],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'CommunityID' => 'Community ID',
			'CommunityName' => 'Community',
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
