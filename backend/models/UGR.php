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
class UGR extends \yii\db\ActiveRecord
{
	public $PageName;
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
			[['UserGroupID', 'PageID', 'View', 'Edit', 'Create', 'Delete'], 'integer'],
			[['PageName'], 'string'],
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
			'PageID' => 'Page ID',
			'View' => '',
			'Edit' => '',
			'Create' => '',
			'Delete' => '',
			'PageName' => 'Page'
		];
	}

	public function getPages()
	{
		return $this->hasOne(Pages::className(), ['PageID' => 'PageID'])->from(pages::tableName());
	}

	public function getUsers() 
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getView_Name()
	{
		return $this->View == 1 ? 'True' : '';
	}

	public function getCreate_Name()
	{
		return $this->Create == 1 ? 'True' : '';
	}

	public function getEdit_Name()
	{
		return $this->Edit == 1 ? 'True' : '';
	}

	public function getDelete_Name()
	{
		return $this->Delete == 1 ? 'True' : '';
	}
}
