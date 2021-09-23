<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "questionnairecategories".
 *
 * @property int $QuestionnaireCategoryID
 * @property string $QuestionnaireCategoryName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class QuestionnaireCategories extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'questionnairecategories';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'questionnairecategories.Deleted', 0]);
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
			[['QuestionnaireCategoryName'], 'string', 'max' => 200],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'QuestionnaireCategoryID' => 'Questionnaire Category ID',
			'QuestionnaireCategoryName' => 'Questionnaire Category Name',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}
}
