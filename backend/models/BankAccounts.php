<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bankaccounts".
 *
 * @property int $BankAccountID
 * @property int $BankID
 * @property int $BranchID
 * @property string $AccountName
 * @property string $AccountNumber
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class BankAccounts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bankaccounts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BankID', 'BranchID', 'CreatedBy', 'Deleted'], 'integer'],
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['AccountName', 'AccountNumber'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'BankAccountID' => 'Bank Account ID',
            'BankID' => 'Bank ID',
            'BranchID' => 'Branch ID',
            'AccountName' => 'Account Name',
            'AccountNumber' => 'Account Number',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
