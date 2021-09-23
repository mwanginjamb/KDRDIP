<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "safeguard_question_responses".
 *
 * @property int $SafeguardQuestionResponseID
 * @property int $ProjectID
 * @property int $SafeguardQuestionID
 * @property string $Response
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class SafeguardQuestionResponses extends \yii\db\ActiveRecord
{
	public $SafeguardQuestion;
	public $SafeguardQuestionTypeID;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'safeguard_question_responses';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectID', 'SafeguardQuestionID'], 'required'],
			[['ProjectID', 'SafeguardQuestionID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Response'], 'string'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'SafeguardQuestionResponseID' => 'Safeguard Question Response ID',
			'ProjectID' => 'Project ID',
			'SafeguardQuestionID' => 'Safeguard Question',
			'Response' => 'Response',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
