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
 * @property int $ProjectID
 * @property string $ComplaintSummary
 * @property string $ReliefSought
 * @property int $ComplaintTypeID
 * @property string $OfficerJustification
 * @property int $ComplaintStatusID
 * @property int $ComplaintTierID
 * @property int $ComplaintPriorityID
 * @property int $ComplaintChannelID
 * @property int $AssignedUserID
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
			[['ProjectID', 'CountryID', 'CountyID', 'SubCountyID', 'WardID', 'ComplaintTypeID', 'ComplaintStatusID', 'ComplaintTierID', 'ComplaintPriorityID', 'ComplaintChannelID', 'AssignedUserID', 'CreatedBy', 'Deleted'], 'integer'],
			[['IncidentDate', 'CreatedDate'], 'safe'],
			[['ComplaintSummary', 'ReliefSought', 'OfficerJustification', 'Resolution'], 'string'],
			[['ComplainantName', 'PostalAddress', 'PostalCode', 'Town', 'Village', 'Telephone', 'Mobile'], 'string', 'max' => 45],
			[['ComplainantName', 'ProjectID', 'CountyID', 'SubCountyID', 'WardID', 'ComplaintTypeID', 'ComplaintSummary', 'ReliefSought', 'IncidentDate', 'ComplaintPriorityID', 'ComplaintChannelID', 'ComplaintTierID'], 'required']
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
			'CountryID' => 'Country',
			'CountyID' => 'County',
			'SubCountyID' => 'Sub County',
			'WardID' => 'Ward',
			'Village' => 'Village',
			'Telephone' => 'Telephone',
			'Mobile' => 'Mobile',
			'IncidentDate' => 'Incident Date',
			'ProjectID' => 'Sub-Project',
			'ComplaintSummary' => 'Complaint Summary',
			'ReliefSought' => 'Relief Sought',
			'ComplaintTypeID' => 'Complaint Type',
			'OfficerJustification' => 'Officer Justification',
			'ComplaintStatusID' => 'Complaint Status',
			'ComplaintTierID' => 'Complaint Tier',
			'ComplaintPriorityID' => 'Complaint Priority',
			'ComplaintChannelID' => 'Complaint Channel',
			'AssignedUserID' => 'Assigned User',
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

	public function getCountries()
	{
		return $this->hasOne(Countries::className(), ['CountryID' => 'CountryID'])->from(countries::tableName());
	}

	public function getCounties()
	{
		return $this->hasOne(Counties::className(), ['CountyID' => 'CountyID'])->from(counties::tableName());
	}

	public function getSubCounties()
	{
		return $this->hasOne(SubCounties::className(), ['SubCountyID' => 'SubCountyID'])->from(subcounties::tableName());
	}

	public function getWards()
	{
		return $this->hasOne(Wards::className(), ['WardID' => 'WardID'])->from(wards::tableName());
	}

	public function getProjects()
	{
		return $this->hasOne(Projects::className(), ['ProjectID' => 'ProjectID'])->from(projects::tableName());
	}

	public function getComplaintTypes()
	{
		return $this->hasOne(ComplaintTypes::className(), ['ComplaintTypeID' => 'ComplaintTypeID'])->from(complainttypes::tableName());
	}

	public function getComplaintStatus()
	{
		return $this->hasOne(ComplaintStatus::className(), ['ComplaintStatusID' => 'ComplaintStatusID'])->from(complaintstatus::tableName());
	}

	public function getComplaintTiers()
	{
		return $this->hasOne(ComplaintTiers::className(), ['ComplaintTierID' => 'ComplaintTierID'])->from(complainttiers::tableName());
	}

	public function getComplaintPriorities()
	{
		return $this->hasOne(ComplaintPriorities::className(), ['ComplaintPriorityID' => 'ComplaintPriorityID'])->from(complaintpriorities::tableName());
	}

	public function getComplaintChannels()
	{
		return $this->hasOne(ComplaintChannels::className(), ['ComplaintChannelID' => 'ComplaintChannelID'])->from(complaintchannels::tableName());
	}

	public function getAssignedUser()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'AssignedUserID'])->from(['origin' => users::tableName()]);
	}

}
