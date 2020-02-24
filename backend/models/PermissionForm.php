<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\UserGroupMembers;

/**
 * Login form
 */
class PermissionForm extends Model
{
	public $UserGroupID;
	public $UserID;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['UserGroupID'], 'required'],
			[['UserGroupID', 'UserID'], 'integer'],
			['UserGroupID', 'validateGroup'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'UserGroupID' => 'User Group'
		];
	}

		/**
	 * Validates the User Group.
	 * This method serves as the inline validation for password.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 */
	public function validateGroup($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$perm = UserGroupMembers::findOne(['UserGroupID' => $this->UserGroupID, 'UserID' => $this->UserID]); 
			if ($perm) {
				$this->addError($attribute, 'The group is already selected');
			}
		}
	}
}
