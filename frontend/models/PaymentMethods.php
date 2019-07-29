<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paymentmethods".
 *
 * @property int $PaymentMethodID
 * @property string $PaymentMethodName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class PaymentMethods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paymentmethods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PaymentMethodID'], 'required'],
            [['PaymentMethodID', 'CreatedBy', 'Deleted'], 'integer'],
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['PaymentMethodName'], 'string', 'max' => 45],
            [['PaymentMethodID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PaymentMethodID' => 'Payment Method ID',
            'PaymentMethodName' => 'Payment Method Name',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
