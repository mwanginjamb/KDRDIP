<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_outputs".
 *
 * @property int $ActivityOutputID
 * @property int $ActivityID
 * @property string $Output
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */
class ActivityOutputs extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'activity_outputs';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ActivityID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Output'], 'string'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ActivityOutputID' => 'Actiity Output ID',
			'ActivityID' => 'Activity ID',
			'Output' => 'Output',
			'CreatedBy' => 'Created By',
			'CreatedDate' => 'Created Date',
			'Deleted' => 'Deleted',
		];
	}
}
