<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producerorganizations".
 *
 * @property int $ProducerOrganizationID
 * @property string $ProducerOrganizationName
 * @property string $FormationDate
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProducerOrganizations extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'producerorganizations';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'producerorganizations.Deleted', 0]);
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
			[['FormationDate', 'CreatedDate'], 'safe'],
			[['Notes'], 'string'],
			[['CreatedBy', 'Deleted'], 'integer'],
			[['ProducerOrganizationName'], 'string', 'max' => 200],
			[['ProducerOrganizationName', 'FormationDate'], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProducerOrganizationID' => 'Producer Organization ID',
			'ProducerOrganizationName' => 'Producer Organization Name',
			'FormationDate' => 'Formation Date',
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
