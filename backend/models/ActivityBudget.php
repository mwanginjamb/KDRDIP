<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activitybudget".
 *
 * @property int $ActivityBudgetID
 * @property int $ActivityID
 * @property string $Description
 * @property int $AccountID
 * @property string $Amount
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */
class ActivityBudget extends \yii\db\ActiveRecord
{
	public $ActivityID;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'activitybudget';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ActivityID', 'AccountID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Amount'], 'number'],
			[['CreatedDate'], 'safe'],
			[['Description'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ActivityBudgetID' => 'Activity Budget ID',
			'ActivityID' => 'Activity ID',
			'Description' => 'Description',
			'AccountID' => 'Account ID',
			'Amount' => 'Amount',
			'CreatedBy' => 'Created By',
			'CreatedDate' => 'Created Date',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getAccounts()
	{
		return $this->hasOne(Accounts::className(), ['AccountID' => 'AccountID'])->from(accounts::tableName());
	}

	public function getActivities()
	{
		return $this->hasOne(Activities::className(), ['ActivityID' => 'ActivityID'])->from(activities::tableName());
	}
}
