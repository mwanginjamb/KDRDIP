<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "safeguardparameters".
 *
 * @property int $SafeguardParamaterID
 * @property string $SafeguardParamaterName
 * @property int $SafeguardID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class SafeguardParameters extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'safeguardparameters';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'safeguardparameters.Deleted', 0]);
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
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted', 'SafeguardID'], 'integer'],
			[['SafeguardParamaterName'], 'string'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'SafeguardParamaterID' => 'Safeguard Paramater ID',
			'SafeguardParamaterName' => 'Safeguard Paramater Name',
			'SafeguardID' => 'Safeguard',
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
