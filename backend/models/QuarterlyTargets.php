<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "quarterly_targets".
 *
 * @property int $id
 * @property int|null $targetID
 * @property int|null $Q1
 * @property int|null $Q2
 * @property int|null $Q3
 * @property int|null $Q4
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class QuarterlyTargets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quarterly_targets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['targetID', 'Q1', 'Q2', 'Q3', 'Q4', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'targetID' => 'Target ID',
            'Q1' => 'Q1',
            'Q2' => 'Q2',
            'Q3' => 'Q3',
            'Q4' => 'Q4',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
