<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_challenges".
 *
 * @property int $ProjectChallengeID
 * @property int $ProjectID
 * @property string $Challenge
 * @property string $CorrectiveAction
 * @property int $AssignedTo
 * @property int $ProjectChallengeStatusID
 * @property int $ChallengeTypeID
 * @property string $AgreedDate
 * @property int $MajorChallenge
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectChallenges extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'project_challenges';
	}

	public static function find()
	{
		return parent::find()->andWhere(['project_challenges.Deleted' => 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		return $m->save();
	}

	public function save($runValidation = true, $attributeNames = null)
	{
		//this record is always new
		if ($this->isNewRecord) {
			$this->CreatedBy = Yii::$app->user->identity->UserID;
			$this->CreatedDate = date('Y-m-d h:i:s');
		}
		return parent::save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectID', 'AssignedTo', 'CreatedBy', 'Deleted', 'ProjectChallengeStatusID', 'MajorChallenge', 'ChallengeTypeID'], 'integer'],
			[['Challenge', 'CorrectiveAction'], 'string'],
			[['AgreedDate', 'CreatedDate'], 'safe'],
			[['AssignedTo', 'Challenge', 'CorrectiveAction', 'AgreedDate', 'ProjectChallengeStatusID', 'MajorChallenge'], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectChallengeID' => 'Project Challenge ID',
			'ProjectID' => 'Project ID',
			'Challenge' => 'Challenge',
			'CorrectiveAction' => 'Corrective Action',
			'AssignedTo' => 'Assigned To',
			'AgreedDate' => 'Agreed Date',
			'ProjectChallengeStatusID' => 'Status',
			'ChallengeTypeID' => 'Challenge Type',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'MajorChallenge' => 'Major Challenge',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
	}

	public function getEmployees()
	{
		return $this->hasOne(Employees::className(), ['EmployeeID' => 'AssignedTo']);
	}

	public function getProjectChallengeStatus()
	{
		return $this->hasOne(ProjectChallengeStatus::className(), ['ProjectChallengeStatusID' => 'ProjectChallengeStatusID']);
	}
}
