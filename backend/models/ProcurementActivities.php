<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "procurement_activities".
 *
 * @property int $ProcurementActivityID
 * @property string $ProcurementActivityName
 * @property string $Comments
 * @property string $CreatedDate
 * @property string $UpdatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProcurementActivities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procurement_activities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Comments'], 'string'],
            [['CreatedDate', 'UpdatedDate'], 'safe'],
            [['CreatedBy', 'Deleted'], 'integer'],
            [['ProcurementActivityName'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ProcurementActivityID' => 'Procurement Activity ID',
            'ProcurementActivityName' => 'Procurement Activity Name',
            'Comments' => 'Comments',
            'CreatedDate' => 'Created Date',
            'UpdatedDate' => 'Updated Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
