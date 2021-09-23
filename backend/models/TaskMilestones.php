<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_milestones".
 *
 * @property int $TaskMilestoneID
 * @property string $TaskMilestoneName
 * @property int $ProjectID
 * @property string $Notes
 * @property string $StartDate
 * @property string $DueDate
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class TaskMilestones extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'task_milestones';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['TaskMilestoneName', 'ProjectID'], 'required'],
			[['Notes'], 'string'],
			[['StartDate', 'DueDate', 'CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted', 'ProjectID'], 'integer'],
			[['TaskMilestoneName'], 'string', 'max' => 200],
			[['TaskMilestoneName'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'TaskMilestoneID' => 'Task Milestone ID',
			'TaskMilestoneName' => 'Task Milestone Name',
			'ProjectID' => 'Sub Project',
			'Notes' => 'Notes',
			'StartDate' => 'Start Date',
			'DueDate' => 'Due Date',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
