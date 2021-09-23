<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "UsageUnit".
 *
 * @property integer $UsageUnitID
 * @property string $UsageUnitName
 * @property string $CreatedDate
 * @property integer $CreatedBy
 * @property integer $Deleted
 */
class UsageUnit extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
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
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['UsageUnitName'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted'], 'integer'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'UsageUnitID' => 'Usage Unit ID',
			'UsageUnitName' => 'Usage Unit Name',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}
}
