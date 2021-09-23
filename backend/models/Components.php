<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "components".
 *
 * @property int $ComponentID
 * @property string $ComponentName
 * @property string $ShortName
 * @property string $Cost
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Components extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'components';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'components.Deleted', 0]);
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
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted'], 'integer'],
			[['ComponentName'], 'string', 'max' => 300],
			[['ShortName'], 'string', 'max' => 45],
			[['ComponentName', 'ShortName'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ComponentID' => 'Component ID',
			'ComponentName' => 'Component',
			'ShortName' => 'Short Name',
			'Cost' => 'Cost',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getBudgetedAmount()
	{
		$startDate = date('Y') . '-01-01';
		$endDate = date('Y-m-d');
		if (Yii::$app->request->post()) {
			$params = Yii::$app->request->post();
			$startDate = isset($params['FilterData']['StartDate']) ? $params['FilterData']['StartDate'] : date('Y') . '-01-01';
			$endDate = isset($params['FilterData']['EndDate']) ? $params['FilterData']['EndDate'] : date('Y-m-d');
		}
		
		$total = ActivityBudget::find()->joinWith('activities')
												->joinWith('activities.indicators')
												->joinWith('activities.indicators.projects')
												->andWhere(['projects.ComponentID' => $this->ComponentID])
												->sum('activitybudget.Amount');
		return isset($total) ? $total : 0;
	}

	public function getAmountSpent()
	{
		// $total = Payments::find()->joinWith('invoices')
		// 								->joinWith('invoices.purchases')
		// 								->joinWith('invoices.purchases.projects')
		// 								->andWhere(['projects.ComponentID' => $this->ComponentID])
		// 								->sum('payments.Amount');
		$total = Payments::find()->joinWith('projects')->andWhere(['projects.ComponentID' => $this->ComponentID])->sum('Amount');
		return isset($total) ? $total : 0;

		
	}

	public function getCummulativeExpenditure()
	{
		$startDate = date('Y') . '-01-01';
		$endDate = date('Y-m-d');
		if (Yii::$app->request->post()) {
			$params = Yii::$app->request->post();
			$startDate = isset($params['FilterData']['StartDate']) ? $params['FilterData']['StartDate'] : date('Y') . '-01-01';
			$endDate = isset($params['FilterData']['EndDate']) ? $params['FilterData']['EndDate'] : date('Y-m-d');
		}

		return Payments::find()->joinWith('invoices')
										->joinWith('invoices.purchases')
										->joinWith('purchases.projects')
										->andWhere(['projects.ComponentID' => $this->ComponentID])
										->andWhere(['>=','purchases.ApprovalDate', $startDate])
										->andWhere(['<=','purchases.ApprovalDate', $endDate])
										->sum('payments.Amount');
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
