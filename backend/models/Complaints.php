<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "complaints".
 *
 * @property int $ComplaintID
 * @property string $ComplainantName
 * @property string $PostalAddress
 * @property string $PostalCode
 * @property string $Town
 * @property int $CountryID
 * @property int $CountyID
 * @property int $SubCountyID
 * @property int $WardID
 * @property string $Village
 * @property string $Telephone
 * @property string $Mobile
 * @property string $IncidentDate
 * @property string $ComplaintSummary
 * @property string $ReliefSought
 * @property int $ComplaintTypeID
 * @property string $OfficerJustification
 * @property int $ComplaintStatusID
 * @property int $ComplaintTierID
 * @property int $AssignedUserID
 * @property int $ComplaintPriorityID
 * @property string $Resolution
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */
class Complaints extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'complaints';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['CountryID', 'CountyID', 'SubCountyID', 'WardID', 'ComplaintTypeID', 'ComplaintStatusID', 'ComplaintTierID', 'AssignedUserID', 'ComplaintPriorityID', 'CreatedBy', 'Deleted'], 'integer'],
			[['IncidentDate', 'CreatedDate'], 'safe'],
			[['ComplaintSummary', 'ReliefSought', 'OfficerJustification', 'Resolution'], 'string'],
			[['ComplainantName', 'PostalAddress', 'PostalCode', 'Town', 'Village', 'Telephone', 'Mobile'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ComplaintID' => 'Complaint ID',
			'ComplainantName' => 'Complainant Name',
			'PostalAddress' => 'Postal Address',
			'PostalCode' => 'Postal Code',
			'Town' => 'Town',
			'CountryID' => 'Country ID',
			'CountyID' => 'County ID',
			'SubCountyID' => 'Sub County ID',
			'WardID' => 'Ward ID',
			'Village' => 'Village',
			'Telephone' => 'Telephone',
			'Mobile' => 'Mobile',
			'IncidentDate' => 'Incident Date',
			'ComplaintSummary' => 'Complaint Summary',
			'ReliefSought' => 'Relief Sought',
			'ComplaintTypeID' => 'Complaint Type ID',
			'OfficerJustification' => 'Officer Justification',
			'ComplaintStatusID' => 'Complaint Status ID',
			'ComplaintTierID' => 'Complaint Tier ID',
			'AssignedUserID' => 'Assigned User ID',
			'ComplaintPriorityID' => 'Complaint Priority ID',
			'Resolution' => 'Resolution',
			'CreatedBy' => 'Created By',
			'CreatedDate' => 'Created Date',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
