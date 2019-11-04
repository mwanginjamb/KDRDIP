<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "UserGroupRights".
 *
 * @property integer $UserGroupRightID
 * @property integer $UserGroupID
 * @property integer $FormID
 * @property integer $View
 * @property integer $Edit
 * @property integer $Insert
 * @property integer $Delete
 * @property integer $Post
 */
class UserGroupRights extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'usergrouprights';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['UserGroupID', 'FormID', 'View', 'Edit', 'Insert', 'Delete', 'Post'], 'integer'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'UserGroupRightID' => 'User Group Right ID',
			'UserGroupID' => 'User Group ID',
			'FormID' => 'Form ID',
			'View' => '',
			'Edit' => '',
			'Insert' => '',
			'Delete' => '',
		'Post' => '',
		];
	}

	public function getForms()
	{
		return $this->hasOne(Forms::className(), ['FormID' => 'FormID'])->from(Forms::tableName());
	}

	public function getUsers() 
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getView_Name()
	{
		return $this->View == 1 ? 'True' : '';
	}

	public function getInsert_Name()
	{
		return $this->Insert == 1 ? 'True' : '';
	}

	public function getEdit_Name()
	{
		return $this->Edit == 1 ? 'True' : '';
	}

	public function getDelete_Name()
	{
		return $this->Delete == 1 ? 'True' : '';
	}

	public function getPost_Name()
	{
		return $this->Post == 1 ? 'True' : '';
	}
}
