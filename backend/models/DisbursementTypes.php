<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disbursement_types".
 *
 * @property int $DisbursementTypeID
 * @property string $DisbursementTypeName
 * @property string|null $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 *
 * @property Users $createdBy
 */
class DisbursementTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'disbursement_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DisbursementTypeName', 'CreatedBy'], 'required'],
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['CreatedBy', 'Deleted'], 'integer'],
            [['DisbursementTypeName'], 'string', 'max' => 45],
            [['DisbursementTypeName'], 'unique'],
            [['CreatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['CreatedBy' => 'UserID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'DisbursementTypeID' => 'Disbursement Type ID',
            'DisbursementTypeName' => 'Disbursement Type',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
    }
}
