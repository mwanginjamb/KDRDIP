<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "complaintstatus".
 *
 * @property int $ComplaintStatusID
 * @property string $ComplaintStatusName
 * @property string $Notes
 * @property string $Closure
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ComplaintStatus extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'complaintstatus';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'complaintstatus.Deleted', 0]);
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
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted', 'Closure'], 'integer'],
			[['ComplaintStatusName'], 'string', 'max' => 45],
			[['ComplaintStatusName'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ComplaintStatusID' => 'Complaint Status ID',
			'ComplaintStatusName' => 'Complaint Status',
			'Notes' => 'Notes',
			'Closure' => 'Closure',
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
