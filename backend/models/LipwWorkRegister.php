<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lipw_work_register".
 *
 * @property int $WorkRegisterID
 * @property int $MasterRollID
 * @property int $BeneficiaryID
 * @property string $Date
 * @property string $Amount
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class LipwWorkRegister extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'lipw_work_register';
	}

	public static function find()
	{
		return parent::find()->andWhere(['lipw_work_register.Deleted' => 0]);
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
			$this->createdBy = Yii::$app->user->identity->userId;
			$this->createdDate = date('Y-m-d h:i:s');
		}
		return parent::save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['MasterRollID', 'BeneficiaryID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Date', 'CreatedDate'], 'safe'],
			[['Amount'], 'number'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'WorkRegisterID' => 'Work Register ID',
			'MasterRollID' => 'Master Roll ID',
			'BeneficiaryID' => 'Beneficiary ID',
			'Date' => 'Date',
			'Amount' => 'Amount',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
	}

	public function getLipwMasterRoll()
	{
		return $this->hasOne(LipwMasterRoll::className(), ['MasterRollID' => 'MasterRollID']);
	}

	public function getLipwBeneficiaries()
	{
		return $this->hasOne(LipwBeneficiaries::className(), ['BeneficiaryID' => 'BeneficiaryID']);
	}
}
