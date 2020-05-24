<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectbeneficiaries".
 *
 * @property int $ProjectBeneficiaryID
 * @property int $ProjectID
 * @property int $CountyID
 * @property int $SubCountyID
 * @property int $HostPopulation
 * @property int $RefugeePopulation
 * @property string $Gender
 * @property string $CreatedDate
 * @property int $CreatedBy
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

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectID', 'CountyID', 'SubCountyID', 'HostPopulation', 'RefugeePopulation', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['Gender'], 'string', 'max' => 1],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectBeneficiaryID' => 'Project Beneficiary ID',
			'ProjectID' => 'Project ID',
			'CountyID' => 'County ID',
			'SubCountyID' => 'Sub County ID',
			'HostPopulation' => 'Host Population',
			'RefugeePopulation' => 'Refugee Population',
			'Gender' => 'Gender',
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
