<?php

namespace backend\controllers;

use Yii;
use app\models\SafeguardQuestionResponses;
use app\models\SafeguardQuestions;
use app\models\SafeguardQuestionOptions;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * SafeguardQuestionResponsesController implements the CRUD actions for SafeguardQuestionResponses model.
 */
class SafeguardQuestionResponsesController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(130);

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
	 * Lists all SafeguardQuestionResponses models.
	 * @return mixed
	 */
	public function actionIndex($tab, $categoryId, $pId)
	{
		if (Yii::$app->request->post()) {
			$params = Yii::$app->request->post()['SafeguardQuestionResponses'];
			// print('<pre>');
			// print_r($params); exit;

			foreach ($params as $key => $param) {
				if (!$param['SafeguardQuestionResponseID']) {
					$_line = new SafeguardQuestionResponses();
					$_line->ProjectID = $pId;
					$_line->SafeguardQuestionID = $param['SafeguardQuestionID'];
				} else {
					$_line = SafeguardQuestionResponses::findOne($param['SafeguardQuestionResponseID']);
				}

				$_line->Response = $param['Response'];
				if (!$_line->save()) {
					$_line->getErrors(); exit;
				}
			}			
		}

		$sql = "Select * FROM (
						Select * FROM safeguard_question_responses WHERE ProjectID = $pId
					) temp 
					RIGHT JOIN (						
						select temp2.*, sub.SafeguardQuestionSubCategoryName from (
							Select 
								SafeguardQuestionID as SafeguardQID, 
								SafeguardQuestion, 
								safeguard_questions.SafeguardQuestionSubCategoryID, 
								SafeguardQuestionTypeID		
							FROM safeguard_questions
							WHERE safeguard_questions.SafeguardQuestionCategoryID = $categoryId
						) temp2 
						LEFT JOIN safeguard_question_sub_categories as sub on sub.SafeguardQuestionSubCategoryID = temp2.SafeguardQuestionSubCategoryID
					) as questions ON questions.SafeguardQID = temp.SafeguardQuestionID";
		$model = SafeguardQuestions::findBySql($sql)->asArray()->all();

		$lines = [];
		foreach ($model as $x => $row) {
			$lines[$x] = new SafeguardQuestionResponses();
			$lines[$x]->SafeguardQuestionResponseID = $row['SafeguardQuestionResponseID'];
			$lines[$x]->ProjectID = $row['ProjectID'];
			$lines[$x]->SafeguardQuestionID = $row['SafeguardQID'];
			$lines[$x]->Response = $row['Response'];
			$lines[$x]->SafeguardQuestion = $row['SafeguardQuestion'];
			$lines[$x]->SafeguardQuestionTypeID = $row['SafeguardQuestionTypeID'];
		}

		$yes_No = ['Yes' => 'Yes', 'No' => 'No'];
		$safeguardQuestionOptions = ArrayHelper::map(SafeguardQuestionOptions::find()->all(), 'SafeguardQuestionOptionID', 'SafeguardQuestionOptionName', 'SafeguardQuestionID');
		
		return $this->renderPartial('index', [
			'lines' => $lines,
			'yes_No' => $yes_No,
			'safeguardQuestionOptions' => $safeguardQuestionOptions,
			'tab' => $tab, 
			'categoryId' => $categoryId,
			'pId' => $pId,
		]);
	}

	/**
	 * Displays a single SafeguardQuestionResponses model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->renderPartial('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new SafeguardQuestionResponses model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new SafeguardQuestionResponses();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->SafeguardQuestionResponseID]);
		}

		return $this->renderPartial('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing SafeguardQuestionResponses model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->SafeguardQuestionResponseID]);
		}

		return $this->renderPartial('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing SafeguardQuestionResponses model.
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
	 * Finds the SafeguardQuestionResponses model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return SafeguardQuestionResponses the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = SafeguardQuestionResponses::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
