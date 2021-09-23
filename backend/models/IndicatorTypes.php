<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indicatortypes".
 *
 * @property int $IndicatorTypeID
 * @property string $IndicatorTypeName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class IndicatorTypes extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'indicatortypes';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'indicatortypes.Deleted', 0]);
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
			[['IndicatorTypeName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'IndicatorTypeID' => 'Indicator Type ID',
			'IndicatorTypeName' => 'Indicator Type Name',
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

	public function getResultIndicators()
	{
		return $this->hasMany(ResultIndicators::className(), ['IndicatorTypeID' => 'IndicatorTypeID']);
	}
}
