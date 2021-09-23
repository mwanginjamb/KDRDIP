<?php

namespace backend\controllers;

use Yii;
use app\models\Documents;
use app\models\DocumentTypes;
use app\models\DocumentSubCategories;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\controllers\RightsController;
use backend\controllers\EmployeesController;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * DocumentsController implements the CRUD actions for Documents model.
 */
class SafeguardsDocumentsController extends Controller
{
	// public const MAIN_URL = '';
	public $rights;

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(130);

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
	 * Lists all Documents models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$pId = isset(Yii::$app->request->get()['pId']) ? Yii::$app->request->get()['pId'] : 0;

		$dataProvider = new ActiveDataProvider([
			'query' => Documents::find()->andWhere(['RefNumber' => $pId, 'DocumentCategoryID' => 6]),
		]);

		return $this->renderPartial('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'pId' => $pId,
		]);
	}

	/**
	 * Displays a single Documents model.
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
	 * Creates a new Documents model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$pId = isset(Yii::$app->request->get()['pId']) ? Yii::$app->request->get()['pId'] : 0;

		$model = new Documents();
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		$model->DocumentCategoryID = 6;
		$model->RefNumber = $pId;
		$model->ApprovalStatusID = 1;

		if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
			$model->Image = $model->formatImage();
			if ($model->upload()) {
				 // file is uploaded successfully
				//if ($model->save()) {
					return $this->redirect(['index', 'pId' => $pId]);
				//}
			}
		}

		$documentTypes = ArrayHelper::map(DocumentTypes::find()->orderBy('DocumentTypeName')->all(), 'DocumentTypeID', 'DocumentTypeName');
		$documentSubCategories = ArrayHelper::map(DocumentSubCategories::find()->andWhere(['DocumentCategoryID' => 6])->orderBy('DocumentSubCategoryName')->all(), 'DocumentSubCategoryID', 'DocumentSubCategoryName');
				
		return $this->renderPartial('create', [
			'model' => $model,
			'documentTypes' => $documentTypes,
			'documentSubCategories' => $documentSubCategories,
		]);
	}

	/**
	 * Updates an existing Documents model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if (Yii::$app->request->isPost) {
			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
			if ($model->imageFile) {
				$filename = (string) time() . '_' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
				$model->imageFile->saveAs('uploads/' . $filename);
				$model->FileName = $filename;
			}
		}

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index', 'pId' => $model->RefNumber]);
		}

		$documentTypes = ArrayHelper::map(DocumentTypes::find()->orderBy('DocumentTypeName')->all(), 'DocumentTypeID', 'DocumentTypeName');
		$documentSubCategories = ArrayHelper::map(DocumentSubCategories::find()->andWhere(['DocumentCategoryID' => 6])->orderBy('DocumentSubCategoryName')->all(), 'DocumentSubCategoryID', 'DocumentSubCategoryName');

		return $this->renderPartial('update', [
			'model' => $model,
			'documentTypes' => $documentTypes,
			'documentSubCategories' => $documentSubCategories,
		]);
	}

	/**
	 * Deletes an existing Documents model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$this->findModel($id)->delete();

		return $this->redirect(['index', 'pId' => $model->RefNumber]);
	}

	/**
	 * Finds the Documents model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Documents the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Documents::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
