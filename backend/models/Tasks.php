<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $TaskID
 * @property string $TaskName
 * @property int $TaskMilestoneID
 * @property int $ProjectID
 * @property string $StartDate
 * @property string $DueDate
 * @property string $Comments
 * @property int $TaskStatusID
 * @property int $AssignedTo
 * @property double $CompletionPercentage
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Tasks extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'tasks';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['TaskName', 'TaskMilestoneID', 'StartDate', 'DueDate', 'TaskStatusID', 'ProjectID'], 'required'],
			[['TaskMilestoneID', 'TaskStatusID', 'AssignedTo', 'CreatedBy', 'Deleted', 'ProjectID'], 'integer'],
			[['StartDate', 'DueDate', 'CreatedDate'], 'safe'],
			[['Comments'], 'string'],
			[['CompletionPercentage'], 'number'],
			[['TaskName'], 'string', 'max' => 200],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'TaskID' => 'Taks ID',
			'TaskName' => 'Task Name',
			'TaskMilestoneID' => 'Task Milestone',
			'ProjectID' => 'Sub Project',
			'StartDate' => 'Start Date',
			'DueDate' => 'Due Date',
			'Comments' => 'Comments',
			'TaskStatusID' => 'Task Status',
			'AssignedTo' => 'Assigned To',
			'CompletionPercentage' => 'Completion Percentage',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getTaskMilestones()
	{
		return $this->hasOne(TaskMilestones::className(), ['TaskMilestoneID' => 'TaskMilestoneID']);
	}

	public function getTaskStatus()
	{
		return $this->hasOne(TaskStatus::className(), ['TaskStatusID' => 'TaskStatusID']);
	}

	public function getAssignedToUser()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'AssignedTo'])->from(['assignedToUser' => users::tableName()]);
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
