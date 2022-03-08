<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lipw_households".
 *
 * @property int $HouseholdID
 * @property string $HouseholdName
 * @property int $SubLocationID
 * @property int $TotalBeneficiaries
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 * @property int $mpesa_account_no
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
			[['SubLocationID', 'CreatedBy', 'Deleted', 'CountyID', 'SubCountyID', 'LocationID', 'TotalBeneficiaries','mpesa_account_no'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['HouseholdName'], 'string', 'max' => 45],
			[['HouseholdName', 'mpesa_account_no'], 'unique'],
			[['SubLocationID', 'HouseholdName', 'CountyID', 'SubCountyID', 'LocationID', 'TotalBeneficiaries'], 'required'],
			['mpesa_account_no', 'validateMpesa'],
		];
	}

	public function validateMpesa($attribute)
	{
		if (!preg_match('/^[0-9]{10}$/', $this->$attribute)) {
			$this->addError($attribute, $attribute.' must contain exactly 10 digits.');
		}
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
			'LocationID' => 'Ward',
			'Notes' => 'Notes',
			'TotalBeneficiaries' => 'Total Beneficiaries',
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
