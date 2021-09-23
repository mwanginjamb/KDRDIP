<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "training_types".
 *
 * @property int $TrainingTypeId
 * @property string $TrainingTypeName
 * @property string|null $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 *
 * @property Users $createdBy
 */
class TrainingTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'training_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TrainingTypeName', 'CreatedBy'], 'required'],
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['CreatedBy', 'Deleted'], 'integer'],
            [['TrainingTypeName'], 'string', 'max' => 45],
            [['TrainingTypeName'], 'unique'],
            [['CreatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['CreatedBy' => 'UserID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'TrainingTypeId' => 'Training Type ID',
            'TrainingTypeName' => 'Training Type Name',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
    }
}
