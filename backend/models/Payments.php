<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property int $PaymentID
 * @property string $PaymentDate
 * @property string $Amount
 * @property int $ProfileID
 * @property int $PlanID
 * @property int $PlanOptionID
 * @property string $TransID
 * @property int $PaymentMethodID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Payments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PaymentDate', 'CreatedDate'], 'safe'],
            [['Amount'], 'number'],
            [['ProfileID', 'PlanID', 'PlanOptionID', 'PaymentMethodID', 'CreatedBy', 'Deleted'], 'integer'],
            [['TransID'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PaymentID' => 'Payment ID',
            'PaymentDate' => 'Payment Date',
            'Amount' => 'Amount',
            'ProfileID' => 'Profile ID',
            'PlanID' => 'Plan ID',
            'PlanOptionID' => 'Plan Option ID',
            'TransID' => 'Trans ID',
            'PaymentMethodID' => 'Payment Method ID',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
