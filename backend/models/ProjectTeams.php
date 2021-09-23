<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectteams".
 *
 * @property int $ProjectTeamID
 * @property int $ProjectID
 * @property string $ProjectTeamName
 * @property int $ProjectRoleID
 * @property string $Specialization
 * @property int $ProjectUnitID
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */
class ProjectTeams extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'projectteams';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'projectteams.Deleted', 0]);
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
			[['ProjectID', 'ProjectRoleID', 'ProjectUnitID', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['ProjectTeamName', 'Specialization'], 'string', 'max' => 300],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectTeamID' => 'Project Team ID',
			'ProjectID' => 'Project ID',
			'ProjectTeamName' => 'Project Team Name',
			'ProjectRoleID' => 'Project Role ID',
			'Specialization' => 'Specialization',
			'ProjectUnitID' => 'Project Unit ID',
			'CreatedBy' => 'Created By',
			'CreatedDate' => 'Created Date',
			'Deleted' => 'Deleted',
		];
	}

	public function getProjectRoles()
	{
		return $this->hasOne(ProjectRoles::className(), ['ProjectRoleID' => 'ProjectRoleID'])->from(projectroles::tableName());
	}

	public function getProjectUnits()
	{
		return $this->hasOne(ProjectUnits::className(), ['ProjectUnitID' => 'ProjectUnitID'])->from(projectunits::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
