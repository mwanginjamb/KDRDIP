<?php

namespace backend\controllers;

use Yii;
use app\models\LipwMasterRollRegister;
use app\models\LipwBeneficiaries;
use app\models\LipwMasterRoll;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * LipwMasterRollRegisterController implements the CRUD actions for LipwMasterRollRegister model.
 */
class LipwMasterRollRegisterController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(99);

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
	 * Lists all LipwMasterRollRegister models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$mId = isset(Yii::$app->request->get()['mId']) ? Yii::$app->request->get()['mId'] : 0;

		$dataProvider = new ActiveDataProvider([
			'query' => LipwMasterRollRegister::find(),
		]);

		return $this->renderPartial('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'mId' => $mId,
		]);
	}

	/**
	 * Displays a single LipwMasterRollRegister model.
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
	 * Creates a new LipwMasterRollRegister model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$mId = isset(Yii::$app->request->get()['mId']) ? Yii::$app->request->get()['mId'] : 0;

		$masterRoll = LipwMasterRoll::findOne($mId);

		$model = new LipwMasterRollRegister();
		$model->MasterRollID = $mId;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->MasterRollRegisterID]);
		}

		$beneficiaries = ArrayHelper::map(LipwBeneficiaries::find()
			->joinWith('lipwHouseHolds')
			->andWhere(['lipwHouseHolds.SubLocationID' => $masterRoll->SubLocationID])
			->all(), 'BeneficiaryID', 'BeneficiaryName');

		return $this->renderPartial('create', [
			'model' => $model,
			'rights' => $this->rights,
			'beneficiaries' => $beneficiaries,
		]);
	}

	/**
	 * Updates an existing LipwMasterRollRegister model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->MasterRollRegisterID]);
		}

		$beneficiaries = ArrayHelper::map(LipwBeneficiaries::find()
			->joinWith('lipwHouseHolds')
			->andWhere(['lipw_households.SubLocationID' => $model->lipwMasterRoll->SubLocationID])
			->all(), 'BeneficiaryID', 'BeneficiaryName');

		return $this->renderPartial('update', [
			'model' => $model,
			'rights' => $this->rights,
			'beneficiaries' => $beneficiaries,
		]);
	}

	/**
	 * Deletes an existing LipwMasterRollRegister model.
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
	 * Finds the LipwMasterRollRegister model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return LipwMasterRollRegister the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = LipwMasterRollRegister::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
