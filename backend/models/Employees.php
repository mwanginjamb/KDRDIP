<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employees".
 *
 * @property int $EmployeeID
 * @property string $EmployeeNumber
 * @property int $DepartmentID
 * @property string $FirstName
 * @property string $MiddleName
 * @property string $LastName
 * @property string $PostalAddress
 * @property string $PostalCode
 * @property string $Town
 * @property int $CountryID
 * @property string $Telephone
 * @property string $Mobile
 * @property string $Email
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Employees extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'employees';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['DepartmentID', 'CountryID', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['EmployeeNumber', 'FirstName', 'MiddleName', 'LastName', 'PostalAddress', 'PostalCode', 'Town', 'Telephone', 'Mobile', 'Email'], 'string', 'max' => 45],
			[['EmployeeNumber', 'FirstName', 'LastName', 'DepartmentID'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'EmployeeID' => 'Employee ID',
			'EmployeeNumber' => 'Employee Number',
			'DepartmentID' => 'Department ID',
			'FirstName' => 'First Name',
			'MiddleName' => 'Middle Name',
			'LastName' => 'Last Name',
			'PostalAddress' => 'Postal Address',
			'PostalCode' => 'Postal Code',
			'Town' => 'Town',
			'CountryID' => 'Country ID',
			'Telephone' => 'Telephone',
			'Mobile' => 'Mobile',
			'Email' => 'Email',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getDepartments()
	{
		return $this->hasOne(Departments::className(), ['DepartmentID' => 'DepartmentID'])->from(departments::tableName());
	}

	public function getCountries()
	{
		return $this->hasOne(Countries::className(), ['CountryID' => 'CountryID'])->from(countries::tableName());
	}

	public function getEmployeeName()
	{
		return $this->FirstName . ' ' . $this->MiddleName . ' ' . $this->LastName;
	}
}
