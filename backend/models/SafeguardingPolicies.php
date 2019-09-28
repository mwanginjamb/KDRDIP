<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "safeguardingpolicies".
 *
 * @property int $SafeguardingPolicyID
 * @property string $SafeguardingPolicyName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class SafeguardingPolicies extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'safeguardingpolicies';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['SafeguardingPolicyName', 'Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted'], 'integer'],
			[['SafeguardingPolicyName'], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'SafeguardingPolicyID' => 'Safeguarding Policy ID',
			'SafeguardingPolicyName' => 'Safeguarding Policy Name',
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
