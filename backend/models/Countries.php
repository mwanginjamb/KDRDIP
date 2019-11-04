<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property int $CountryID
 * @property string $CountryName
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property bool $Deleted
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CreatedDate'], 'safe'],
            [['CreatedBy'], 'integer'],
            [['Deleted'], 'boolean'],
            [['CountryName'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CountryID' => 'Country ID',
            'CountryName' => 'Country Name',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
