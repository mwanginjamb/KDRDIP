<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kobo".
 *
 * @property int $KoboID
 * @property int $ProjectID
 * @property string $Content
 * @property string $CreatedDate
 * @property int $Deleted
 */
class Kobo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kobo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['KoboID', 'ProjectID'], 'required'],
            [['KoboID', 'ProjectID', 'Deleted'], 'integer'],
            [['Content'], 'string'],
            [['CreatedDate'], 'safe'],
            [['KoboID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'KoboID' => 'Kobo ID',
            'ProjectID' => 'Project ID',
            'Content' => 'Content',
            'CreatedDate' => 'Created Date',
            'Deleted' => 'Deleted',
        ];
    }
}
