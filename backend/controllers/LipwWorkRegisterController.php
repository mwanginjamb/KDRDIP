<?php

namespace backend\controllers;

use Yii;
use app\models\LipwWorkRegister;
use app\models\LipwBeneficiaries;
use app\models\LipwWorkHeader;
use app\models\LipwWorkLines;
use app\models\LipwMasterRoll;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * LipwWorkRegisterController implements the CRUD actions for LipwWorkRegister model.
 */
class LipwWorkRegisterController extends Controller
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
	 * Lists all LipwWorkRegister models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$mId = isset(Yii::$app->request->get()['mId']) ? Yii::$app->request->get()['mId'] : 0;

		$dataProvider = new ActiveDataProvider([
			'query' => LipwWorkRegister::find()->andWhere(['MasterRollID' => $mId]),
			'pagination' => false,
		]);

		return $this->renderPartial('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'mId' => $mId,
		]);
	}

	/**
	 * Displays a single LipwWorkRegister model.
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
	 * Creates a new LipwWorkRegister model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$mId = isset(Yii::$app->request->get()['mId']) ? Yii::$app->request->get()['mId'] : 0;

		$masterRoll = LipwMasterRoll::findOne($mId);
		$header = new LipwWorkHeader();
		$header->MasterRollID = $mId;

		if ($header->load(Yii::$app->request->post()) && $header->validate()) {
			$lines = Yii::$app->request->post()['LipwWorkLines'];
			$header = Yii::$app->request->post()['LipwWorkHeader'];

			foreach ($lines as $line) {
				if ($line['Worked'] == 1) {
					/* if ($line['WorkRegisterID'] == '') {
						$model = new LipwWorkRegister();
					} else {
						$model = LipwWorkRegister::findOne($line['WorkRegisterID']);
					} */

					/* Check if the beneficiary's entry exists for the same day */
					$exists = LipwWorkRegister::findOne([
						'MasterRollID' => $header['MasterRollID'],
						'BeneficiaryID' => $line['BeneficiaryID'],
						'Date' => $header['Date']
					]);

					if (empty($exists)) {
						/* if No entry exists create a new entry */
						$model = new LipwWorkRegister();
						$model->MasterRollID = $header['MasterRollID'];
						$model->BeneficiaryID = $line['BeneficiaryID'];
						$model->ProjectID = $header['ProjectID'];
						$model->Date = $header['Date'];
						$model->Amount = $line['Rate'];
						$model->save();
					}
				} else {
					if ($line['WorkRegisterID'] != '') {
					}
				}
			}
			return $this->redirect(['index', 'mId' => $header['MasterRollID']]);
		}
		
		$beneficiaries = LipwBeneficiaries::find()
			->joinWith('lipwHouseHolds')
			->joinWith('lipwMasterRollRegister')
			->andWhere(['lipw_households.SubLocationID' => $masterRoll->SubLocationID])
			->asArray()
			->all();
		$lines = [];
		foreach ($beneficiaries as $key => $beneficiary) {
			$lines[$key] = new LipwWorkLines();
			$lines[$key]->WorkRegisterID = null;
			$lines[$key]->BeneficiaryName = $beneficiary['FirstName'] . ' ' . $beneficiary['LastName'];
			$lines[$key]->BeneficiaryID = $beneficiary['BeneficiaryID'];
			$lines[$key]->Rate = $beneficiary['lipwMasterRollRegister']['Rate'];
			$lines[$key]->Worked = 2;
		}

		$projects = ArrayHelper::map(\app\models\Projects::find()->all(), 'ProjectID', 'ProjectName');

		$model = new LipwWorkRegister();
		return $this->renderPartial('create', [
			'model' => $model,
			'rights' => $this->rights,
			'header' => $header,
			'lines' => $lines,
			'projects' => $projects,
		]);
	}

	/**
	 * Updates an existing LipwWorkRegister model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index', 'mId' => $model->MasterRollID]);
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
	 * Deletes an existing LipwWorkRegister model.
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
	 * Finds the LipwWorkRegister model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return LipwWorkRegister the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = LipwWorkRegister::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
