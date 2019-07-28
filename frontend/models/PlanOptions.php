<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "planoptions".
 *
 * @property int $PlanOptionID
 * @property string $PlanOptionName
 * @property string $Notes
 * @property int $PlanID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class PlanOptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'planoptions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Notes'], 'string'],
            [['PlanID', 'CreatedBy', 'Deleted'], 'integer'],
            [['CreatedDate'], 'safe'],
            [['PlanOptionName'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PlanOptionID' => 'Plan Option ID',
            'PlanOptionName' => 'Plan Option Name',
            'Notes' => 'Notes',
            'PlanID' => 'Plan ID',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
