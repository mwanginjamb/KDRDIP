<?php

namespace backend\controllers;

use Yii;
use app\models\Users;
use app\models\UserGroups;
use app\models\UserStatus;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'delete' => ['POST'],
					],
			],
		];
	}

	/**
	 * Lists all Users models.
	 * @return mixed
	 */
	public function actionIndex()
	{

		$dataProvider = new ActiveDataProvider([
			'query' => $dataProvider = Users::find()->joinWith('userstatus')->joinWith('usergroups'),
		]);
		
		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Users model.
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
	 * Creates a new Users model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Users();
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		
		if (Yii::$app->request->post())
		{
			// $params = Yii::$app->request->post();
			$password =  Yii::$app->request->post()['Users']['Password'];
			$model->AuthKey = \Yii::$app->security->generateRandomString();
			$model->PasswordHash = \Yii::$app->security->generatePasswordHash($password);
		}

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			// return $this->redirect(['view', 'id' => $model->UserID]);
			return $this->redirect(['index']);
		}

		$usergroups = ArrayHelper::map(UserGroups::find()->all(), 'UserGroupID', 'UserGroupName');
		$userstatus = ArrayHelper::map(UserStatus::find()->all(), 'UserStatusID', 'UserStatusName');

		return $this->render('create', [
			'model' => $model,
			'usergroups' => $usergroups,
			'userstatus' => $userstatus
		]);
	}

	/**
	 * Updates an existing Users model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			// return $this->redirect(['view', 'id' => $model->UserID]);
			return $this->redirect(['index']);
		}

		$usergroups = ArrayHelper::map(UserGroups::find()->all(), 'UserGroupID', 'UserGroupName');
		$userstatus = ArrayHelper::map(UserStatus::find()->all(), 'UserStatusID', 'UserStatusName');

		return $this->render('update', [
			'model' => $model,
			'usergroups' => $usergroups,
			'userstatus' => $userstatus
		]);
	}

	/**
	 * Deletes an existing Users model.
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
	 * Finds the Users model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Users the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Users::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
