<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use app\models\Projects;

/**
 * Site controller
 */
class SiteController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
					'class' => AccessControl::className(),
					'rules' => [
						[
							'actions' => ['login', 'error', 'support', 'documentation'],
							'allow' => true,
						],
						[
							'actions' => ['logout', 'index', 'support', 'documentation'],
							'allow' => true,
							'roles' => ['@'],
						],
					],
			],
			'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'logout' => ['post', 'get'],
					],
			],
		];
	}

	public function beforeAction($action)
	{
		 if (parent::beforeAction($action)) {
			  if ($this->enableCsrfValidation && Yii::$app->getErrorHandler()->exception === null && !Yii::$app->getRequest()->validateCsrfToken()) {
					throw new BadRequestHttpException(Yii::t('yii', 'Unable to verify your data submission.'));
			  }
			  return true;
		 }
		 
		 return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		return [
			'error' => [
					'class' => 'yii\web\ErrorAction',
			],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$sql = 'select temp.ProjectStatusID, ProjectStatusName, Total FROM (
					Select ProjectStatusID, Count(*) as Total from projects
					GROUP BY ProjectStatusID
					) temp
					RIGHT JOIN projectstatus ON projectstatus.ProjectStatusID = temp.ProjectStatusID';
		$projectStatus = Projects::findBySql($sql)->asArray()->all();
		$graph1 = '[';
		foreach ($projectStatus as $key => $status) {
			$graph1 .= '{ label: "' . $status['ProjectStatusName'] . '",';
			$graph1 .=	' value: ' . (integer) $status['Total'] . ' },';
		}
		$graph1 .= ']';

		$bar1 = '[';
		foreach ($projectStatus as $key => $status) {
			if ($key+1 != count($projectStatus)) {
				$bar1 .= '{ y: "' . $status['ProjectStatusName'] . '",';
				$bar1 .=	' a: ' . (integer) $status['Total'] . ' },';
			} else {
				$bar1 .= '{ y: "' . $status['ProjectStatusName'] . '",';
				$bar1 .=	' a: ' . (integer) $status['Total'] . ' }';
			}			
		}
		$bar1 .= ']';

		// Project Budget
		$sql = 'select projects.ProjectID, ProjectName, TotalBudget from (
					select ProjectID, Sum(activitybudget.Amount) as TotalBudget from activitybudget
					JOIN activities ON activities.ActivityID = activitybudget.ActivityID
					JOIN indicators ON indicators.IndicatorID = activities.IndicatorID
					GROUP BY ProjectID
					) temp 
					RIGHT JOIN projects on projects.ProjectID = temp.ProjectID';
		$budget = Projects::findBySql($sql)->asArray()->all();
		// print_r(json_encode($graph1)); exit;

		// Payment Approval by Status
		$sql = 'select approvalstatus.ApprovalStatusID, ApprovalStatusName, Total from(
					select ApprovalStatusID, count(*) as Total from payments 
					GROUP BY ApprovalStatusID
					) temp
					right join approvalstatus on approvalstatus.ApprovalStatusID = temp.ApprovalStatusID';
		$paymentStatus = Projects::findBySql($sql)->asArray()->all();
		$graph2 = '[';
		foreach ($paymentStatus as $key => $status) {
			$graph2 .= '{ label: "' . $status['ApprovalStatusName'] . '",';
			$graph2 .=	' value: ' . (integer) $status['Total'] . ' },';
		}
		$graph2 .= ']';

		$bar2 = '[';
		foreach ($paymentStatus as $key => $status) {
			if ($key+1 != count($paymentStatus)) {
				$bar2 .= '{ y: "' . $status['ApprovalStatusName'] . '",';
				$bar2 .=	' a: ' . (integer) $status['Total'] . ' },';
			} else {
				$bar2 .= '{ y: "' . $status['ApprovalStatusName'] . '",';
				$bar2 .=	' a: ' . (integer) $status['Total'] . ' }';
			}			
		}
		$bar2 .= ']';

		// Invoice Approval by Status
		$sql = 'select approvalstatus.ApprovalStatusID, ApprovalStatusName, Total from(
			select ApprovalStatusID, count(*) as Total from invoices 
			GROUP BY ApprovalStatusID
			) temp
			right join approvalstatus on approvalstatus.ApprovalStatusID = temp.ApprovalStatusID';
		$invoicesStatus = Projects::findBySql($sql)->asArray()->all();
		$graph3 = '[';
		foreach ($invoicesStatus as $key => $status) {
			$graph3 .= '{ label: "' . $status['ApprovalStatusName'] . '",';
			$graph3 .=	' value: ' . (integer) $status['Total'] . ' },';
		}
		$graph3 .= ']';

		$bar3 = '[';
		foreach ($invoicesStatus as $key => $status) {
			if ($key+1 != count($invoicesStatus)) {
				$bar3 .= '{ y: "' . $status['ApprovalStatusName'] . '",';
				$bar3 .=	' a: ' . (integer) $status['Total'] . ' },';
			} else {
				$bar3 .= '{ y: "' . $status['ApprovalStatusName'] . '",';
				$bar3 .=	' a: ' . (integer) $status['Total'] . ' }';
			}			
		}
		$bar3 .= ']';

		// echo $bar3; exit;
		// Quotations Approval by Status
		$sql = 'select approvalstatus.ApprovalStatusID, ApprovalStatusName, Total from(
			select ApprovalStatusID, count(*) as Total from quotation 
			GROUP BY ApprovalStatusID
			) temp
			right join approvalstatus on approvalstatus.ApprovalStatusID = temp.ApprovalStatusID';
		$quotationStatus = Projects::findBySql($sql)->asArray()->all();
		$graph4 = '[';
		foreach ($quotationStatus as $key => $status) {
			$graph4 .= '{ label: "' . $status['ApprovalStatusName'] . '",';
			$graph4 .=	' value: ' . (integer) $status['Total'] . ' },';
		}
		$graph4 .= ']';

		$bar4 = '[';
		foreach ($quotationStatus as $key => $status) {
			if ($key+1 != count($quotationStatus)) {
				$bar4 .= '{ y: "' . $status['ApprovalStatusName'] . '",';
				$bar4 .=	' a: ' . (integer) $status['Total'] . ' },';
			} else {
				$bar4 .= '{ y: "' . $status['ApprovalStatusName'] . '",';
				$bar4 .=	' a: ' . (integer) $status['Total'] . ' }';
			}			
		}
		$bar4 .= ']';

		// Purchaes Approval by Status
		$sql = 'select approvalstatus.ApprovalStatusID, ApprovalStatusName, Total from(
			select ApprovalStatusID, count(*) as Total from purchases 
			GROUP BY ApprovalStatusID
			) temp
			right join approvalstatus on approvalstatus.ApprovalStatusID = temp.ApprovalStatusID';
		$purchasesStatus = Projects::findBySql($sql)->asArray()->all();
		$graph5 = '[';
		foreach ($purchasesStatus as $key => $status) {
			$graph5 .= '{ label: "' . $status['ApprovalStatusName'] . '",';
			$graph5 .=	' value: ' . (integer) $status['Total'] . ' },';
		}
		$graph5 .= ']';

		$bar5 = '[';
		foreach ($purchasesStatus as $key => $status) {
			if ($key+1 != count($purchasesStatus)) {
				$bar5 .= '{ y: "' . $status['ApprovalStatusName'] . '",';
				$bar5 .=	' a: ' . (integer) $status['Total'] . ' },';
			} else {
				$bar5 .= '{ y: "' . $status['ApprovalStatusName'] . '",';
				$bar5 .=	' a: ' . (integer) $status['Total'] . ' },';
			}			
		}
		$bar5 .= ']';

		// echo $bar1; exit;
		return $this->render('index', [
													'graph1' => $graph1, 
													'bar1' => $bar1,
													'projectStatus' => $projectStatus,
													'budget' => $budget,
													'graph2' => $graph2,
													'bar2' => $bar2,
													'paymentStatus' => $paymentStatus,
													'graph3' => $graph3,
													'bar3' => $bar3,
													'invoicesStatus' => $invoicesStatus,
													'graph4' => $graph4,
													'bar4' => $bar4,
													'quotationStatus' => $quotationStatus,
													'graph5' => $graph5,
													'bar5' => $bar5,
													'purchasesStatus' => $purchasesStatus
												]);
	}

	/**
	 * Login action.
	 *
	 * @return string
	 */
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		} else {
			$model->password = '';

			return $this->render('login', [
					'model' => $model,
			]);
		}
	}

	/**
	 * Logout action.
	 *
	 * @return string
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}


	public function actionSupport()
	{
		return $this->render('support', []);
	}

	public function actionDocumentation()
	{
		return $this->render('documentation', []);
	}
}
