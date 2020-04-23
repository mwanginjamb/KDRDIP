<?php

namespace backend\controllers;

use Yii;
use app\models\MasterIndicators;
use app\models\ReportingFrequency;
use app\models\MasterTargets;
use app\models\IndicatorTypes;
use app\models\Components;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\controllers\RightsController;
use yii\helpers\ArrayHelper;

/**
 * MasterIndicatorsController implements the CRUD actions for MasterIndicators model.
 */
class MasterIndicatorsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(93);

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
	 * Lists all MasterIndicators models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => MasterIndicators::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single MasterIndicators model.
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
	 * Creates a new MasterIndicators model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new MasterIndicators();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->MasterIndicatorID]);
		}
		$reportingFrequency = ArrayHelper::map(ReportingFrequency::find()->all(), 'ReportingFrequencyID', 'ReportingFrequencyName');
		$indicatorTypes = ArrayHelper::map(IndicatorTypes::find()->all(), 'IndicatorTypeID', 'IndicatorTypeName');
		$components = ArrayHelper::map(Components::find()->all(), 'ComponentID', 'ComponentName');

		return $this->render('create', [
			'model' => $model,
			'reportingFrequency' => $reportingFrequency,
			'indicatorTypes' => $indicatorTypes,
			'components' => $components,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing MasterIndicators model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->MasterIndicatorID]);
		}

		$reportingFrequency = ArrayHelper::map(ReportingFrequency::find()->all(), 'ReportingFrequencyID', 'ReportingFrequencyName');
		$indicatorTypes = ArrayHelper::map(IndicatorTypes::find()->all(), 'IndicatorTypeID', 'IndicatorTypeName');
		$components = ArrayHelper::map(Components::find()->all(), 'ComponentID', 'ComponentName');

		return $this->render('update', [
			'model' => $model,
			'reportingFrequency' => $reportingFrequency,
			'indicatorTypes' => $indicatorTypes,
			'components' => $components,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing MasterIndicators model.
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
	 * Finds the MasterIndicators model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return MasterIndicators the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = MasterIndicators::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
