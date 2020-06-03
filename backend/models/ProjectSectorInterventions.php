<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_sector_interventions".
 *
 * @property int $SectorInterventionID
 * @property string $SectorInterventionName
 * @property int $ProjectSectorID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectSectorInterventions extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'project_sector_interventions';
	}

	public static function find()
	{
		return parent::find()->andWhere(['project_sector_interventions.Deleted' => 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		return $m->save();
	}

	public function save($runValidation = true, $attributeNames = null)
	{
		//this record is always new
		if ($this->isNewRecord) {
			$this->CreatedBy = Yii::$app->user->identity->UserID;
			// $this->CreatedDate = date('Y-m-d h:i:s');
		}
		return parent::save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectSectorID', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['SectorInterventionName'], 'string', 'max' => 45],
			[['Notes'], 'string'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'SectorInterventionID' => 'Sector Intervention ID',
			'SectorInterventionName' => 'Sector Intervention Name',
			'ProjectSectorID' => 'Project Sector',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getProjectSectors()
	{
		return $this->hasOne(ProjectSectors::className(), ['ProjectSectorID' => 'ProjectSectorID']);
	}
}
