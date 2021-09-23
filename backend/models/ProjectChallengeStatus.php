<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_challenge_status".
 *
 * @property int $ProjectChallengeStatusID
 * @property string $ProjectChallengeStatusName
 * @property string $Notes
 * @property string $ColorCode
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectChallengeStatus extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'project_challenge_status';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'project_challenge_status.Deleted', 0]);
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
			[['CreatedBy', 'Deleted'], 'integer'],
			[['ProjectChallengeStatusName', 'ColorCode'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectChallengeStatusID' => 'Project Challenge Status ID',
			'ProjectChallengeStatusName' => 'Project Challenge Status Name',
			'Notes' => 'Notes',
			'ColorCode' => 'Color Code',
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
