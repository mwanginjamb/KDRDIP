<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "types".
 *
 * @property int $TypeID
 * @property string $TypeName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Types extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'types';
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
			[['TypeName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'TypeID' => 'Type ID',
			'TypeName' => 'Type Name',
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
