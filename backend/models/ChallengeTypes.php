<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "challenge_types".
 *
 * @property int $ChallengeTypeID
 * @property string $ChallengeTypeName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ChallengeTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'challenge_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ChallengeTypeName'], 'required'],
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['CreatedBy', 'Deleted'], 'integer'],
            [['ChallengeTypeName'], 'string', 'max' => 45],
            [['ChallengeTypeName'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ChallengeTypeID' => 'Challenge Type ID',
            'ChallengeTypeName' => 'Challenge Type Name',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
