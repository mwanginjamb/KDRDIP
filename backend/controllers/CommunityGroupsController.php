<?php

namespace backend\controllers;

use Yii;
use app\models\CommunityGroups;
use app\models\Counties;
use app\models\SubCounties;
use app\models\Wards;
use app\models\CommunityGroupStatus;
use app\models\GroupMembers;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * CommunityGroupsController implements the CRUD actions for CommunityGroups model.
 */
class CommunityGroupsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(88);

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
	 * Lists all CommunityGroups models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => CommunityGroups::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single CommunityGroups model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => GroupMembers::find()->where(['CommunityGroupID' => $id]),
		]);

		return $this->render('view', [
			'model' => $this->findModel($id),
			'rights' => $this->rights,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Creates a new CommunityGroups model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new CommunityGroups();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->CommunityGroupID]);
		}

		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->where(['CountyID' => $model->CountyID])->all(), 'SubCountyID', 'SubCountyName');
		$wards = ArrayHelper::map(Wards::find()->where(['SubCountyID' => $model->SubCountyID])->all(), 'WardID', 'WardName');
		$communityGroupStatus = ArrayHelper::map(CommunityGroupStatus::find()->all(), 'CommunityGroupStatusID', 'CommunityGroupStatusName');

		return $this->render('create', [
			'model' => $model,
			'rights' => $this->rights,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'wards' => $wards,
			'communityGroupStatus' => $communityGroupStatus,
		]);
	}

	/**
	 * Updates an existing CommunityGroups model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->CommunityGroupID]);
		}

		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->where(['CountyID' => $model->CountyID])->all(), 'SubCountyID', 'SubCountyName');
		$wards = ArrayHelper::map(Wards::find()->where(['SubCountyID' => $model->SubCountyID])->all(), 'WardID', 'WardName');
		$communityGroupStatus = ArrayHelper::map(CommunityGroupStatus::find()->all(), 'CommunityGroupStatusID', 'CommunityGroupStatusName');

		return $this->render('update', [
			'model' => $model,
			'rights' => $this->rights,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'wards' => $wards,
			'communityGroupStatus' => $communityGroupStatus,
		]);
	}

	/**
	 * Deletes an existing CommunityGroups model.
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
	 * Finds the CommunityGroups model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CommunityGroups the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = CommunityGroups::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}