<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "enterprisetypes".
 *
 * @property int $EnterpriseTypeID
 * @property string $EnterpriseTypeName
 * @property string $ShortName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class EnterpriseTypes extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'enterprisetypes';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'enterprisetypes.Deleted', 0]);
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
			[['CreatedBy', 'Deleted'], 'integer'],
			[['EnterpriseTypeName'], 'string', 'max' => 100],
			[['ShortName'], 'string', 'max' => 45],
			[['EnterpriseTypeName', 'ShortName'], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'EnterpriseTypeID' => 'Enterprise Type ID',
			'EnterpriseTypeName' => 'Enterprise Type Name',
			'ShortName' => 'Short Name',
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
