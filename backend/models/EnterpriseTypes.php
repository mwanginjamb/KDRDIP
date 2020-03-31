<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "enterprisetypes".
 *
 * @property int $EnterpriseTypeID
 * @property string $EnterpriseTypeName
 * @property string $ShortName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleed
 */
class EnterpriseTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'enterprisetypes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['CreatedBy', 'Deleed'], 'integer'],
            [['EnterpriseTypeName'], 'string', 'max' => 100],
            [['ShortName'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'EnterpriseTypeID' => 'Enterprise Type ID',
            'EnterpriseTypeName' => 'Enterprise Type Name',
            'ShortName' => 'Short Name',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleed' => 'Deleed',
        ];
    }
}
