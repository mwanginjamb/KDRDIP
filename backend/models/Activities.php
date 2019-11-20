<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activities".
 *
 * @property int $ActivityID
 * @property int $IndicatorID
 * @property string $ActivityName
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Activities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IndicatorID', 'CreatedBy', 'Deleted'], 'integer'],
            [['CreatedDate'], 'safe'],
            [['ActivityName'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ActivityID' => 'Activity ID',
            'IndicatorID' => 'Indicator ID',
            'ActivityName' => 'Activity Name',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
