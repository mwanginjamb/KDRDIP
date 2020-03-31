<?php

namespace backend\controllers;

use Yii;
use app\models\ProducerOrganizations;
use app\models\producerOrgMembers;
use app\models\CommunityGroups;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * ProducerOrganizationsController implements the CRUD actions for ProducerOrganizations model.
 */
class ProducerOrganizationsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(91);

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
	 * Lists all ProducerOrganizations models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => ProducerOrganizations::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single ProducerOrganizations model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{

		if (Yii::$app->request->post()) {
			$model = $this->findModel($id);
			$this->saveProducerOrgMembers(Yii::$app->request->post()['ProducerOrgMembers'], $model);
			return $this->redirect(['view', 'id' => $id]);
		}

		$producerOrgMembers = ProducerOrgMembers::find()->where(['ProducerOrganizationID' => $id])->all();
		$communityGroups = ArrayHelper::map(CommunityGroups::find()->all(), 'CommunityGroupID', 'CommunityGroupName');

		for ($x = count($producerOrgMembers); $x <= 4; $x++) {
			$producerOrgMembers[$x] = new ProducerOrgMembers();
		}

		return $this->render('view', [
			'model' => $this->findModel($id),
			'rights' => $this->rights,
			'producerOrgMembers' => $producerOrgMembers,
			'communityGroups' => $communityGroups,
		]);
	}

	/**
	 * Creates a new ProducerOrganizations model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new ProducerOrganizations();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->ProducerOrganizationID]);
		}

		return $this->render('create', [
			'model' => $model,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing ProducerOrganizations model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->ProducerOrganizationID]);
		}

		return $this->render('update', [
			'model' => $model,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing ProducerOrganizations model.
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


	public function actionRemove($id, $pid)
	{
		ProducerOrgMembers::findOne($id)->delete();

		return $this->redirect(['view', 'id' => $pid]);
	}

	/**
	 * Finds the ProducerOrganizations model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return ProducerOrganizations the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = ProducerOrganizations::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	private static function saveProducerOrgMembers($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['ProducerOrgMemberID'] == '') {
				if (trim($column['CommunityGroupID']) != '') {
					$_column = new ProducerOrgMembers();
					$_column->ProducerOrganizationID = $model->ProducerOrganizationID;
					$_column->CommunityGroupID = $column['CommunityGroupID'];
					$_column->save();
				}
			} else {
				$_column = ProducerOrgMembers::findOne($column['ProducerOrgMemberID']);
				$_column->CommunityGroupID = $column['CommunityGroupID'];
				$_column->save();
			}
		}
	}
}
