<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "questionnairesubcategories".
 *
 * @property int $QuestionnaireSubCategoryID
 * @property string $QuestionnaireSubCategoryName
 * @property int $QuestionnaireCategoryID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class QuestionnaireSubCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questionnairesubcategories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['QuestionnaireCategoryID', 'CreatedBy', 'Deleted'], 'integer'],
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['QuestionnaireSubCategoryName'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'QuestionnaireSubCategoryID' => 'Questionnaire Sub Category ID',
            'QuestionnaireSubCategoryName' => 'Questionnaire Sub Category Name',
            'QuestionnaireCategoryID' => 'Questionnaire Category ID',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
