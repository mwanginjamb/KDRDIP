<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ApprovalNotes".
 *
 * @property integer $ApprovalNoteID
 * @property string $Note
 * @property string $CreatedDate
 * @property integer $CreatedBy
 * @property integer $Deleted
 * @property integer $ApprovalStatusID
 * @property integer $ApprovalTypeID
 * @property integer $ApprovalID
 */
class ApprovalNotes extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'approvalnotes';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['Note'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted', 'ApprovalStatusID', 'ApprovalTypeID', 'ApprovalID'], 'integer'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'ApprovalNoteID' => 'Approval Note ID',
			'Note' => 'Note',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'ApprovalStatusID' => 'Approval Status ID',
			'ApprovalTypeID' => 'Approval Type ID',
			'ApprovalID' => 'Approval ID',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
