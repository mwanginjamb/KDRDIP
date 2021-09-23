<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "apiusers".
 *
 * @property int $APIUserID
 * @property string $Username
 * @property string $CompanyName
 * @property string $access_token
 * @property string $Password
 * @property int $Deleted
 * @property string $CreatedDate
 * @property int $CreatedBy
 */
class Apiusers extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'apiusers';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'apiusers.Deleted', 0]);
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
			[['Deleted', 'CreatedBy'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['Username', 'CompanyName'], 'string', 'max' => 100],
			[['access_token'], 'string', 'max' => 255],
			[['Password'], 'string', 'max' => 255],			
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'APIUserID' => 'Apiuser ID',
			'Username' => 'Username',
			'CompanyName' => 'Company Name',
			'access_token' => 'Access Token',
			'Password' => 'Password',
			'Deleted' => 'Deleted',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
		];
	}

	public function getUsers() 
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
