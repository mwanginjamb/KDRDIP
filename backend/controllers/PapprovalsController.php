<?php

namespace backend\controllers;

use Yii;
use app\models\Purchases;
use app\models\PurchaseLines;
use app\models\ApprovalNotes;
use app\models\ApprovalStatus;
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
 * RequisitionController implements the CRUD actions for Purchases model.
 */
class PapprovalsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
			'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
					/*
					// Guest Users
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ], */
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
     * Lists all Purchases models.
     * @return mixed
     */
    public function actionIndex($option)
    {
		$StatusID = $option==1 ? 1 : 2;
        $dataProvider = new ActiveDataProvider([
            'query' => Purchases::find()->joinWith('users')->joinWith('suppliers')->where(['ApprovalStatusID'=>$StatusID]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider, 'option' => $option,
        ]);
    }

    /**
     * Displays a single Purchases model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $option)
    {	
		$identity = Yii::$app->user->identity;
		$UserID = $identity->UserID;
		$params = Yii::$app->request->post();
		
		$dataProvider = new ActiveDataProvider([
            'query' => PurchaseLines::find()->joinWith('product')->where(['PurchaseID'=> $id]),
        ]);
		$model = $this->findModel($id);
		$notes = new ApprovalNotes();
		
		if (Yii::$app->request->post())
		{
			if ($params['option']==1 && isset($params['Approve']))
			{
				$model->ApprovalStatusID = 2;
			} else if ($params['option']==2 && isset($params['Approve']))
			{
				$model->ApprovalStatusID = 3;

				$model->PostingDate = date('Y-m-d h:i:s');
				$model->Posted = 1;
				$model->ApprovedBy  = $UserID;
				$model->ApprovalDate = date('Y-m-d h:i:s');
			}
			
			if (isset($params['Reject']))
			{
				$model->ApprovalStatusID = 4;
			}
			
			if (isset($params['Adjustment']))
			{
				$model->ApprovalStatusID = 5;
			}
		}
		
		if (Yii::$app->request->post() && $model->save()) 
		{
			$params = Yii::$app->request->post();

			$notes->Note = $params['ApprovalNotes']['Note'];
			$notes->ApprovalStatusID = $model->ApprovalStatusID;
			$notes->ApprovalTypeID = 2;
			$notes->ApprovalID = $id;
			$notes->CreatedBy = $UserID;
			
			$notes->save();	
			
			if ($model->ApprovalStatusID==2)
			{
				$result = UsersController::sendEmailNotification(13);
			}
			
			return $this->redirect(['index', 'option'=> $option]);
		} else
		{
			$approvalnotes = new ActiveDataProvider([
				'query' => ApprovalNotes::find()->where(['ApprovalTypeID'=>2, 'ApprovalID' => $id]),
			]);
			$approvalstatus = ArrayHelper::map(ApprovalStatus::find()->where("ApprovalStatusID > 1")->all(), 'ApprovalStatusID', 'ApprovalStatusName');
			$detailmodel = Purchases::find()->where(['PurchaseID'=> $id])->joinWith('approvalstatus')->joinWith('suppliers')->one();
			return $this->render('view', [
				'model' => $model,'detailmodel' => $detailmodel, 'dataProvider' => $dataProvider, 
				'approvalstatus' => $approvalstatus, 'notes' => $notes, 'option' => $option, 'approvalnotes' => $approvalnotes
			]);
		}
    }

    /**
     * Updates an existing Purchases model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {	
		$model = $this->findModel($id);
		$lines = PurchaseLines::find()->where(['PurchaseID' => $id])->all();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) 
		{
			$params = Yii::$app->request->post();
			$lines = $params['PurchaseLines'];
			
			foreach ($lines as $key => $line)
			{
				//print_r($lines);exit;
				 
				if ($line['RequisitionLineID'] == '')
				{				
					if ($line['ProductID'] != '')
					{
						$_line = new PurchaseLines();
						$_line->PurchaseID = $id;
						$_line->ProductID = $line['ProductID'];
						$_line->Quantity = $line['Quantity'];
						$_line->Description = $line['Description'];
						$_line->save();
						//print_r($_line->getErrors());
					}
				} else
				{
					$_line = PurchaseLines::findOne($line['RequisitionLineID']);
					$_line->PurchaseID = $id;
					$_line->ProductID = $line['ProductID'];
					$_line->Quantity = $line['Quantity'];
					$_line->Description = $line['Description'];
					$_line->save();
				}
				
				//print_r($_line->getErrors());
			}
			
            return $this->redirect(['view', 'id' => $model->PurchaseID]);
        } else {
			$products = ArrayHelper::map(Product::find()->all(), 'ProductID', 'ProductName');
			$modelcount = count($lines);
			for ($x = $modelcount; $x <= 9; $x++) 
			{ 
				$lines[$x] = new PurchaseLines();
			}
			
            return $this->render('update', [
                'model' => $model, 'lines' => $lines, 'products' => $products
            ]);
        }
    }

    /**
     * Deletes an existing Purchases model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Purchases model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Purchases the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Purchases::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
