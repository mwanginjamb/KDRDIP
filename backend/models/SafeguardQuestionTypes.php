<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "safeguard_question_types".
 *
 * @property int $SafeguardQuestionTypeID
 * @property string $SafeguardQuestionTypeName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class SafeguardQuestionTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safeguard_question_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SafeguardQuestionTypeName'], 'required'],
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['CreatedBy', 'Deleted'], 'integer'],
            [['SafeguardQuestionTypeName'], 'string', 'max' => 200],
            [['SafeguardQuestionTypeName'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SafeguardQuestionTypeID' => 'Safeguard Question Type ID',
            'SafeguardQuestionTypeName' => 'Safeguard Question Type Name',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
