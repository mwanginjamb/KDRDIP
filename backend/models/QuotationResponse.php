<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "QuotationResponse".
 *
 * @property integer $QuotationResponseID
 * @property integer $QuotationProductID
 * @property integer $SupplierID
 * @property string $UnitPrice
 */
class QuotationResponse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotationresponse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['QuotationProductID', 'SupplierID'], 'integer'],
            [['UnitPrice'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'QuotationResponseID' => 'Quotation Response ID',
            'QuotationProductID' => 'Quotation Product ID',
            'SupplierID' => 'Supplier ID',
            'UnitPrice' => 'Unit Price',
        ];
    }
}
