<?php

namespace backend\controllers;

use Yii;
use yii\db\Expression;
use app\models\LipwPaymentRequest;
use app\models\LipwPaymentRequestLines;
use app\models\ApprovalNotes;
use app\models\ApprovalStatus;
use app\models\LipwPaymentSchedule;
use app\models\Purchases;
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\UsersController;
use backend\controllers\RightsController;

/**
 * RequisitionController implements the CRUD actions for Requisition model.
 */
class LipwApprovalsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(103);

		$rightsArray = [];
		if (isset($this->rights->View)) {
			array_push($rightsArray, 'index', 'view');
		}
		if (isset($this->rights->Create)) {
			array_push($rightsArray, 'view', 'create');
		}
		if (isset($this->rights->Edit)) {
			array_push($rightsArray, 'index', 'view', 'update');
		}
		if (isset($this->rights->Delete)) {
			array_push($rightsArray, 'delete');
		}
		$rightsArray = array_unique($rightsArray);
		
		if (count($rightsArray) <= 0) {
			$rightsArray = ['none'];
		}
		
		return [
		'access' => [
			'class' => AccessControl::className(),
			'only' => ['index', 'view', 'create', 'update', 'delete'],
			'rules' => [
					// Guest Users
					[
						'allow' => true,
						'actions' => ['none'],
						'roles' => ['?'],
					],
					// Authenticated Users
					[
						'allow' => true,
						'actions' => $rightsArray, //['index', 'view', 'create', 'update', 'delete'],
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all LipwPaymentRequest models.
	 * @return mixed
	 */
	public function actionIndex($option)
	{
		$StatusID = $option;
		$dataProvider = new ActiveDataProvider([
			'query' => LipwPaymentRequest::find()->joinWith('users')->where(['ApprovalStatusID'=>$StatusID]),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider, 'option' => $option,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Requisition model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id, $option)
	{
		$identity = Yii::$app->user->identity;
		$UserID = $identity->UserID;
		$model = $this->findModel($id);
		$model->submit = 1;
		
		$params = Yii::$app->request->post();
		// $PurchaseID = $model->PurchaseID;

		// $requestLines = LipwPaymentRequestLines::find()->andWhere(['PaymentRequestID' => $id])->all();

		$requestLines = new ActiveDataProvider([
			'query' => LipwPaymentRequestLines::find()->andWhere(['PaymentRequestID' => $id]),
		]);

		$notes = new ApprovalNotes();
		if (Yii::$app->request->post()) {
			if ($params['option']==1 && isset($params['Approve'])) {
				$model->ApprovalStatusID = 2;
			} elseif ($params['option']==2 && isset($params['Approve'])) {
				$model->ApprovalStatusID = 3;

				$model->PostingDate = date('Y-m-d h:i:s');
				$model->Posted = 1;
				$model->ApprovedBy  = $UserID;
				$model->ApprovalDate = date('Y-m-d h:i:s');

				// Send Information to the Payment Schedule
				// LipwPaymentSchedule
				$lines = LipwPaymentRequestLines::find()
				->select([new Expression('SUM(lipw_payment_request_lines.Amount) as Total'), 'BeneficiaryID'])
								
								->joinWith('lipwWorkRegister')
								->groupBy('BeneficiaryID')
								->andWhere(['PaymentRequestID' => $id])
								// ->asArray()
								->all();
				// print_r($lines); exit;
				foreach ($lines as $line) {
					$ln = new LipwPaymentSchedule();
					$ln->PaymentRequestID = $id;
					$ln->BeneficiaryID = $line['BeneficiaryID'];
					$ln->Amount = $line['Total'];
					if (!$ln->save()) {
						print_r($ln->getErrors()); exit;
					}
				}
			}
			
			if (isset($params['Reject'])) {
				$model->ApprovalStatusID = 4;
			}
		}

		if (Yii::$app->request->post() && $model->save()) {
			$params = Yii::$app->request->post();
			
			// Add Notes to the notes table
			$notes->Note = $params['ApprovalNotes']['Note'];
			$notes->ApprovalStatusID = $model->ApprovalStatusID;
			$notes->ApprovalTypeID = 7;
			$notes->ApprovalID = $id;
			$notes->CreatedBy = $UserID;
			$notes->save();
			
			if ($model->ApprovalStatusID ==3) {
				// $result = UsersController::sendEmailNotification(12);
			}
			return $this->redirect(['index', 'option'=> $option]);
		}

		$approvalstatus = ArrayHelper::map(ApprovalStatus::find()->where('ApprovalStatusID > 1')->all(), 'ApprovalStatusID', 'ApprovalStatusName');
		$detailmodel = LipwPaymentRequest::find()->where(['PaymentRequestID'=> $id])->one();

		$sql_payroll = "select lprl.PaymentRequestID,lprl.WorkRegisterID, lwr.BeneficiaryID, concat(lb.FirstName,' ',lb.MiddleName,' ',lb.LastName) as Name,
		count(lwr.WorkRegisterID) as Days, sum(lwr.Amount) as Total,
		lmr.MasterRollName
		from lipw_payment_request_lines lprl
		left join lipw_work_register lwr on lwr.WorkRegisterID = lprl.WorkRegisterID 
		left join lipw_beneficiaries lb on lwr.BeneficiaryID = lb.BeneficiaryID
		left join lipw_master_roll lmr on lmr.MasterRollID = lwr.MasterRollID 
		where lmr.MasterRollID = ".$model->lipwMasterRoll->MasterRollID."
		group by lwr.BeneficiaryID ";

		$payroll = LipwPaymentRequestLines::findBySql($sql_payroll)
		->all();

		return $this->render('view', [
			'model' => $model,
			'detailmodel' => $detailmodel,
			'approvalstatus' => $approvalstatus,
			'notes' => $notes,
			'option' => $option,
			'requestLines' => $requestLines,
			'rights' => $this->rights,
			'payroll' => $payroll
		]);
	}

	/**
	 * Finds the Requisition model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Requisition the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = LipwPaymentRequest::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
