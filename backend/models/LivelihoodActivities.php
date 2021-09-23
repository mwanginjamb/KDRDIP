<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "livelihood_activities".
 *
 * @property int $LivelihoodActivityID
 * @property string|null $LivelihoodActivityName
 * @property string|null $Code
 * @property string|null $Notes
 * @property string $CreatedDate
 * @property int|null $CreatedBy
 * @property int $Deleted
 *
 * @property Users $createdBy
 * @property OrganizationActivities[] $organizationActivities
 * @property Organizations[] $organizations
 */
class LivelihoodActivities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'livelihood_activities';
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
            [['LivelihoodActivityName', 'Code'], 'string', 'max' => 45],
            [['CreatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['CreatedBy' => 'UserID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LivelihoodActivityID' => 'Livelihood Activity ID',
            'LivelihoodActivityName' => 'Livelihood Activity Name',
            'Code' => 'Code',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
    }

    /**
     * Gets query for [[OrganizationActivities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationActivities()
    {
        return $this->hasMany(OrganizationActivities::className(), ['LivelihoodActivityID' => 'LivelihoodActivityID']);
    }

    /**
     * Gets query for [[Organizations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations()
    {
        return $this->hasMany(Organizations::className(), ['OrganizationID' => 'OrganizationID'])->viaTable('organization_activities', ['LivelihoodActivityID' => 'LivelihoodActivityID']);
    }
}
