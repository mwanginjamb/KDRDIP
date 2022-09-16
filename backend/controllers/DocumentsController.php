<?php

namespace backend\controllers;

use Yii;
use app\models\Documents;
use app\models\DocumentTypes;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\controllers\RightsController;
use backend\controllers\EmployeesController;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * DocumentsController implements the CRUD actions for Documents model.
 */
class DocumentsController extends Controller
{
	// public const MAIN_URL = '';
	public $rights;
	public $doc;

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(144);



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
						'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
		$oId = isset(Yii::$app->request->get()['oId']) ? Yii::$app->request->get()['oId'] : 0;
		$type = isset(Yii::$app->request->get()['type']) ? Yii::$app->request->get()['type'] : '';

		$query = null;
		if ($pId) {
			$query = Documents::find()->andWhere(['RefNumber' => $pId, 'DocumentCategoryID' => 2]);
		} else if ($oId) {
			$documentType = DocumentTypes::find()->where(['like', 'DocumentTypeName', $type])->one();
			$category = $documentType->DocumentTypeID ?? '';
			$query = Documents::find()->andWhere(['RefNumber' => $oId, 'DocumentTypeID' => $category]);
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->doc = (object)[
			'pId' => $pId,
			'oId' => $oId,
			'type' => $type
		];

		return $this->renderPartial('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'pId' => $pId,
			'oId' => $oId,
			'type' => $type,
			'document' => $this->doc,

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
		$oId = isset(Yii::$app->request->get()['oId']) ? Yii::$app->request->get()['oId'] : 0;
		$type = isset(Yii::$app->request->get()['type']) ? Yii::$app->request->get()['type'] : '';

		$model = new Documents();
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		if ($oId) // Organization Document
		{
			// Get particular Organization Document Categories - Minutes / Registration Certificate
			$documentType = DocumentTypes::find()->where(['like', 'DocumentTypeName', $type])->one();
			$model->RefNumber = $oId;
			$model->DocumentTypeID = $documentType->DocumentTypeID ?? '';
			$model->DocumentCategoryID = $documentType->DocumentTypeID ?? '';
		} else if ($pId) { // Default to  Project Documents
			$model->DocumentCategoryID = 2;
			$model->RefNumber = $pId;
		}

		/*print '<pre>';
		print_r($model);
		exit;*/

		if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {

			// Yii::$app->response->format = Response::FORMAT_JSON;

			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');

			// return ['note' => $model->upload() ];
			Yii::$app->response->format = Response::FORMAT_JSON;
			if ($model->upload() == true) {
				Yii::$app->session->setFlash('success', 'File uploaded successfully.');
				return ['note' => 'File Uploaded Successfully.', 'model' => $model];
			} else {
				Yii::$app->session->setFlash('error', 'Couldn\'t upload document successfully.');
				return ['note' => 'Could not upload documents Successfully.'];
			}
		}

		$documentTypes = ArrayHelper::map(DocumentTypes::find()->orderBy('DocumentTypeName')->all(), 'DocumentTypeID', 'DocumentTypeName');

		return $this->renderPartial('create', [
			'model' => $model,
			'documentTypes' => $documentTypes
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

		return $this->renderPartial('update', [
			'model' => $model,
			'documentTypes' => $documentTypes,
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
