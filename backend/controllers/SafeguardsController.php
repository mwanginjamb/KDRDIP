<?php

namespace backend\controllers;

use Yii;
use app\models\Safeguards;
use app\models\SafeguardParameters;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * SafeguardsController implements the CRUD actions for Safeguards model.
 */
class SafeguardsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(77);

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
	 * Lists all Safeguards models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Safeguards::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Safeguards model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => SafeguardParameters::find()->where(['SafeguardID'=> $id]),
		]);

		return $this->render('view', [
			'model' => $this->findModel($id),
			'rights' => $this->rights,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Creates a new Safeguards model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Safeguards();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post()['SafeguardParameters'];

			foreach ($params as $line) {
				$modelLine = new SafeguardParameters();

				$modelLine->SafeguardID = $model->SafeguardID;
				$modelLine->SafeguardParamaterName = $line->SafeguardParamaterName;
				if (!$modelLine->save()) {
					// print_r($purchaseLines->getErrors()); exit;
				}
			}
			return $this->redirect(['view', 'id' => $model->SafeguardID]);
		}

		for ($x = 0; $x <= 9; $x++) {
			$parameters[$x] = new SafeguardParameters();
		}

		return $this->render('create', [
			'model' => $model,
			'rights' => $this->rights,
			'parameters' => $parameters
		]);
	}

	/**
	 * Updates an existing Safeguards model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$parameters = SafeguardParameters::find()->where(['SafeguardID' => $id])->all();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post()['SafeguardParameters'];
			
			foreach ($params as $key => $line) {
				if ($line['SafeguardParamaterID'] == '') {
					if ($line['SafeguardParamaterName'] != '') {
						$_line = new SafeguardParameters();
						$_line->SafeguardID = $id;
						$_line->SafeguardParamaterName = $line['SafeguardParamaterName'];
						$_line->save();
					}
				} else {
					$_line = SafeguardParameters::findOne($line['SafeguardParamaterID']);
					$_line->SafeguardParamaterName = $line['SafeguardParamaterName'];
					$_line->save();
				}
			}
			return $this->redirect(['view', 'id' => $model->SafeguardID]);
		}

		for ($x = count($parameters); $x <= 9; $x++) {
			$parameters[$x] = new SafeguardParameters();
		}

		return $this->render('update', [
			'model' => $model,
			'rights' => $this->rights,
			'parameters' => $parameters,
		]);
	}

	/**
	 * Deletes an existing Safeguards model.
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
	 * Finds the Safeguards model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Safeguards the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Safeguards::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public function actionGetfields($id)
	{		
		$row = $id -1;
		$Fields[0] = $id.'<input type="hidden" id="safeguardparameters-'.$row.'-safeguardparamaterid" class="form-control" name="SafeguardParameters['.$row.'][SafeguardParamaterID]">';
		
		$str = '<input type="text" id="safeguardparameters-'.$row.'-safeguardparamatername" class="form-control" name="SafeguardParameters['.$row.'][SafeguardParamaterName]">';

		$Fields[1] = $str;

		$json = json_encode($Fields);
		echo $json;
	}
}
