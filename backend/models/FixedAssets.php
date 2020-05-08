<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fixedassets".
 *
 * @property int $FixedAssetID
 * @property string $AssetNo
 * @property string $Description
 * @property int $ProjectID
 * @property string $Location
 * @property string $SerialNumber
 * @property int $EmployeeID
 * @property int $UnitID
 * @property int $AssetAllocationID
 * @property string $AcquisitionDate
 * @property string $Value
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class FixedAssets extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'fixedassets';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectID', 'EmployeeID', 'CreatedBy', 'Deleted', 'AssetAllocationID', 'UnitID'], 'integer'],
			[['AcquisitionDate', 'CreatedDate'], 'safe'],
			[['Value'], 'number'],
			[['AssetNo', 'SerialNumber'], 'string', 'max' => 45],
			[['Description'], 'string', 'max' => 500],
			[['Location'], 'string', 'max' => 300],
			[['AssetNo', 'SerialNumber', 'Description', 'AcquisitionDate', 'Value', 'AssetAllocationID'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'FixedAssetID' => 'Asset ID',
			'AssetNo' => 'Asset No',
			'Description' => 'Description',
			'ProjectID' => 'Project',
			'Location' => 'Location',
			'SerialNumber' => 'Serial Number',
			'EmployeeID' => 'Custodian',
			'AcquisitionDate' => 'Acquisition Date',
			'AssetAllocationID' => 'Asset Allocation',
			'Value' => 'Value',
			'UnitID' => 'Unit',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getEmployees()
	{
		return $this->hasOne(Employees::className(), ['EmployeeID' => 'EmployeeID'])->from(employees::tableName());
	}

	public function getProjects()
	{
		return $this->hasOne(Projects::className(), ['ProjectID' => 'ProjectID'])->from(projects::tableName());
	}

	public function getAssetAllocation()
	{
		return $this->hasOne(AssetAllocation::className(), ['AssetAllocationID' => 'AssetAllocationID'])->from(assetallocation::tableName());
	}
}
