<?php

namespace backend\controllers;

use Yii;
use app\models\GroupMembers;
use app\models\GroupRoles;
use app\models\HouseholdTypes;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * GroupMembersController implements the CRUD actions for GroupMembers model.
 */
class GroupMembersController extends Controller
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
	 * Lists all GroupMembers models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => GroupMembers::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single GroupMembers model.
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
	 * Creates a new GroupMembers model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($gid)
	{
		$model = new GroupMembers();
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		$model->CommunityGroupID = $gid;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['/community-groups/view', 'id' => $model->CommunityGroupID]);
		}

		$groupRoles = ArrayHelper::map(GroupRoles::find()->all(), 'GroupRoleID', 'GroupRoleName');
		$householdTypes = ArrayHelper::map(HouseholdTypes::find()->all(), 'HouseholdTypeID', 'HouseholdTypeName'); 
		$gender = ['M' => 'Male', 'F' => 'Female'];

		return $this->render('create', [
			'model' => $model,
			'groupRoles' => $groupRoles,
			'householdTypes' => $householdTypes,
			'gender' => $gender,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing GroupMembers model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['/community-groups/view', 'id' => $model->CommunityGroupID]);
		}

		$groupRoles = ArrayHelper::map(GroupRoles::find()->all(), 'GroupRoleID', 'GroupRoleName');
		$householdTypes = ArrayHelper::map(HouseholdTypes::find()->all(), 'HouseholdTypeID', 'HouseholdTypeName');
		$gender = ['M' => 'Male', 'F' => 'Female'];

		return $this->render('update', [
			'model' => $model,
			'groupRoles' => $groupRoles,
			'householdTypes' => $householdTypes,
			'gender' => $gender,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing GroupMembers model.
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
	 * Finds the GroupMembers model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return GroupMembers the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = GroupMembers::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
