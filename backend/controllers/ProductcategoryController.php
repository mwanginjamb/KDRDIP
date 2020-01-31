<?php

namespace backend\controllers;

use Yii;
use app\models\ProductCategory;
use app\models\Stores;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use backend\controllers\RightsController;

/**
 * ProductcategoryController implements the CRUD actions for Productcategory model.
 */
class ProductcategoryController extends Controller
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
	 * Lists all Productcategory models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => ProductCategory::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Productcategory model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Productcategory model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$identity = Yii::$app->user->identity;
		$UserID = $identity->UserID;
	
		$model = new ProductCategory();
		$model->CreatedBy = $UserID;
	
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->ProductCategoryID]);
		} else {
			$stores = ArrayHelper::map(Stores::find()->all(), 'StoreID', 'StoreName');
			return $this->render('create', [
					'model' => $model, 'stores' => $stores,
			]);
		}
	}

	/**
	 * Updates an existing Productcategory model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->ProductCategoryID]);
		} else {
			$stores = ArrayHelper::map(Stores::find()->all(), 'StoreID', 'StoreName');
			return $this->render('update', [
					'model' => $model, 'stores' => $stores,
			]);
		}
	}

	/**
	 * Deletes an existing Productcategory model.
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
	 * Finds the Productcategory model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Productcategory the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = ProductCategory::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
