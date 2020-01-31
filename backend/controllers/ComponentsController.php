<?php

namespace backend\controllers;

use Yii;
use app\models\Components;
use app\models\SubComponents;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * ComponentsController implements the CRUD actions for Components model.
 */
class ComponentsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(14);

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
	 * Lists all Components models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Components::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Components model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$subComponentsProvider = new ActiveDataProvider([
			'query' => SubComponents::find()->where(['ComponentID'=> $id]),
		]);

		return $this->render('view', [
			'model' => $this->findModel($id),
			'subComponentsProvider' => $subComponentsProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Creates a new Components model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Components();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			$columns = $params['SubComponents'];
			
			foreach ($columns as $key => $column) {
				if ($column['SubComponentID'] == '') {
					if (trim($column['SubComponentName']) != '') {
						$_column = new SubComponents();
						$_column->ComponentID = $model->ComponentID;
						$_column->SubComponentName = $column['SubComponentName'];
						$_column->CreatedBy = Yii::$app->user->identity->UserID;
						$_column->save();
					}
				} else {
					$_column = SubComponents::findOne($column['SubComponentID']);
					$_column->SubComponentName = $column['SubComponentName'];
					$_column->save();
				}
			}
			return $this->redirect(['view', 'id' => $model->ComponentID]);
		}
		for ($x = 0; $x <= 4; $x++) { 
			$subComponents[$x] = new SubComponents();
		}
		return $this->render('create', [
			'model' => $model,
			'subComponents' => $subComponents,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing Components model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$subComponents = SubComponents::find()->where(['ComponentID' => $id])->all();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			$columns = $params['SubComponents'];
			
			foreach ($columns as $key => $column) {
				if ($column['SubComponentID'] == '') {
					if (trim($column['SubComponentName']) != '') {
						$_column = new SubComponents();
						$_column->ComponentID = $model->ComponentID;
						$_column->SubComponentName = $column['SubComponentName'];
						$_column->CreatedBy = Yii::$app->user->identity->UserID;
						$_column->save();
					}
				} else {
					$_column = SubComponents::findOne($column['SubComponentID']);
					$_column->SubComponentName = $column['SubComponentName'];
					$_column->save();
				}
			}
			return $this->redirect(['view', 'id' => $model->ComponentID]);
		}

		for ($x = count($subComponents); $x <= 4; $x++) {
			$subComponents[$x] = new SubComponents();
		}

		return $this->render('update', [
			'model' => $model,
			'subComponents' => $subComponents,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing Components model.
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
	 * Finds the Components model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Components the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Components::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
