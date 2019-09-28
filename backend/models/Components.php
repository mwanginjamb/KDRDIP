<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "components".
 *
 * @property int $ComponentID
 * @property string $ComponentName
 * @property string $Cost
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Components extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'components';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Cost'], 'number'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted'], 'integer'],
			[['ComponentName'], 'string', 'max' => 300],
			[['ComponentName'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ComponentID' => 'Component ID',
			'ComponentName' => 'Component Name',
			'Cost' => 'Cost',
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
}
