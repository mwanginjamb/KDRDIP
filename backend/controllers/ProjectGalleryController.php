<?php

namespace backend\controllers;

use Yii;
use app\models\ProjectGallery;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use backend\controllers\RightsController;
use backend\controllers\EmployeesController;
use yii\web\Response;

/**
 * ProjectGalleryController implements the CRUD actions for ProjectGallery model.
 */
class ProjectGalleryController extends Controller
{
	// public const MAIN_URL = '';
	public $rights;

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(143);

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
	 * Lists all ProjectGallery models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$pId = isset(Yii::$app->request->get()['pId']) ? Yii::$app->request->get()['pId'] : 0;

		$dataProvider = new ActiveDataProvider([
			'query' => ProjectGallery::find()->andWhere(['ProjectID' => $pId]),
		]);

		return $this->renderPartial('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'pId' => $pId,
		]);
	}

	/**
	 * Displays a single ProjectGallery model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new ProjectGallery model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($pId)
	{

		$model = new ProjectGallery();
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		$model->ProjectID = $pId;

		if (Yii::$app->request->isPost) {
			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');

			$data = file_get_contents($model->imageFile->tempName);
			$type = $model->imageFile->type;
			$model->Image = 'data:image/' . $type . ';base64,' . base64_encode($data);
			$model->extension = $model->imageFile->extension;
		}

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			Yii::$app->session->setFlash('success', 'Sub-project Image uploaded successfully.');
			return ['note' => 'File Uploaded Successfully.'];
			// return $this->redirect(['index', 'pId' => $model->ProjectID]);
		}

		return $this->renderPartial('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing ProjectGallery model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->ProjectGalleryID]);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing ProjectGallery model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->scenario = 'delete';
		$model->Deleted = 1;

		//$this->findModel($id)->delete();

		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		if ($model->save()) {
			return ['note' => '<div class="alert alert-success">Record Deleted Successfully. </div>'];
		} else {
			return ['note' => $model->errors];
		}


		// return $this->redirect(['index', 'pId' => $model->ProjectID]);
	}

	/**
	 * Finds the ProjectGallery model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return ProjectGallery the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = ProjectGallery::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
