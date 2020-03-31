<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "groupmembers".
 *
 * @property int $CommunityGroupMemberID
 * @property string $MemberName
 * @property int $GroupRoleID
 * @property int $HouseholdTypeID
 * @property string $Gender
 * @property string $DateOfBirth
 * @property string $Notes
 * @property int $DifferentlyAbled
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class GroupMembers extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'groupmembers';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['GroupRoleID', 'HouseholdTypeID', 'DifferentlyAbled', 'CreatedBy', 'Deleted'], 'integer'],
			[['DateOfBirth', 'CreatedDate'], 'safe'],
			[['Notes'], 'string'],
			[['MemberName'], 'string', 'max' => 100],
			[['Gender'], 'string', 'max' => 1],
			[['MemberName', 'Gender', 'DateOfBirth', 'GroupRoleID', 'HouseholdTypeID'], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'CommunityGroupMemberID' => 'Community Group Member ID',
			'MemberName' => 'Member Name',
			'GroupRoleID' => 'Group Role',
			'HouseholdTypeID' => 'Household Type',
			'Gender' => 'Gender',
			'DateOfBirth' => 'Date Of Birth',
			'Notes' => 'Notes',
			'DifferentlyAbled' => 'Differently Abled',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getGroupRoles()
	{
		return $this->hasOne(GroupRoles::className(), ['GroupRoleID' => 'GroupRoleID'])->from(grouproles::tableName());
	}

	public function getHouseholdTypes()
	{
		return $this->hasOne(HouseholdTypes::className(), ['HouseholdTypeID' => 'HouseholdTypeID'])->from(householdtypes::tableName());
	}
}
