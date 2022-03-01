<?php

namespace backend\controllers;

use Yii;
use app\models\ResultIndicators;
use app\models\IndicatorTypes;
use app\models\UnitsOfMeasure;
use app\models\ResultIndicatorTargets;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use backend\controllers\RightsController;

/**
 * ResultIndicatorsController implements the CRUD actions for ResultIndicators model.
 */
class ResultIndicatorsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(118);

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
	 * Lists all ResultIndicators models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => ResultIndicators::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single ResultIndicators model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => ResultIndicatorTargets::find()->andWhere(['ResultIndicatorID' => $id]),
		]);

		return $this->render('view', [
			'model' => $this->findModel($id),
			'rights' => $this->rights,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Creates a new ResultIndicators model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new ResultIndicators();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (isset(Yii::$app->request->post()['ResultIndicatorTargets'])) {
				$this->saveTargets(Yii::$app->request->post()['ResultIndicatorTargets'], $model);
			}
			return $this->redirect(['view', 'id' => $model->ResultIndicatorID]);
		}

		$indicatorTypes = ArrayHelper::map(IndicatorTypes::find()->all(), 'IndicatorTypeID', 'IndicatorTypeName');
		$unitsOfMeasure = ArrayHelper::map(UnitsOfMeasure::find()->all(), 'UnitOfMeasureID', 'UnitOfMeasureName');

		$targets = [];
		for ($x = 0; $x <= 4; $x++) {
			$targets[$x] = new ResultIndicatorTargets();
		}

		return $this->render('create', [
			'model' => $model,
			'indicatorTypes' => $indicatorTypes,
			'rights' => $this->rights,
			'targets' => $targets,
			'unitsOfMeasure' => $unitsOfMeasure,
		]);
	}

	/**
	 * Updates an existing ResultIndicators model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		$targets = ResultIndicatorTargets::find()->where(['ResultIndicatorID' => $id])->all();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (isset(Yii::$app->request->post()['ResultIndicatorTargets'])) {
				$this->saveTargets(Yii::$app->request->post()['ResultIndicatorTargets'], $model);
			}
			return $this->redirect(['view', 'id' => $model->ResultIndicatorID]);
		}

		$indicatorTypes = ArrayHelper::map(IndicatorTypes::find()->all(), 'IndicatorTypeID', 'IndicatorTypeName');
		$unitsOfMeasure = ArrayHelper::map(UnitsOfMeasure::find()->all(), 'UnitOfMeasureID', 'UnitOfMeasureName');

		for ($x = count($targets); $x <= 4; $x++) {
			$targets[$x] = new ResultIndicatorTargets();
		}

		return $this->render('update', [
			'model' => $model,
			'indicatorTypes' => $indicatorTypes,
			'rights' => $this->rights,
			'targets' => $targets,
			'unitsOfMeasure' => $unitsOfMeasure,
		]);
	}

	public function actionQuarters($id)
	{
		$model = $this->findModel($id);
		return $this->render('quarter', ['model' => $model]);
	}

	/**
	 * Deletes an existing ResultIndicators model.
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
	 * Finds the ResultIndicators model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return ResultIndicators the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = ResultIndicators::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public static function saveTargets($parameters, $model)
	{
		$params = Yii::$app->request->post()['ResultIndicatorTargets'];
			
		foreach ($params as $key => $line) {
			if ($line['ResultIndicatorTargetID'] == '') {
					$_line = new ResultIndicatorTargets();
					$_line->ResultIndicatorID = $model->ResultIndicatorID;
					$_line->load(['ResultIndicatorTargets' => $line]);
					$_line->save();
			} else {
				$_line = ResultIndicatorTargets::findOne($line['ResultIndicatorTargetID']);
				$_line->load(['ResultIndicatorTargets' => $line]);
				$_line->save();
			}
		}
	}
}
