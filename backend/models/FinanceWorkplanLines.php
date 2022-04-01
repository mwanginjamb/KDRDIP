<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "finance_workplan_lines".
 *
 * @property int $id
 * @property int|null $workplan_id
 * @property string|null $subproject
 * @property string|null $financial_year
 * @property string|null $period
 * @property string|null $sector
 * @property string|null $component
 * @property string|null $subcomponent
 * @property string|null $county
 * @property string|null $subcounty
 * @property string|null $ward
 * @property string|null $village
 * @property string|null $site
 * @property string|null $Ha-No
 * @property float|null $project_cost
 * @property string|null $remark
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $created_by
 */
class FinanceWorkplanLines extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance_workplan_lines';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['workplan_id', 'created_at', 'updated_at', 'updated_by', 'created_by'], 'integer'],
            [['project_cost'], 'number'],
            [['remark'], 'string'],
            [['subproject', 'financial_year', 'sector', 'component', 'subcomponent', 'county', 'subcounty', 'ward', 'village'], 'string', 'max' => 150],
            [['period'], 'string', 'max' => 10],
            [['site'], 'string', 'max' => 100],
            ['Ha-No', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'workplan_id' => 'Workplan ID',
            'subproject' => 'Subproject',
            'financial_year' => 'Financial Year',
            'period' => 'Period',
            'sector' => 'Sector',
            'component' => 'Component',
            'subcomponent' => 'Subcomponent',
            'county' => 'County',
            'subcounty' => 'Subcounty',
            'ward' => 'Ward',
            'village' => 'Village',
            'site' => 'Site',
            'Ha-No' => 'Ha No',
            'project_cost' => 'Project Cost',
            'remark' => 'Remark',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'created_by' => 'Created By',
        ];
    }

    public function getProject()
    {
        return $this->hasOne(Projects::className(), ['ProjectID' => 'subproject'])->from(['parentProject' => projects::tableName()]);
    }
}
