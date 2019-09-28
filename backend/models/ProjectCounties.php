<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectcounties".
 *
 * @property int $ProjectCountyID
 * @property int $ProjectID
 * @property int $CountyID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectCounties extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projectcounties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ProjectID', 'CountyID', 'CreatedBy', 'Deleted'], 'integer'],
            [['CreatedDate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ProjectCountyID' => 'Project County ID',
            'ProjectID' => 'Project ID',
            'CountyID' => 'County ID',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
