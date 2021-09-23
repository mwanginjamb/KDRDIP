<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "procurement_activity_lines".
 *
 * @property int $ProcurementActivityLineID
 * @property int $ProcurementPlanLineID
 * @property int $ProcurementActivityID
 * @property string $PlannedDate
 * @property int $PlannedDays
 * @property string $ActualStartDate
 * @property string $ActualClosingDate
 * @property string $image
 * @property string $Comments
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property string $UpdatedDate
 * @property int $Deleted
 */
class ProcurementActivityLines extends \yii\db\ActiveRecord
{
	public $imageFile;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'procurement_activity_lines';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProcurementPlanLineID', 'ProcurementActivityID', 'PlannedDays', 'CreatedBy', 'Deleted'], 'integer'],
			[['PlannedDate', 'ActualStartDate', 'ActualClosingDate', 'CreatedDate', 'UpdatedDate'], 'safe'],
			[['Comments', 'image'], 'string'],
			[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProcurementActivityLineID' => 'Procuement Activity Line ID',
			'ProcurementPlanLineID' => 'Procurement Plan ID',
			'ProcurementActivityID' => 'Procurement Plan Activity ID',
			'PlannedDate' => 'Planned Date',
			'PlannedDays' => 'Planned Days',
			'ActualStartDate' => 'Actual Start Date',
			'ActualClosingDate' => 'Actual Closing Date',
			'Comments' => 'Comments',
			'image' => 'Image',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'UpdatedDate' => 'Updated Date',
			'Deleted' => 'Deleted',
		];
	}

	public function getActualDays()
	{
		return 4;
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

	public function getProcurementActivities()
	{
		return $this->hasOne(ProcurementActivities::className(), ['ProcurementActivityID' => 'ProcurementActivityID']);
	}

	public function getProcurementPlanLines()
	{
		return $this->hasOne(ProcurementPlanLines::className(), ['ProcurementPlanLineID' => 'ProcurementPlanLineID']);
	}
}
