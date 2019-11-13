<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quotationtypes".
 *
 * @property int $QuotationTypeID
 * @property string $QuotationTypeName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class QuotationTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quotationtypes';
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
            [['QuotationTypeName'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'QuotationTypeID' => 'Quotation Type ID',
            'QuotationTypeName' => 'Quotation Type Name',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
