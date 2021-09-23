<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectsectors".
 *
 * @property int $ProjectSectorID
 * @property string $ProjectSectorName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectSectors extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'projectsectors';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'projectsectors.Deleted', 0]);
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
			[['ProjectSectorName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectSectorID' => 'Project Sector ID',
			'ProjectSectorName' => 'Project Sector Name',
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
												->andWhere(['projects.ProjectSectorID' => $this->ProjectSectorID])
												->sum('activitybudget.Amount');
		return isset($total) ? $total : 0;
	}

	public function getAmountSpent()
	{
		$total = Payments::find()->joinWith('invoices')
										->joinWith('invoices.purchases')
										->joinWith('invoices.purchases.projects')
										->andWhere(['projects.ProjectSectorID' => $this->ProjectSectorID])
										->sum('payments.Amount');
		return isset($total) ? $total : 0;
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
