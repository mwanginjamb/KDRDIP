<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_question_responses".
 *
 * @property int $ResponseID
 * @property int $projectResultQuestionID
 * @property int $ProjectID
 * @property string $Response
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectQuestionResponses extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'project_question_responses';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['projectResultQuestionID', 'ProjectID', 'Response'], 'required'],
			[['projectResultQuestionID', 'ProjectID', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['Response'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ResponseID' => 'Response ID',
			'projectResultQuestionID' => 'Project Result Question ID',
			'ProjectID' => 'Project ID',
			'Response' => 'Response',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getProjectResultQuestions()
	{
		return $this->hasOne(ProjectResultQuestions::className(), ['projectResultQuestionID' => 'projectResultQuestionID']);
	}
}
