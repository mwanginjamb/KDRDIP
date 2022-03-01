<?php

namespace backend\controllers;

use Yii;
use app\models\ResultIndicators;
use app\models\IndicatorTypes;
use app\models\ResultIndicatorTargets;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use backend\controllers\RightsController;

/**
 * ResultIndicatorsController implements the CRUD actions for ResultIndicators model.
 */
class ResultFrameworkController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(119);

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
	 * Lists all ResultIndicators models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		/*$model = IndicatorTypes::find()->andWhere(['IN', 'IndicatorTypeID', [3, 4]])
														->with(['resultIndicators', 'resultIndicators.resultIndicatorTargets','resultIndicators.resultIndicatorTargets.quarterlyTargets'])
														->asArray()
														->all();*/

		$model = ResultIndicators::find()
		->joinWith('indicatorTypes')
		->joinWith('resultIndicatorTargets')
		->andWhere(['IN', 'result_indicators.IndicatorTypeID', [3, 4]])
		->asArray()
		->all();

		/*print('<pre>');
		print_r($model); exit;*/

		return $this->render('index', [
			'model' => $model,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single ResultIndicators model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => ResultIndicatorTargets::find()->andWhere(['ResultIndicatorID' => $id]),
		]);

		return $this->render('view', [
			'model' => $this->findModel($id),
			'rights' => $this->rights,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Finds the ResultIndicators model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return ResultIndicators the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = ResultIndicators::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
