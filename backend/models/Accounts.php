<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accounts".
 *
 * @property int $AccountID
 * @property string $AccountCode
 * @property string $AccountName
 * @property int $AccountTypeID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Accounts extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'accounts';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'accounts.Deleted', 0]);
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
			[['AccountTypeID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['AccountCode', 'AccountName'], 'string', 'max' => 45],
			[['AccountCode', 'AccountName', 'AccountTypeID'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'AccountID' => 'Account ID',
			'AccountCode' => 'Account Code',
			'AccountName' => 'Account Name',
			'AccountTypeID' => 'Account Type',
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

	public function getAccountTypes()
	{
		return $this->hasOne(AccountTypes::className(), ['AccountTypeID' => 'AccountTypeID'])->from(accounttypes::tableName());
	}
}
