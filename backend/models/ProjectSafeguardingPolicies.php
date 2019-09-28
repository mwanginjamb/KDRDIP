<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectsafeguardingpolicies".
 *
 * @property int $ProjectSafeguardingPolicyID
 * @property int $SafeguardingPolicyID
 * @property int $ProjectID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectSafeguardingPolicies extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'projectsafeguardingpolicies';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['SafeguardingPolicyID', 'ProjectID', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectSafeguardingPolicyID' => 'Project Safeguarding Policy ID',
			'SafeguardingPolicyID' => 'Safeguarding Policy ID',
			'ProjectID' => 'Project ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getSafeguardingPolicies()
	{
		return $this->hasOne(SafeguardingPolicies::className(), ['SafeguardingPolicyID' => 'SafeguardingPolicyID'])->from(safeguardingpolicies::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
