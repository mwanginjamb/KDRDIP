<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "expensetypes".
 *
 * @property int $ExpenseTypeID
 * @property string $ExpenseTypeName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ExpenseTypes extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'expensetypes';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ExpenseTypeName'], 'required'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted'], 'integer'],
			[['ExpenseTypeName'], 'string', 'max' => 45],
			[['ExpenseTypeName'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ExpenseTypeID' => 'Expense Type ID',
			'ExpenseTypeName' => 'Expense Type Name',
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
