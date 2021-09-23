<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organization_activities".
 *
 * @property int $OrganizationID
 * @property int $LivelihoodActivityID
 * @property string $CreatedDate
 * @property int|null $CreatedBy
 * @property int $Deleted
 *
 * @property Users $createdBy
 * @property LivelihoodActivities $livelihoodActivity
 * @property Organizations $organization
 */
class OrganizationActivities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization_activities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['OrganizationID', 'LivelihoodActivityID'], 'required'],
            [['OrganizationID', 'LivelihoodActivityID', 'CreatedBy', 'Deleted'], 'integer'],
            [['CreatedDate'], 'safe'],
            [['OrganizationID', 'LivelihoodActivityID'], 'unique', 'targetAttribute' => ['OrganizationID', 'LivelihoodActivityID']],
            [['CreatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['CreatedBy' => 'UserID']],
            [['LivelihoodActivityID'], 'exist', 'skipOnError' => true, 'targetClass' => LivelihoodActivities::className(), 'targetAttribute' => ['LivelihoodActivityID' => 'LivelihoodActivityID']],
            [['OrganizationID'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['OrganizationID' => 'OrganizationID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'OrganizationID' => 'Organization ID',
            'LivelihoodActivityID' => 'Livelihood Activity ID',
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
     * Gets query for [[LivelihoodActivity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLivelihoodActivity()
    {
        return $this->hasOne(LivelihoodActivities::className(), ['LivelihoodActivityID' => 'LivelihoodActivityID']);
    }

    /**
     * Gets query for [[Organization]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organizations::className(), ['OrganizationID' => 'OrganizationID']);
    }
}
