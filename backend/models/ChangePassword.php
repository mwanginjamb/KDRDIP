<?php
namespace app\models;

use Yii;
use yii\base\Model;

use app\models\Profiles;

/**
 * Login form
 */
class ChangePassword extends Model
{
	public $Password;
	public $ConfirmPassword;
	public $UserID;
	public $FullName;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Password', 'ConfirmPassword'], 'string', 'max' => 50],
			[['UserID'], 'integer'],
			[['FullName'], 'string'],
			['Password', 'validatePasswords'],
			[['Password', 'ConfirmPassword'], 'required'], 
		];
	}

		/**
	 * Validates the Passwords.
	 * This method serves as the inline validation for password.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 */
	public function validatePasswords($attribute, $params)
	{
		if (!$this->hasErrors()) {
			if ($this->Password != $this->ConfirmPassword) {
				$this->addError($attribute, 'Password and Confirm Password do not Match' );
			}
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'Password' => 'New Password',
			'ConfirmPassword' => 'Confirm Password',
			'UserID' => 'User ID',
		];
	}
}
