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
 * @property int $SubLocationID
 * @property string $Village
 * @property string $Telephone
 * @property string $Mobile
 * @property string $IncidentDate
 * @property string $ClosedDate
 * @property int $Closed
 * @property int $ClosedBy
 * @property string $ResolutionDate
 * @property int $ResolvedBy
 * @property int $ProjectID
 * @property string $ComplaintSummary
 * @property string $ReliefSought
 * @property int $ComplaintTypeID
 * @property string $OfficerJustification
 * @property int $ComplaintStatusID
 * @property int $ComplaintTierID
 * @property int $ComplaintPriorityID
 * @property int $ComplaintChannelID
 * @property int $AssignedTo
 * @property string $Resolution
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */

class Complaints extends \yii\db\ActiveRecord
{
	public $imageFile;
	public $DocumentDescription;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'complaints';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'complaints.Deleted', 0]);
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
			[['ProjectID', 'CountryID', 'CountyID', 'SubCountyID', 'WardID', 'SubLocationID', 'ComplaintTypeID', 'ComplaintStatusID', 'ComplaintTierID', 'ComplaintPriorityID', 'ComplaintChannelID', 'AssignedTo', 'CreatedBy', 'Deleted', 'ClosedBy', 'ResolvedBy', 'Closed'], 'integer'],
			[['IncidentDate', 'CreatedDate', 'ClosedDate', 'ResolutionDate'], 'safe'],
			[['ComplaintSummary', 'ReliefSought', 'OfficerJustification', 'Resolution', 'DocumentDescription'], 'string'],
			[['ComplainantName', 'PostalAddress', 'PostalCode', 'Town', 'Village', 'Telephone', 'Mobile'], 'string', 'max' => 45],
			[['ComplainantName', 'ProjectID', 'CountyID', 'SubCountyID', 'WardID', 'ComplaintTypeID', 'ComplaintSummary', 'ReliefSought', 'IncidentDate', 'ComplaintPriorityID', 'ComplaintChannelID', 'ComplaintTierID'], 'required'],
			[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf'],
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
			'SubLocationID' => 'Village',
			'Village' => 'Village',
			'Telephone' => 'Telephone',
			'Mobile' => 'Mobile',
			'IncidentDate' => 'Incident Date',
			'ClosedDate' => 'Closed Date',
			'ClosedBy' => 'Closed By',
			'ResolvedBy' => 'Resolved By',
			'Closed' => 'Closed',
			'DocumentDescription' => 'Document Description',
			'ResolutionDate' => 'Resolution Date',
			'ProjectID' => 'Sub-Project',
			'ComplaintSummary' => 'Complaint Summary',
			'ReliefSought' => 'Relief Sought',
			'ComplaintTypeID' => 'Complaint Type',
			'OfficerJustification' => 'Officer Justification',
			'ComplaintStatusID' => 'Complaint Status',
			'ComplaintTierID' => 'Complaint Tier',
			'ComplaintPriorityID' => 'Complaint Priority',
			'ComplaintChannelID' => 'Complaint Channel',
			'AssignedTo' => 'Assigned User',
			'Resolution' => 'Resolution',
			'CreatedBy' => 'Created By',
			'CreatedDate' => 'Created Date',
			'Deleted' => 'Deleted',
		];
	}

	public function formatImage()
	{
		$tmpfile_contents = file_get_contents($this->imageFile->tempName);
		$type = $this->imageFile->type;
		return 'data:' . $type . ';base64,' . base64_encode($tmpfile_contents);
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
		return $this->hasOne(Users::className(), ['UserID' => 'AssignedTo'])->from(['origin' => users::tableName()]);
	}

	public function getClosedBy()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'ClosedBy'])->from(['closedBy' => users::tableName()]);
	}

	public function getResolvedBy()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'ResolvedBy'])->from(['resolvedby' => users::tableName()]);
	}

	public function getSubLocations()
	{
		return $this->hasOne(SubLocations::className(), ['SubLocationID' => 'SubLocationID']);
	}

		/**
	* Gets query for [[ComplaintAge]].
	*
	* @return \yii\db\ActiveQuery
	*/
	public function getComplaintAge()
	{
		return round((time() - strtotime($this->CreatedDate)) / (60*60*24));
	}
}
