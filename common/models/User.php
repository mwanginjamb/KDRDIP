<?php
namespace common\models;

use app\models\AuthAssignment;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $UserID
 * @property string $FirstName
 * @property string $LastName
 * @property string $PasswordHash
 * @property string $ResetCode
 * @property string $ValidationCode
 * @property string $Email
 * @property string $AuthKey
 * @property integer $UserStatusID
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $userRole
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
	const STATUS_DELETED = 4;
	const STATUS_INACTIVE = 1;
	const STATUS_ACTIVE = 2;

	public $userRole;


	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%users}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			['status', 'default', 'value' => self::STATUS_INACTIVE],
			['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['userRole', 'string'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentity($UserID)
	{
		return static::findOne(['UserID' => $UserID, 'UserStatusID' => self::STATUS_ACTIVE]);
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		// throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
		 return static::findOne(['AuthKey' => $token, 'UserStatusID' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['Email' => $username, 'UserStatusID' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token)
	{
		if (!static::isPasswordResetTokenValid($token)) {
			return null;
		}

		return static::findOne([
			'ResetCode' => $token,
			'UserStatusID' => self::STATUS_ACTIVE,
		]);
	}

	/**
	 * Finds user by verification Email token
	 *
	 * @param string $token verify Email token
	 * @return static|null
	 */
	public static function findByVerificationToken($token) {
		return static::findOne([
			'ValidationCode' => $token,
			'UserStatusID' => self::STATUS_INACTIVE
		]);
	}

	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token password reset token
	 * @return bool
	 */
	public static function isPasswordResetTokenValid($token)
	{
		if (empty($token)) {
			return false;
		}

		$timestamp = (int) substr($token, strrpos($token, '_') + 1);
		$expire = Yii::$app->params['user.passwordResetTokenExpire'];
		return $timestamp + $expire >= time();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAuthKey()
	{
		return $this->AuthKey;
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->PasswordHash);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->PasswordHash = Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->AuthKey = Yii::$app->security->generateRandomString();
	}

	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken()
	{
		$this->ResetCode = Yii::$app->security->generateRandomString() . '_' . time();
	}

	public function generateEmailVerificationToken()
	{
		$this->ValidationCode = Yii::$app->security->generateRandomString() . '_' . time();
	}

	// Get an Assigned Auth Role

    public function getAuthRole()
    {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'UserID']);
    }

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken()
	{
		$this->ResetCode = null;
	}
}
