<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectstatus".
 *
 * @property int $ProjectStatusID
 * @property string $ProjectStatusName
 * @property string $Notes
 * @property string $ColorCode
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectStatus extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'projectstatus';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted'], 'integer'],
			[['ProjectStatusName', 'ColorCode'], 'string', 'max' => 45],
			[['ProjectStatusName', 'ColorCode'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectStatusID' => 'Project Status ID',
			'ProjectStatusName' => 'Project Status',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'ColorCode' => 'Color Code',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
