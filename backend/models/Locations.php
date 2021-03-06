<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "locations".
 *
 * @property int $LocationID
 * @property string $LocationName
 * @property int $SubCountyID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Locations extends \yii\db\ActiveRecord
{
	public $CountyID;
	
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'locations';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'locations.Deleted', 0]);
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
			[['SubCountyID', 'CreatedBy', 'Deleted', 'CountyID'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['LocationName'], 'string', 'max' => 45],
			[['CountyID', 'SubCountyID', 'LocationName'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'LocationID' => 'Ward ID',
			'LocationName' => 'Ward',
			'SubCountyID' => 'Sub County',
			'CountyID' => 'County',
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

	public function getSubCounties()
	{
		return $this->hasOne(SubCounties::className(), ['SubCountyID' => 'SubCountyID'])->from(subcounties::tableName());
	}
}
