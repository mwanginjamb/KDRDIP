<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectsafeguards".
 *
 * @property int $ProjectSafeguardID
 * @property int $SafeguardParamaterID
 * @property int $ProjectID
 * @property int $Yes
 * @property int $No
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectSafeguards extends \yii\db\ActiveRecord
{
	public $SelectedOption;
	public $SGPID;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'projectsafeguards';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['SafeguardParamaterID', 'ProjectID', 'Yes', 'No', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectSafeguardID' => 'Project Safeguard ID',
			'SafeguardParamaterID' => 'Safeguard Paramater ID',
			'ProjectID' => 'Project ID',
			'Yes' => 'Yes',
			'No' => 'No',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'SelectedOption' => '',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getSafeguardParameters()
	{
		return $this->hasOne(SafeguardParameters::className(), ['SafeguardParamaterID' => 'SafeguardParamaterID'])->from(safeguardparameters::tableName());
	}
}
