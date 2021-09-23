<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usergroupmembers".
 *
 * @property int $UserGroupMemberID
 * @property int $UserID
 * @property int $UserGroupID
 * @property int $Active
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class UserGroupMembers extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'usergroupmembers';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'usergroupmembers.Deleted', 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		// $m->deletedTime = time();
		return $m->save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['UserID', 'UserGroupID', 'Active', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'UserGroupMemberID' => 'User Group Member ID',
			'UserID' => 'User ID',
			'UserGroupID' => 'User Group ID',
			'Active' => 'Active',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUserGroups()
	{
		return $this->hasOne(UserGroups::className(), ['UserGroupID' => 'UserGroupID'])->from(usergroups::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
