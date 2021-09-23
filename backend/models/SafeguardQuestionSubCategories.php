<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "safeguard_question_sub_categories".
 *
 * @property int $SafeguardQuestionSubCategoryID
 * @property string $SafeguardQuestionSubCategoryName
 * @property int $SafeguardQuestionCategoryID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class SafeguardQuestionSubCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safeguard_question_sub_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SafeguardQuestionSubCategoryName', 'SafeguardQuestionCategoryID'], 'required'],
            [['SafeguardQuestionCategoryID', 'CreatedBy', 'Deleted'], 'integer'],
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['SafeguardQuestionSubCategoryName'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SafeguardQuestionSubCategoryID' => 'Safeguard Question Sub Category ID',
            'SafeguardQuestionSubCategoryName' => 'Safeguard Question Sub Category Name',
            'SafeguardQuestionCategoryID' => 'Safeguard Question Category ID',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
