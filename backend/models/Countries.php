<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property int $CountryID
 * @property string $CountryName
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property bool $Deleted
 */
class Countries extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'countries';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'countries.Deleted', 0]);
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
			[['CreatedDate'], 'safe'],
			[['CreatedBy'], 'integer'],
			[['Deleted'], 'boolean'],
			[['CountryName'], 'string', 'max' => 50],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'CountryID' => 'Country ID',
			'CountryName' => 'Country Name',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}
}
