<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "budgetlines".
 *
 * @property int $BudgetLineID
 * @property int $BudgetID
 * @property int $AccountID
 * @property int $DepartmentID
 * @property string $Amount
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class BudgetLines extends \yii\db\ActiveRecord
{
	public $AccountName;
	public $AccountCode;
	
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'budgetlines';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'budgetlines.Deleted', 0]);
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
			[['BudgetID', 'AccountID', 'DepartmentID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Amount'], 'number'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'BudgetLineID' => 'Budget Line ID',
			'BudgetID' => 'Budget ID',
			'AccountID' => 'Account ID',
			'DepartmentID' => 'Department ID',
			'Amount' => 'Amount',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}
}
