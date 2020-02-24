<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documenttypes".
 *
 * @property int $DocumentTypeID
 * @property string $DocumentTypeName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class DocumentTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documenttypes';
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
            [['DocumentTypeName'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'DocumentTypeID' => 'Document Type ID',
            'DocumentTypeName' => 'Document Type Name',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
