<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_expenses".
 *
 * @property int $ProjectExpenseID
 * @property int $ProjectID
 * @property string $Date
 * @property int $ExpenseTypeID
 * @property string $Description
 * @property string $Amount
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectExpenses extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'project_expenses';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectID', 'Date', 'ExpenseTypeID', 'Amount', 'Description'], 'required'],
			[['ProjectID', 'ExpenseTypeID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Date', 'CreatedDate'], 'safe'],
			[['Description'], 'string'],
			[['Amount'], 'number'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectExpenseID' => 'Project Expense ID',
			'ProjectID' => 'Project ID',
			'Date' => 'Date',
			'ExpenseTypeID' => 'Expense Type',
			'Description' => 'Description',
			'Amount' => 'Amount',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getExpenseTypes()
	{
		return $this->hasOne(ExpenseTypes::className(), ['ExpenseTypeID' => 'ExpenseTypeID']);
	}
}
