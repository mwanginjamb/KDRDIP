<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_result_questions".
 *
 * @property int $ProjectResultQuestionID
 * @property string $ProjectResultQuestionName
 * @property int $ResultIndicatorID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectResultQuestions extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'project_result_questions';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectResultQuestionName', 'ResultIndicatorID'], 'required'],
			[['ProjectResultQuestionName', 'Notes'], 'string'],
			[['ResultIndicatorID', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectResultQuestionID' => 'Project Result Question ID',
			'ProjectResultQuestionName' => 'Project Result Question Name',
			'ResultIndicatorID' => 'Result Indicator ID',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}
}
