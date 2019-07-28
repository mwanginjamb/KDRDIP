<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mpesatransactions".
 *
 * @property int $TransactionID
 * @property string $TransactionType
 * @property string $TransID
 * @property string $TransAmount
 * @property string $TransTime
 * @property string $BusinessShortCode
 * @property string $BillRefNumber
 * @property string $InvoiceNumber
 * @property string $OrgAccountBalance
 * @property string $ThirdPartyTransID
 * @property string $MSISDN
 * @property string $FirstName
 * @property string $MiddleName
 * @property string $LastName
 * @property int $TransactionStatusID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class MpesaTransactions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpesatransactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TransAmount', 'OrgAccountBalance'], 'number'],
            [['TransactionStatusID', 'CreatedBy', 'Deleted'], 'integer'],
            [['CreatedDate'], 'safe'],
            [['TransactionType', 'TransID', 'TransTime', 'BusinessShortCode', 'BillRefNumber', 'InvoiceNumber', 'ThirdPartyTransID', 'MSISDN', 'FirstName', 'MiddleName', 'LastName'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'TransactionID' => 'Transaction ID',
            'TransactionType' => 'Transaction Type',
            'TransID' => 'Trans ID',
            'TransAmount' => 'Trans Amount',
            'TransTime' => 'Trans Time',
            'BusinessShortCode' => 'Business Short Code',
            'BillRefNumber' => 'Bill Ref Number',
            'InvoiceNumber' => 'Invoice Number',
            'OrgAccountBalance' => 'Org Account Balance',
            'ThirdPartyTransID' => 'Third Party Trans ID',
            'MSISDN' => 'Msisdn',
            'FirstName' => 'First Name',
            'MiddleName' => 'Middle Name',
            'LastName' => 'Last Name',
            'TransactionStatusID' => 'Transaction Status ID',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
