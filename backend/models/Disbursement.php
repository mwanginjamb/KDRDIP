<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disbursement".
 *
 * @property int $DisbursementID
 * @property int $Year
 * @property int $EnterpriseTypeID
 * @property int $EnterpriseID
 * @property string $Date
 * @property string $Amount
 * @property int $Quarter
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Disbursement extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'disbursement';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'disbursement.deleted', 0]);
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
			[['Year', 'EnterpriseTypeID', 'EnterpriseID', 'CreatedBy', 'Deleted', 'Quarter'], 'integer'],
			[['Date', 'CreatedDate'], 'safe'],
			[['Amount'], 'number'],
			[['Year', 'EnterpriseTypeID', 'EnterpriseID', 'Quarter', 'Date', 'Amount'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'DisbursementID' => 'Disbursement ID',
			'Year' => 'Year',
			'EnterpriseTypeID' => 'Enterprise Type ID',
			'EnterpriseID' => 'Enterprise ID',
			'Date' => 'Date',
			'Amount' => 'Amount',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'Quarter' => 'Quarter',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
