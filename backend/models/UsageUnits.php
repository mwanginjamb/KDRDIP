<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usageunit".
 *
 * @property int $UsageUnitID
 * @property string $UsageUnitName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property bool $Deleted
 * @property int $CompanyID
 */
class UsageUnits extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'usageunit';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'usageunit.Deleted', 0]);
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
			[['CreatedBy', 'CompanyID'], 'integer'],
			[['Deleted'], 'boolean'],
			[['UsageUnitName'], 'string', 'max' => 50],
			[['UsageUnitName'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'UsageUnitID' => 'Usage Unit ID',
			'UsageUnitName' => 'Usage Unit Name',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'CompanyID' => 'Company ID',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
