<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "safeguard_question_options".
 *
 * @property int $SafeguardQuestionOptionID
 * @property string $SafeguardQuestionOptionName
 * @property int $SafeguardQuestionID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class SafeguardQuestionOptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safeguard_question_options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SafeguardQuestionOptionName', 'SafeguardQuestionID'], 'required'],
            [['SafeguardQuestionID', 'CreatedBy', 'Deleted'], 'integer'],
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['SafeguardQuestionOptionName'], 'string', 'max' => 1000],
            [['SafeguardQuestionOptionName'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SafeguardQuestionOptionID' => 'Safeguard Question Option ID',
            'SafeguardQuestionOptionName' => 'Safeguard Question Option Name',
            'SafeguardQuestionID' => 'Safeguard Question ID',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
