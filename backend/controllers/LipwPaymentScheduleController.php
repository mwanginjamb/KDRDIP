<?php

namespace backend\controllers;

use Yii;
use app\models\LipwPaymentRequest;
use app\models\LipwPaymentRequestLines;
use app\models\LipwWorkRegister;
use app\models\LipwPaymentSchedule;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * LipwPaymentRequestController implements the CRUD actions for LipwPaymentRequest model.
 */
class LipwPaymentScheduleController extends Controller
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
			'query' => LipwPaymentRequest::find()->andWhere(['ApprovalStatusID' => 3]),
			'sort'=> ['defaultOrder' => ['ApprovalDate'=>SORT_DESC]],
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

	public function actionSchedule($pId)
	{
		$message = '';
		if (Yii::$app->request->post()) {
			$params = Yii::$app->request->post()['LipwPaymentSchedule'];
			foreach ($params as $id => $param) {
				$model = LipwPaymentSchedule::findOne($id);
				$model->PaymentScheduleStatusID = $param['PaymentScheduleStatusID'];
				$model->save();
			}
			Yii::$app->session->setFlash('success', 'Saved Successfully');
			$message = 'Saved Successfully';
		}

		$dataProvider = new ActiveDataProvider([
			'query' => LipwPaymentSchedule::find()->andWhere(['PaymentRequestID' => $pId]),
		]);

		return $this->renderPartial('schedule', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'pId' => $pId,
			'message' => $message,
		]);
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
