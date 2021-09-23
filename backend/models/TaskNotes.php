<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_notes".
 *
 * @property int $TaskNoteID
 * @property int $TaskID
 * @property string $Notes
 * @property int $TaskStatusID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class TaskNotes extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'task_notes';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['TaskID', 'Notes', 'TaskStatusID'], 'required'],
			[['TaskID', 'TaskStatusID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'TaskNoteID' => 'Task Note ID',
			'TaskID' => 'Task ID',
			'Notes' => 'Notes',
			'TaskStatusID' => 'Task Status ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getTaskStatus()
	{
		return $this->hasOne(TaskStatus::className(), ['TaskStatusID' => 'TaskStatusID']);
	}
}
