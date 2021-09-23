<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $UserID
 * @property string $FirstName
 * @property string $LastName
 * @property string $Email
 * @property string $Mobile
 * @property string $PasswordHash
 * @property string $AuthKey
 * @property string $ValidationCode
 * @property string $ResetCode
 * @property int $UserStatusID
 * @property int $UserGroupID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 * @property int $UserTypeID
 * @property int $CountyID
 * @property int $CommunityID
 */
class Users extends \yii\db\ActiveRecord
{
	public $Password;
	public $ConfirmPassword;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'users';
	}

/* 	public static function find()
	{
		return parent::find()->andWhere(['=', 'users.Deleted', 0]);
	} */

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
			[['UserStatusID', 'UserGroupID', 'CreatedBy', 'Deleted', 'UserTypeID', 'CountyID', 'CommunityID'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['FirstName', 'LastName', 'Mobile', 'ValidationCode', 'ResetCode'], 'string', 'max' => 45],
			[['Email'], 'email'],
			[['PasswordHash', 'AuthKey'], 'string', 'max' => 128],
			[['Email'],'unique'],
			[['Email', 'FirstName', 'LastName', 'UserTypeID'],'required'],
			[['Password', 'ConfirmPassword'],'required', 'when' => function ($model) {
				return $model->isNewRecord;
			}],
			[['CountyID'],'required', 'when' => function ($model) {
				return ($model->UserTypeID == 2 ||  $model->UserTypeID == 3) ? true : false;
			}],
			[['CommunityID'],'required', 'when' => function ($model) {
				return ($model->UserTypeID == 3) ? true : false;
			}],
			['Password', 'compare', 'compareAttribute'=>'ConfirmPassword'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'UserID' => 'User ID',
			'FirstName' => 'First Name',
			'LastName' => 'Last Name',
			'Email' => 'Email',
			'Mobile' => 'Mobile',
			'PasswordHash' => 'Password Hash',
			'AuthKey' => 'Auth Key',
			'ValidationCode' => 'Validation Code',
			'ResetCode' => 'Reset Code',
			'UserStatusID' => 'User Status',
			'UserGroupID' => 'User Group',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'FullName' => 'Created By',
			'Full_Name' => 'Created By',
			'CommunityID' => 'Community',
			'CountyID' => 'County',
			'UserTypeID' => 'UserType',
		];
	}

	public function getUsergroups()
	{
		return $this->hasOne(UserGroups::className(), ['UserGroupID' => 'UserGroupID'])->from(usergroups::tableName());
	}

	public function getUserstatus()
	{
		return $this->hasOne(UserStatus::className(), ['UserStatusID' => 'UserStatusID'])->from(userstatus::tableName());
	}

	public function getFullName()
	{
		return $this->FirstName . ' ' . $this->LastName;
	}
	
	public function getFull_Name()
	{
		return $this->FirstName . ' ' . $this->LastName;
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(['origin' => users::tableName()]);
	}

	public function getUserTypes()
	{
		return $this->hasOne(UserTypes::className(), ['UserTypeID' => 'UserTypeID'])->from(usertypes::tableName());
	}

	public function getCounties()
	{
		return $this->hasOne(Counties::className(), ['CountyID' => 'CountyID'])->from(counties::tableName());
	}

	public function getCommunities()
	{
		return $this->hasOne(Communities::className(), ['CommunityID' => 'CommunityID'])->from(communities::tableName());
	}
}
