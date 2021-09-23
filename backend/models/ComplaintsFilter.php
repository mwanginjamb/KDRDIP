<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ComplaintsFilter extends Model
{
	public $ComponentID;
	public $ProjectID;
	public $ComplaintTypeID;
	public $CountyID;
	public $SubCountyID;
	public $WardID;
	public $StartDate;
	public $EndDate;
	public $ComplaintStatusID;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [

			[['ComponentID', 'ProjectID', 'ComplaintTypeID', 'CountyID', 'SubCountyID', 'WardID', 'ComplaintStatusID'], 'integer'],
			[['StartDate', 'EndDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ComponentID' => 'Component',
			'ProjectID' => 'Sub Project',
			'ComplaintTypeID' => 'Complaint Type',
			'CountyID' => 'County',
			'SubCountyID' => 'Sub County',
			'WardID' => 'Ward',
			'ComplaintStatusID' => 'Complaint Status'
		];
	}
}
