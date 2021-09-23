<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "questionnairetypes".
 *
 * @property int $QuestionnaireTypeID
 * @property string $QuestionnaireTypeName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class QuestionnaireTypes extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'questionnairetypes';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'questionnairetypes.Deleted', 0]);
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
			[['QuestionnaireTypeName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'QuestionnaireTypeID' => 'Questionnaire Type ID',
			'QuestionnaireTypeName' => 'Questionnaire Type Name',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}
}
