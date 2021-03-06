<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "complaintpriorities".
 *
 * @property int $ComplaintPriorityID
 * @property string $ComplaintPriorityName
 * @property string $Notes
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */
class ComplaintPriorities extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'complaintpriorities';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'complaintpriorities.Deleted', 0]);
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
			[['ComplaintPriorityName'], 'string', 'max' => 45],
			[['ComplaintPriorityName'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ComplaintPriorityID' => 'Complaint Priority ID',
			'ComplaintPriorityName' => 'Complaint Priority',
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
