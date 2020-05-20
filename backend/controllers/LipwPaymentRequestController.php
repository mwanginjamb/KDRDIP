<?php

namespace backend\controllers;

use Yii;
use app\models\LipwPaymentRequest;
use app\models\LipwPaymentRequestLines;
use app\models\LipwWorkRegister;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * LipwPaymentRequestController implements the CRUD actions for LipwPaymentRequest model.
 */
class LipwPaymentRequestController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(100);

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
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => LipwPaymentRequest::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single LipwPaymentRequest model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
			'rights' => $this->rights,
		]);
	}

	/**
	 * Creates a new LipwPaymentRequest model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new LipwPaymentRequest();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			// LipwPaymentRequestLines
			/*
				Compute the work done between the two days and pick the work that is not paid
			*/
			$works = LipwWorkRegister::find()->andWhere(['MasterRollID' => $model->MasterRollID, 'Paid' => 0])
						->andWhere(['between', 'date', $model->StartDate, $model->EndDate])->all();

			foreach ($works as $work) {
				$lines = new LipwPaymentRequestLines();
				$lines->PaymentRequestID = $model->PaymentRequestID;
				$lines->WorkRegisterID = $work->WorkRegisterID;
				$lines->Amount = $work->Amount;
				if ($lines->save()) {
					$work->Paid = 1;
					$work->save();
				}
			}
			return $this->redirect(['view', 'id' => $model->PaymentRequestID]);
		}

		$masterRoll = ArrayHelper::map(\app\models\LipwMasterRoll::find()->all(), 'MasterRollID', 'MasterRollName');

		return $this->render('create', [
			'model' => $model,
			'rights' => $this->rights,
			'masterRoll' => $masterRoll,
		]);
	}

	/**
	 * Updates an existing LipwPaymentRequest model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->PaymentRequestID]);
		}

		$masterRoll = ArrayHelper::map(\app\models\LipwMasterRoll::find()->all(), 'MasterRollID', 'MasterRollName');

		return $this->render('update', [
			'model' => $model,
			'rights' => $this->rights,
			'masterRoll' => $masterRoll,
		]);
	}

	/**
	 * Deletes an existing LipwPaymentRequest model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	public function actionSubmit($id)
	{
		$model = $this->findModel($id);
		$model->ApprovalStatusID = 1;
		$model->submit = 1;
		if ($model->save()) {
			// $result = UsersController::sendEmailNotification(29);
			return $this->redirect(['view', 'id' => $model->PaymentRequestID]);
		} else {
			// print_r($model->getErrors()); exit;
		}
	}

	/**
	 * Finds the LipwPaymentRequest model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return LipwPaymentRequest the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = LipwPaymentRequest::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
