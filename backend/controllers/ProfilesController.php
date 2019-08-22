<?php

namespace backend\controllers;

use Yii;
use app\models\Profiles;
use app\models\ProfileStatus;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ProfilesController implements the CRUD actions for Profiles model.
 */
class ProfilesController extends Controller
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
	 * Lists all Profiles models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		return $this->render('index', [
			'model' => Profiles::find()->joinWith('profilestatus')->all()
		]);
	}

	/**
	 * Displays a single Profiles model.
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
	 * Creates a new Profiles model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Profiles();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->ProfileID]);
		}

		$profilestatus = ArrayHelper::map(ProfileStatus::find()->all(), 'ProfileStatusID', 'ProfileStatusName');

		return $this->render('create', [
			'model' => $model,
			'profilestatus' => $profilestatus
		]);
	}

	/**
	 * Updates an existing Profiles model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->ProfileID]);
		}

		$profilestatus = ArrayHelper::map(ProfileStatus::find()->all(), 'ProfileStatusID', 'ProfileStatusName');

		return $this->render('update', [
			'model' => $model,
			'profilestatus' => $profilestatus
		]);
	}

	/**
	 * Deletes an existing Profiles model.
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
	 * Finds the Profiles model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Profiles the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Profiles::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
