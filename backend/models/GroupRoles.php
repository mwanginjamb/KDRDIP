<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grouproles".
 *
 * @property int $GroupRoleID
 * @property string $GroupRoleName
 * @property string $Notes
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */
class GroupRoles extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'grouproles';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'grouproles.Deleted', 0]);
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
			[['Notes'], 'string'],
			[['CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['GroupRoleName'], 'string', 'max' => 45],
			[['GroupRoleName'], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'GroupRoleID' => 'Group Role ID',
			'GroupRoleName' => 'Group Role Name',
			'Notes' => 'Notes',
			'CreatedBy' => 'Created By',
			'CreatedDate' => 'Created Date',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
