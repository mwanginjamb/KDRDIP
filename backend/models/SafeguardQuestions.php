<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "safeguard_questions".
 *
 * @property int $SafeguardQuestionID
 * @property string $SafeguardQuestion
 * @property int $SafeguardQuestionCategoryID
 * @property string $SafeguardQuestionSubCategoryID
 * @property int $SafeguardQuestionTypeID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class SafeguardQuestions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safeguard_questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SafeguardQuestion', 'SafeguardQuestionCategoryID', 'SafeguardQuestionTypeID'], 'required'],
            [['SafeguardQuestion'], 'string'],
            [['SafeguardQuestionCategoryID', 'SafeguardQuestionTypeID', 'CreatedBy', 'Deleted'], 'integer'],
            [['CreatedDate'], 'safe'],
            [['SafeguardQuestionSubCategoryID'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SafeguardQuestionID' => 'Safeguard Question ID',
            'SafeguardQuestion' => 'Safeguard Question',
            'SafeguardQuestionCategoryID' => 'Safeguard Question Category ID',
            'SafeguardQuestionSubCategoryID' => 'Safeguard Question Sub Category ID',
            'SafeguardQuestionTypeID' => 'Safeguard Question Type ID',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
