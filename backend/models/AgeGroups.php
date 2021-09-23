<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "age_groups".
 *
 * @property int $AgeGroupID
 * @property string $AgeGroupName
 * @property string|null $Notes
 * @property string|null $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 *
 * @property Users $createdBy
 * @property OrganizationMembers[] $organizationMembers
 */
class AgeGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'age_groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AgeGroupName', 'CreatedBy'], 'required'],
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['CreatedBy', 'Deleted'], 'integer'],
            [['AgeGroupName'], 'string', 'max' => 45],
            [['AgeGroupName'], 'unique'],
            [['CreatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['CreatedBy' => 'UserID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'AgeGroupID' => 'Age Group ID',
            'AgeGroupName' => 'Age Group Name',
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
     * Gets query for [[OrganizationMembers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationMembers()
    {
        return $this->hasMany(OrganizationMembers::className(), ['AgeGroupID' => 'AgeGroupID']);
    }
}
