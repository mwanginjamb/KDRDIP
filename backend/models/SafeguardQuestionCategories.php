<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "safeguard_question_categories".
 *
 * @property int $SafeguardQuestionCategoryID
 * @property string $SafeguardQuestionCategoryName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class SafeguardQuestionCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safeguard_question_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SafeguardQuestionCategoryName'], 'required'],
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['CreatedBy', 'Deleted'], 'integer'],
            [['SafeguardQuestionCategoryName'], 'string', 'max' => 200],
            [['SafeguardQuestionCategoryName'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SafeguardQuestionCategoryID' => 'Safeguard Question Category ID',
            'SafeguardQuestionCategoryName' => 'Safeguard Question Category Name',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
