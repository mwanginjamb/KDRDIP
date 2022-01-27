<?php

namespace app\models;

use common\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "payment_types".
 *
 * @property int $PaymentTypeID
 * @property string $PaymentTypeName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class PaymentTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_types';
    }


    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'CreatedBy',
                'updatedByAttribute' => false

            ],
            /*[
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'CreatedDate',
                'updatedAtAttribute' => false
            ]*/
        ];
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
            [['PaymentTypeName'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PaymentTypeID' => 'Payment Type ID',
            'PaymentTypeName' => 'Payment Type Name',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class,['UserID' => 'CreatedBy']);
    }
}
