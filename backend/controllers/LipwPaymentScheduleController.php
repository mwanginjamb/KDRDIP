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

use kartik\mpdf\Pdf;

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

	public function actionPrint()
	{
		$pId = isset(Yii::$app->request->get()['pId']) ? Yii::$app->request->get()['pId'] : 0;
		$mId = isset(Yii::$app->request->get()['mId']) ? Yii::$app->request->get()['mId'] : 0;

		$dataProvider = new ActiveDataProvider([
			'query' => LipwPaymentSchedule::find()->andWhere(['PaymentRequestID' => $pId]),
		]);
				
		$Title = 'Payment Schedule / Payroll';

		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('print', [
																	'dataProvider' => $dataProvider,
																	'pId' => $pId
																]);
		
		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE,
			// stream to browser inline
			'destination' => Pdf::DEST_STRING,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			// 'cssInline' => '.kv-heading-1{font-size:18px}',
			'cssFile' => 'css/pdf.css',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		// return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));

		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content,
			'mId' => $mId,
			'pId' => $pId
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
