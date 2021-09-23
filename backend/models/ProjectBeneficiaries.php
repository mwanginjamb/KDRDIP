<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectbeneficiaries".
 *
 * @property int $ProjectBeneficiaryID
 * @property int|null $ProjectID
 * @property int|null $CountyID
 * @property int|null $SubCountyID
 * @property int|null $HostPopulationMale
 * @property int|null $RefugeePopulationMale
 * @property int|null $HostPopulationFemale
 * @property int|null $RefugeePopulationFemale
 * @property int|null $MinorityClans
 * @property int|null $Women
 * @property int|null $Youth
 * @property int|null $Minority
 * @property int|null $Men
 * @property string $CreatedDate
 * @property int|null $CreatedBy
 * @property int $Deleted
 */
class ProjectBeneficiaries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projectbeneficiaries';
    }
    
	public static function find()
	{
		return parent::find()->andWhere(['=', 'projectbeneficiaries.Deleted', 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		// $m->deletedTime = time();
		return $m->save();
	}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ProjectID', 'CountyID', 'SubCountyID', 'HostPopulationMale', 'RefugeePopulationMale', 'HostPopulationFemale', 'RefugeePopulationFemale', 'MinorityClans', 'Women', 'Youth', 'Minority', 'Men', 'CreatedBy', 'Deleted'], 'integer'],
            [['CreatedDate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ProjectBeneficiaryID' => 'Project Beneficiary ID',
            'ProjectID' => 'Project',
            'CountyID' => 'County',
            'SubCountyID' => 'Sub County',
            'HostPopulationMale' => 'Host Population Male',
            'RefugeePopulationMale' => 'Refugee Population Male',
            'HostPopulationFemale' => 'Host Population Female',
            'RefugeePopulationFemale' => 'Refugee Population Female',
            'MinorityClans' => 'Minority Clans',
            'Women' => 'Women',
            'Youth' => 'Youth',
            'Minority' => 'Minority',
            'Men' => 'Men',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }

    public function getCounties()
	{
		return $this->hasOne(Counties::className(), ['CountyID' => 'CountyID'])->from(counties::tableName());
	}

	public function getSubCounties()
	{
		return $this->hasOne(SubCounties::className(), ['SubCountyID' => 'SubCountyID'])->from(subcounties::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
