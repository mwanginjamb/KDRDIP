<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "StockAdjustment".
 *
 * @property integer $StockAdjustmentID
 * @property integer $ProductID
 * @property integer $AdjustmentTypeID
 * @property integer $AdjustmentID
 * @property double $Quantity
 */
class StockAdjustment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stockadjustment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ProductID', 'AdjustmentTypeID', 'AdjustmentID'], 'integer'],
            [['Quantity'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StockAdjustmentID' => 'Stock Adjustment ID',
            'ProductID' => 'Product ID',
            'AdjustmentTypeID' => 'Adjustment Type ID',
            'AdjustmentID' => 'Adjustment ID',
            'Quantity' => 'Quantity',
        ];
    }
}
