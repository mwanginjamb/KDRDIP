<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documents".
 *
 * @property int $DocumentID
 * @property string $Description
 * @property string $FileName
 * @property int $DocumentTypeID
 * @property int $RefNumber
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Documents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DocumentTypeID', 'RefNumber', 'CreatedBy', 'Deleted'], 'integer'],
            [['CreatedDate'], 'safe'],
            [['Description', 'FileName'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'DocumentID' => 'Document ID',
            'Description' => 'Description',
            'FileName' => 'File Name',
            'DocumentTypeID' => 'Document Type ID',
            'RefNumber' => 'Ref Number',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
