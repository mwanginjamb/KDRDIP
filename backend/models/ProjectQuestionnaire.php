<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectquestionnaire".
 *
 * @property int $ProjectQuestionnaireID
 * @property int $QuestionnaireID
 * @property int $QuestionnaireStatusID
 * @property int $ProjectID
 * @property string $Comments
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectQuestionnaire extends \yii\db\ActiveRecord
{
	public $QuestionnaireCategoryName;
	public $QuestionnaireSubCategoryName;
	public $QID;
	public $Question;
	public $QuestionnaireCategoryID;
	public $QuestionnaireSubCategoryID;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'projectquestionnaire';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'projectquestionnaire.Deleted', 0]);
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
			[['ProjectQuestionnaireID', 'QuestionnaireID', 'QuestionnaireStatusID', 'ProjectID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Comments'], 'string'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectQuestionnaireID' => 'Project Questionnaire ID',
			'QuestionnaireID' => 'Questionnaire ID',
			'QuestionnaireStatusID' => 'Status',
			'ProjectID' => 'Project ID',
			'Comments' => 'Comments',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'SelectedOption' => '',
		];
	}
}
