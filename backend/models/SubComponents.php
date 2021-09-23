<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subcomponents".
 *
 * @property int $SubComponentID
 * @property string $SubComponentName
 * @property string $Cost
 * @property string $Notes
 * @property int $ComponentID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class SubComponents extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'subcomponents';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'subcomponents.Deleted', 0]);
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
			[['Cost'], 'number'],
			[['Notes'], 'string'],
			[['ComponentID', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['SubComponentName'], 'string', 'max' => 300],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'SubComponentID' => 'Sub Component ID',
			'SubComponentName' => 'Sub Component Name',
			'Cost' => 'Cost',
			'Notes' => 'Notes',
			'ComponentID' => 'Component ID',
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
