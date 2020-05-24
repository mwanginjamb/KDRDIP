<?php

namespace backend\controllers;

use Yii;
use app\models\Disbursement;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * DisbursementController implements the CRUD actions for Disbursement model.
 */
class DisbursementController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(106);

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
					'delete' => ['POST', 'GET'],
				],
			],
		];
	}

	/**
	 * Lists all Disbursement models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$eId = isset(Yii::$app->request->get()['eId']) ? Yii::$app->request->get()['eId'] : 0;
		$eTypeId = isset(Yii::$app->request->get()['eTypeId']) ? Yii::$app->request->get()['eTypeId'] : 0;

		$dataProvider = new ActiveDataProvider([
			'query' => Disbursement::find()->andWhere(['EnterpriseTypeID' => $eTypeId]),
		]);

		return $this->renderPartial('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'eTypeId' => $eTypeId,
			'eId' => $eId,
		]);
	}

	/**
	 * Displays a single Disbursement model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->renderPartial('view', [
			'model' => $this->findModel($id),
			'rights' => $this->rights,
		]);
	}

	/**
	 * Creates a new Disbursement model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$eId = isset(Yii::$app->request->get()['eId']) ? Yii::$app->request->get()['eId'] : 0;
		$eTypeId = isset(Yii::$app->request->get()['eTypeId']) ? Yii::$app->request->get()['eTypeId'] : 0;

		$model = new Disbursement();
		$model->EnterpriseTypeID = $eTypeId;
		$model->EnterpriseID = $eId;
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index', 'eId' => $model->EnterpriseID, 'eTypeId' => $model->EnterpriseTypeID]);
		}

		return $this->renderPartial('create', [
			'model' => $model,
			'rights' => $this->rights,
			'eTypeId' => $eTypeId,
		]);
	}

	/**
	 * Updates an existing Disbursement model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index', 'eId' => $model->EnterpriseID, 'eTypeId' => $model->EnterpriseTypeID]);
		}

		return $this->renderPartial('update', [
			'model' => $model,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing Disbursement model.
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

	/**
	 * Finds the Disbursement model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Disbursement the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Disbursement::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
