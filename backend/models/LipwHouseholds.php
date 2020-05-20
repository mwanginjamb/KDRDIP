<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lipw_households".
 *
 * @property int $HouseholdID
 * @property string $HouseholdName
 * @property int $SubLocationID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class LipwHouseholds extends \yii\db\ActiveRecord
{
	public $CountyID;
	public $SubCountyID;
	public $LocationID;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'lipw_households';
	}

	public static function find()
	{
		return parent::find()->andWhere(['lipw_households.Deleted' => 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->deleted = 1;
		$m->deletedTime = time();
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
			[['HouseholdName'], 'string', 'max' => 45],
			[['SubLocationID', 'HouseholdName', 'CountyID', 'SubCountyID', 'LocationID'], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'HouseholdID' => 'Household ID',
			'HouseholdName' => 'Household Name',
			'SubLocationID' => 'Village',
			'CountyID' => 'County',
			'SubCountyID' => 'Sub County',
			'LocationID' => 'Location',
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
