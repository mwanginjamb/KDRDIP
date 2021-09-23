<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

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

class Apiusers extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'apiusers';
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
	
	/**
	 * Finds an identity by the given token.
	 *
	 * @param string $token the token to be looked for
	 * @return IdentityInterface|null the identity object that matches the given token.
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::findOne(['access_token' => $token]);
	}

	/**
	 * @return int|string current user ID
	 */
	public function getId()
	{
		return $this->APIUserID;
	}

	/**
	 * @return string current user auth key
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * @param string $authKey
	 * @return boolean if auth key is valid for current user
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	public static function findIdentity($id)
	{
		return static::findOne($id);
	}
}
