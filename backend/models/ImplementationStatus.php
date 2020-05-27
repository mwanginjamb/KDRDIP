<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "implementation_status".
 *
 * @property int $ImplementationStatusID
 * @property int $ProjectStatusID
 * @property int $ProjectID
 * @property string $Notes
 * @property string $Date
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ImplementationStatus extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'implementation_status';
	}
	
	public static function find()
	{
		return parent::find()->andWhere(['implementation_status.Deleted' => 0]);
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
			$this->CreatedDate = date('Y-m-d h:i:s');
		}
		return parent::save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectStatusID', 'ProjectID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Notes'], 'string'],
			[['Date', 'CreatedDate'], 'safe'],
			[['Date', 'ProjectStatusID'], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ImplementationStatusID' => 'Implementation Status ID',
			'ProjectStatusID' => 'Project Status',
			'ProjectID' => 'Project',
			'Notes' => 'Notes',
			'Date' => 'Date',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
	}

	public function getProjectStatus()
	{
		return $this->hasOne(ProjectStatus::className(), ['ProjectStatusID' => 'ProjectStatusID']);
	}
}
