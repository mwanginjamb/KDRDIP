<?php

namespace backend\controllers;

use Yii;
use app\models\CashDisbursements;
use app\models\CashBook;
use app\models\ApprovalNotes;
use app\models\ApprovalStatus;
use app\models\Documents;
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
class CashDisbursementApprovalsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(133);

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
						'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
	 * Lists all Invoices models.
	 * @return mixed
	 */
	public function actionIndex($option)
	{
		$StatusID = $option; //==1 ? 1 : 2;


		 $query = CashDisbursements::find()->joinWith('users')->where(['ApprovalStatusID'=>$StatusID]);
        $countQuery = clone $query;

		$dataProvider = new ActiveDataProvider([
			'query' => $query ,
			'pagination' =>  [
                'pageSize' => $countQuery->count()
            ],
            'totalCount' => $countQuery->count(),
            'sort' => [
                'defaultOrder' => [
                    'CashDisbursementID' => SORT_DESC
                ],
            ],
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
		
		$params = Yii::$app->request->post();

		$notes = new ApprovalNotes();
		if (Yii::$app->request->post()) {
			if ($params['option']==1 && isset($params['Approve'])) {
				$model->ApprovalStatusID = 3;

				$cashBook = new CashBook();
				$cashBook->CreatedBy = Yii::$app->user->identity->UserID;
				$cashBook->Date = $model['DisbursementDate'];
				$cashBook->TypeID = 1;
				$cashBook->BankAccountID = $model['SourceAccountID'];
				$cashBook->AccountID = $model['DestinationAccountID'];
				$cashBook->Description = $model['Description'];
				$cashBook->DocumentReference = $model['SerialNumber'];
				$cashBook->ProjectID = $model['ProjectID'];
				$cashBook->OrganizationID = $model['OrganizationID'];
				$cashBook->CountyID = $model['CountyID'];
				$cashBook->ProjectDisbursementID = 0;
				$cashBook->Credit = $model['Amount'];
				$cashBook->Amount = $model['Amount'];
				if (!$cashBook->save()) {
					// print_r($cashBook->getErrors()); exit;
				}
	
				$cashBook = new CashBook();
				$cashBook->CreatedBy = Yii::$app->user->identity->UserID;
				$cashBook->Date = $model['DisbursementDate'];
				$cashBook->TypeID = 1;
				$cashBook->BankAccountID = $model['DestinationAccountID'];
				$cashBook->AccountID = $model['SourceAccountID'];
				$cashBook->Description = $model['Description'];
				$cashBook->DocumentReference = $model['SerialNumber'];
				$cashBook->ProjectID = $model['ProjectID'];
				$cashBook->OrganizationID = $model['OrganizationID'];
				$cashBook->CountyID = $model['CountyID'];
				$cashBook->ProjectDisbursementID = 0;
				$cashBook->Debit = $model['Amount'];
				$cashBook->Amount = $model['Amount'];
				if (!$cashBook->save()) {
					// print_r($cashBook->getErrors()); exit;
				}

				$model->PostingDate = date('Y-m-d h:i:s');
				$model->Posted = 1;
				$model->ApprovedBy  = $UserID;
				$model->ApprovalDate = date('Y-m-d h:i:s');
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
			$notes->ApprovalTypeID = 10;
			$notes->ApprovalID = $id;
			$notes->CreatedBy = $UserID;
			$notes->save();
			
			if ($model->ApprovalStatusID ==3) {
				// $result = UsersController::sendEmailNotification(12);
			}
			return $this->redirect(['index', 'option'=> $option]);
		}

		$approvalstatus = ArrayHelper::map(ApprovalStatus::find()->where('ApprovalStatusID > 1')->all(), 'ApprovalStatusID', 'ApprovalStatusName');
		$detailmodel = CashDisbursements::find()->where(['CashDisbursementID'=> $id])->joinWith('approvalstatus')->one();

		$approvalNotesProvider = new ActiveDataProvider([
			'query' => ApprovalNotes::find()->where(['ApprovalID'=> $id, 'ApprovalTypeID' => 10]),
		]);

		
		$documentsProvider = new ActiveDataProvider([
			'query' => Documents::find()->andWhere(['RefNumber' => $id, 'DocumentCategoryID' => 7]),
		]);

		return $this->render('view', [
			'model' => $model,
			'detailmodel' => $detailmodel,
			'approvalstatus' => $approvalstatus,
			'notes' => $notes,
			'option' => $option,
			'approvalNotesProvider' => $approvalNotesProvider,
			'rights' => $this->rights,
			'documentsProvider' => $documentsProvider,
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
		if (($model = CashDisbursements::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
