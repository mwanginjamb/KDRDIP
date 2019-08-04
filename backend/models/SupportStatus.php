<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supportstatus".
 *
 * @property int $SupportStatusID
 * @property string $SupportStatusName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class SupportStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supportstatus';
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
            [['SupportStatusName'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SupportStatusID' => 'Support Status ID',
            'SupportStatusName' => 'Support Status Name',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
