<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organization_trainings".
 *
 * @property int $OrganizationTrainingID
 * @property int $OrganizationID
 * @property string $Date
 * 
 * @property string|null $Description
 * @property int|null $TotalAttendees
 * @property string|null $Facilitator
 * @property string|null $Agenda
 * @property string|null $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 * @property int $TrainingTypeId
 * @property Users $createdBy
 * @property Organizations $organization
 */
class OrganizationTrainings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization_trainings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['OrganizationID', 'Date', 'CreatedBy', 'TrainingTypeId'], 'required'],
            [['OrganizationID', 'TotalAttendees', 'CreatedBy', 'Deleted', 'TrainingTypeId'], 'integer'],
            [['Date', 'CreatedDate'], 'safe'],
            [['Agenda'], 'string'],
            [['Description', 'Facilitator'], 'string', 'max' => 200],
            [['CreatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['CreatedBy' => 'UserID']],
            [['OrganizationID'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['OrganizationID' => 'OrganizationID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'OrganizationTrainingID' => 'Organization Training ID',
            'OrganizationID' => 'Organization ID',
            'TrainingTypeId' => 'Training Type',
            'Date' => 'Date',
            'Description' => 'Description',
            'TotalAttendees' => 'Total Attendees',
            'Facilitator' => 'Facilitator',
            'Agenda' => 'Agenda',
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
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

    /**
     * Gets query for [[Organization]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingTypes()
    {
        return $this->hasOne(TrainingTypes::className(), ['TrainingTypeId' => 'TrainingTypeId']);
    }
}
