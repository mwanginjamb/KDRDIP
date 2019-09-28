<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectcomponents".
 *
 * @property int $ProjectComponentID
 * @property int $ProjectID
 * @property int $ComponentID
 * @property string $Cost
 * @property string $Code
 * @property string $Objective
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectComponents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projectcomponents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ProjectID', 'ComponentID', 'CreatedBy', 'Deleted'], 'integer'],
            [['Cost'], 'number'],
            [['Objective'], 'string'],
            [['CreatedDate'], 'safe'],
            [['Deleted'], 'required'],
            [['Code'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ProjectComponentID' => 'Project Component ID',
            'ProjectID' => 'Project ID',
            'ComponentID' => 'Component ID',
            'Cost' => 'Cost',
            'Code' => 'Code',
            'Objective' => 'Objective',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
