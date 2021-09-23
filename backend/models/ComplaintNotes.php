<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "complaintnotes".
 *
 * @property int $ComplaintNoteID
 * @property int $ComplaintID
 * @property int $ComplaintStatusID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ComplaintNotes extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'complaintnotes';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ComplaintID', 'ComplaintStatusID'], 'required'],
			[['ComplaintID', 'ComplaintStatusID', 'CreatedBy', 'Deleted'], 'integer'],
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
			'ComplaintNoteID' => 'Complaint Note ID',
			'ComplaintID' => 'Complaint ID',
			'ComplaintStatusID' => 'Complaint Status ID',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getComplaintStatus()
	{
		return $this->hasOne(ComplaintStatus::className(), ['ComplaintStatusID' => 'ComplaintStatusID']);
	}
}
