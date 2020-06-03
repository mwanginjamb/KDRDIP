<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lipw_master_roll".
 *
 * @property int $MasterRollID
 * @property int $SubLocationID
 * @property string $MasterRollName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class LipwMasterRoll extends \yii\db\ActiveRecord
{
	public $CountyID;
	public $SubCountyID;
	public $LocationID;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'lipw_master_roll';
	}

	public static function find()
	{
		return parent::find()->andWhere(['lipw_master_roll.Deleted' => 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		// $m->deletedTime = time();
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
			[['SubLocationID', 'CreatedBy', 'Deleted', 'CountyID', 'SubCountyID', 'LocationID'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['MasterRollName'], 'string', 'max' => 45],
			[['SubLocationID', 'MasterRollName', 'CountyID', 'SubCountyID', 'LocationID'], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'MasterRollID' => 'Master Roll ID',
			'SubLocationID' => 'Village',
			'MasterRollName' => 'Master Roll Name',
			'CountyID' => 'County',
			'SubCountyID' => 'Sub County',
			'LocationID' => 'Ward',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
	}

	public function getSubLocations()
	{
		return $this->hasOne(SubLocations::className(), ['SubLocationID' => 'SubLocationID']);
	}
}
