<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property int $PageID
 * @property string $PageName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages';
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
            [['PageName'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PageID' => 'Page ID',
            'PageName' => 'Page Name',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
