<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectbeneficiaries".
 *
 * @property int $ProjectBeneficiaryID
 * @property int $CountyID
 * @property int $ProjectID
 * @property int $Beneficiaries
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
			[['CountyID', 'Beneficiaries', 'CreatedBy', 'Deleted', 'ProjectID'], 'integer'],
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
			'CountyID' => 'County',
			'ProjectID' => 'Project',
			'Beneficiaries' => 'Beneficiaries',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getCounties()
	{
		return $this->hasOne(Counties::className(), ['CountyID' => 'CountyID'])->from(counties::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
