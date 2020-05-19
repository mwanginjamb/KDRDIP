<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lipw_master_roll_register".
 *
 * @property int $MasterRollRegisterID
 * @property int $BeneficiaryID
 * @property int $MasterRollID
 * @property string $Rate
 * @property string $DateAdded
 * @property int $Active
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class LipwMasterRollRegister extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'lipw_master_roll_register';
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
			[['BeneficiaryID', 'MasterRollID', 'Active', 'CreatedBy', 'Deleted'], 'integer'],
			[['Rate'], 'number'],
			[['DateAdded', 'CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'MasterRollRegisterID' => 'Master Roll Register ID',
			'BeneficiaryID' => 'Beneficiary ID',
			'MasterRollID' => 'Master Roll ID',
			'Rate' => 'Rate',
			'DateAdded' => 'Date Added',
			'Active' => 'Active',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
	}

	public function getLipwBeneficiaries()
	{
		return $this->hasOne(LipwBeneficiaries::className(), ['BeneficiaryID' => 'BeneficiaryID']);
	}

	public function getLipwMasterRoll()
	{
		return $this->hasOne(LipwMasterRoll::className(), ['MasterRollID' => 'MasterRollID']);
	}
}
