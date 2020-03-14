<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "questionnaires".
 *
 * @property int $QuestionnaireID
 * @property int $QuestionnaireTypeID
 * @property int $QuestionnaireCategoryID
 * @property int $QuestionnaireSubCategoryID
 * @property string $Question
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Questionnaires extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questionnaires';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['QuestionnaireTypeID', 'QuestionnaireCategoryID', 'QuestionnaireSubCategoryID', 'CreatedBy', 'Deleted'], 'integer'],
            [['Question'], 'string'],
            [['CreatedDate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'QuestionnaireID' => 'Questionnaire ID',
            'QuestionnaireTypeID' => 'Questionnaire Type ID',
            'QuestionnaireCategoryID' => 'Questionnaire Category ID',
            'QuestionnaireSubCategoryID' => 'Questionnaire Sub Category ID',
            'Question' => 'Question',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
