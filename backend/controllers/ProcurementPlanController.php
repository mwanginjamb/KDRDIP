<?php

namespace backend\controllers;

use Yii;
use app\models\ProcurementPlan;
use app\models\ProcurementPlanLines;
use app\models\UnitsOfMeasure;
use app\models\ProcurementMethods;
use app\models\ProcurementActivities;
use app\models\ProcurementActivityLines;
use app\models\Documents;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

/**
 * ProcurementPlanController implements the CRUD actions for ProcurementPlan model.
 */
class ProcurementPlanController extends Controller
{
	public $rights;

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(124);

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
	 * Lists all ProcurementPlan models.
	 * @return mixed
	 */
	public function actionIndex($pId)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => ProcurementPlan::find()->andWhere(['ProjectID' => $pId]),
		]);

		return $this->renderPartial('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'pId' => $pId,
		]);
	}

	/**
	 * Displays a single ProcurementPlan model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => ProcurementPlanLines::find()->andWhere(['ProcurementPlanID'=> $id]),
		]);

		return $this->renderPartial('view', [
			'model' => $this->findModel($id),
			'rights' => $this->rights,
			'dataProvider' => $dataProvider,
			'pId' => $id,
		]);
	}

	/**
	 * Creates a new ProcurementPlan model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($pId)
	{
		$model = new ProcurementPlan();
		$model->ProjectID = $pId;
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			$params = Yii::$app->request->post()['PurchaseLines'];
			$errors = ActiveForm::validate($model);

			foreach ($params as $key => $param) {
				$line = new ProcurementPlanLines();
				if (!$param['ProcurementPlanLineID']) {
					$param['ProcurementPlanID'] = 1;
					$line = new ProcurementPlanLines();
					$line->CreatedBy = 1;
					$line->ProcurementPlanLineID = 0;
				} else {
					$line = ProcurementPlanLines::findOne($param['ProcurementPlanLineID']);
				}
				$line->load(['ProcurementPlanLines' => $param]);
				$error = ActiveForm::validate($line);
				if (!empty($error)) {
					$errors[$key] = $error;
				}
			}
			if (isset(Yii::$app->request->post()['submit']) && empty($errors)) {
			} else {
				return $errors;
			}
		}

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$this->saveLines(Yii::$app->request->post()['ProcurementPlanLines'], $model);
			return $this->redirect(['view', 'id' => $model->ProcurementPlanID]);
		}

		for ($x = 0; $x < 5; $x++) {
			$lines[$x] = new ProcurementPlanLines();
			$lines[$x]->ProcurementPlanID = 0;
			$lines[$x]->CreatedBy = 0;
		}

		$procurementMethods = ArrayHelper::map(ProcurementMethods::find()->orderBy('ProcurementMethodName')->all(), 'ProcurementMethodID', 'ProcurementMethodName');
		$unitsOfMeasure = ArrayHelper::map(UnitsOfMeasure::find()->orderBy('UnitOfMeasureName')->all(), 'UnitOfMeasureID', 'UnitOfMeasureName');

		return $this->renderPartial('create', [
			'model' => $model,
			'rights' => $this->rights,
			'lines' => $lines,
			'procurementMethods' => $procurementMethods,
			'unitsOfMeasure' => $unitsOfMeasure,
		]);
	}

	/**
	 * Updates an existing ProcurementPlan model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			$params = Yii::$app->request->post()['PurchaseLines'];
			$errors = ActiveForm::validate($model);

			foreach ($params as $key => $param) {
				$line = new ProcurementPlanLines();
				if (!$param['ProcurementPlanLineID']) {
					$param['ProcurementPlanID'] = 1;
					$line = new ProcurementPlanLines();
					$line->CreatedBy = 1;
					$line->ProcurementPlanLineID = 0;
				} else {
					$line = ProcurementPlanLines::findOne($param['ProcurementPlanLineID']);
				}
				$line->load(['ProcurementPlanLines' => $param]);
				$error = ActiveForm::validate($line);
				if (!empty($error)) {
					$errors[$key] = $error;
				}
			}
			if (isset(Yii::$app->request->post()['submit']) && empty($errors)) {
			} else {
				return $errors;
			}
		}

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$this->saveLines(Yii::$app->request->post()['ProcurementPlanLines'], $model);
			return $this->redirect(['view', 'id' => $model->ProcurementPlanID]);
		}

		$lines = ProcurementPlanLines::find()->andWhere(['ProcurementPlanID' => $id])->all();
		$totalLines = count($lines) + 1;

		for ($x = count($lines); $x <= $totalLines; $x++) {
			$lines[$x] = new ProcurementPlanLines();
			$lines[$x]->ProcurementPlanID = 0;
			$lines[$x]->CreatedBy = 0;
		}
		
		$procurementMethods = ArrayHelper::map(ProcurementMethods::find()->orderBy('ProcurementMethodName')->all(), 'ProcurementMethodID', 'ProcurementMethodName');
		$unitsOfMeasure = ArrayHelper::map(UnitsOfMeasure::find()->orderBy('UnitOfMeasureName')->all(), 'UnitOfMeasureID', 'UnitOfMeasureName');

		return $this->renderPartial('update', [
			'model' => $model,
			'rights' => $this->rights,
			'lines' => $lines,
			'procurementMethods' => $procurementMethods,
			'unitsOfMeasure' => $unitsOfMeasure,
		]);
	}

	/**
	 * Deletes an existing ProcurementPlan model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$this->findModel($id)->delete();

		return $this->redirect(['index', 'pId' => $model->ProjectID]);
	}

	/**
	 * Lists all activities models.
	 * @return mixed
	 */
	public function actionActivities($id)
	{
		$procurementPlanLine = ProcurementPlanLines::findOne(['ProcurementPlanLineID' => $id]);
		$dataProvider = new ActiveDataProvider([
			'query' => ProcurementActivityLines::find()->andWhere(['ProcurementPlanLineID' => $id]),
		]);

		return $this->renderPartial('activities', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'procurementPlanLine' => $procurementPlanLine,
		]);
	}

	/**
	 * Updates an existing ProcurementPlan model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionActivityUpdate($id)
	{
		$model = ProcurementActivityLines::findOne($id);

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
			if ($model->save()) {
				if ($model->imageFile) {
					$document = new Documents();
					$document->Description = 'Procurement Plan';
					$document->DocumentTypeID = 3;
					$document->DocumentCategoryID = 4;
					$document->RefNumber = $model->ProcurementActivityLineID;
					$document->Image = $model->formatImage();
					$document->imageFile = $model->imageFile;
					$document->CreatedBy = Yii::$app->user->identity->UserID;
					if (!$document->save()) {
						// print_r($document->getErrors()); exit;
					}
				}
				return $this->redirect(['activities', 'id' => $model->ProcurementPlanLineID]);
			}
		}

		$dataProvider = new ActiveDataProvider([
			'query' => Documents::find()->andWhere(['RefNumber' => $id, 'DocumentCategoryID' => 4]),
		]);

		return $this->renderPartial('activity-form', [
			'model' => $model,
			'rights' => $this->rights,
			'dataProvider' => $dataProvider,
		]);
	}

		/**
	 * Updates an existing ProcurementPlan model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionLineCreate($pId)
	{
		$model = new ProcurementPlanLines();
		$model->ProcurementPlanID = $pId;
		$model->ProcurementPlanActionID = 1;
		$model->ApprovalStatusID = 1;

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->save()) {
				$activities = ProcurementActivities::find()->all();
				foreach ($activities as $key => $activity) {
					$lines = new ProcurementActivityLines();
					$lines->ProcurementPlanLineID = $model->ProcurementPlanLineID;
					$lines->ProcurementActivityID = $activity->ProcurementActivityID;
					$lines->CreatedBy = Yii::$app->user->identity->UserID;
					$lines->save();
				}
				return $this->redirect(['view', 'id' => $pId]);
			}
		}

		$procurementMethods = ArrayHelper::map(ProcurementMethods::find()->orderBy('ProcurementMethodName')->all(), 'ProcurementMethodID', 'ProcurementMethodName');
		$unitsOfMeasure = ArrayHelper::map(UnitsOfMeasure::find()->orderBy('UnitOfMeasureName')->all(), 'UnitOfMeasureID', 'UnitOfMeasureName');

		return $this->renderPartial('line-form', [
			'model' => $model,
			'rights' => $this->rights,
			'procurementMethods' => $procurementMethods,
			'unitsOfMeasure' => $unitsOfMeasure,
		]);
	}

	public function actionSubmit($id)
	{
		$model = $this->findModel($id);
		$model->ApprovalStatusID = 1;
		if ($model->save()) {
			// $result = UsersController::sendEmailNotification(29);
			return $this->redirect(['view', 'id' => $model->ProcurementPlanID]);
		}
	}

	public function actionRemoveLine($id)
	{
		$model = ProcurementPlanLines::findOne($id);
		$model->ProcurementPlanActionID = 2;
		$model->ApprovalStatusID = 1;
		$model->save();
		return $this->redirect(['view', 'id' => $model->ProcurementPlanLines->ProcurementPlanID]);
	}

	/**
	 * Finds the ProcurementPlan model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return ProcurementPlan the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = ProcurementPlan::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public function actionGetfields($id, $ProcurementPlanID)
	{
		$procurementMethods = ArrayHelper::map(ProcurementMethods::find()->orderBy('ProcurementMethodName')->all(), 'ProcurementMethodID', 'ProcurementMethodName');
		$unitsOfMeasure = ArrayHelper::map(UnitsOfMeasure::find()->orderBy('UnitOfMeasureName')->all(), 'UnitOfMeasureID', 'UnitOfMeasureName');

		$row = $id - 1;
		$Fields[0] = $id . '<input type="hidden" id="procurementplanlines-' . $row . '-procurementplanlineid" class="form-control" name="ProcurementPlanLines[' . $row . '][ProcurementPlanLineID]">';
		$Fields[0] .= '<input type="hidden" id="procurementplanlines-' . $row . '-procurementplanid" class="form-control" name="ProcurementPlanLines[' . $row . '][ProcurementPlanID]" value="">';
		// Items Field

		$Fields[1] = '<div class="form-group field-procurementplanlines-' . $row . '-servicedescription">';
		$Fields[1] .= '<input type="text" id="procurementplanlines-' . $row . '-servicedescription" class="form-control" name="ProcurementPlanLines[' . $row . '][ServiceDescription]">';
		$Fields[1] .= '<div class="help-block"></div>';
		$Fields[1] .= '</div>';

		$Fields[2] = '<div class="form-group field-procurementplanlines-' . $row . '-unitofmeasureid">';
		$Fields[2] .= '<select id="procurementplanlines-' . $row . '-unitofmeasureid" class="form-control" name="ProcurementPlanLines[' . $row . '][UnitOfMeasureID]">';
		$Fields[2] .= self::generateOptions($unitsOfMeasure);
		$Fields[2] .= '</select>';
		$Fields[2] .= '<div class="help-block"></div>';
		$Fields[2] .= '</div>';

		$Fields[3] = '<div class="form-group field-procurementplanlines-' . $row . '-quantity">';
		$Fields[3] .= '<input type="text" id="procurementplanlines-' . $row . '-quantity" class="form-control" name="ProcurementPlanLines[' . $row . '][Quantity]" style="text-align: right">';
		$Fields[3] .= '<div class="help-block"></div>';
		$Fields[3] .= '</div>';

		$Fields[4] = '<div class="form-group field-procurementplanlines-' . $row . '-procurementmethodid">';
		$Fields[4] .= '<select id="procurementplanlines-' . $row . '-procurementmethodid" class="form-control" name="ProcurementPlanLines[' . $row . '][ProcurementMethodID]">';
		$Fields[4] .= self::generateOptions($procurementMethods);
		$Fields[4] .= '</select>';
		$Fields[4] .= '<div class="help-block"></div>';
		$Fields[4] .= '</div>';

		$Fields[5] = '<div class="form-group field-procurementplanlines-' . $row . '-sourcesoffunds">';
		$Fields[5] .= '<input type="text" id="procurementplanlines-' . $row . '-sourcesoffunds" class="form-control" name="ProcurementPlanLines[' . $row . '][SourcesOfFunds]">';
		$Fields[5] .= '<div class="help-block"></div>';
		$Fields[5] .= '</div>';

		$Fields[6] = '<div class="form-group field-procurementplanlines-' . $row . '-estimatedcost">';
		$Fields[6] .= '<input type="text" id="procurementplanlines-' . $row . '-estimatedcost" class="form-control" name="ProcurementPlanLines[' . $row . '][EstimatedCost]" style="text-align: right">';
		$Fields[6] .= '<div class="help-block"></div>';
		$Fields[6] .= '</div>';

		$Fields[7] = '<a class="btn btn-warning waves-effect waves-light" onclick="removeRow(' . $row . ')"><i class="ft-minus"></i></a>';

		$json = json_encode($Fields);
		echo $json;
	}

	public static function generateOptions($values)
	{
		$str = '<option value=""></option>';
		foreach ($values as $key => $value)	{
			$str .= '<option value="' . $key . '">' . $value . '</option>';
		}
		return $str;
	}

	public static function saveLines($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['ServiceDescription'] != '') {
				$column['ProcurementPlanID'] = $model->ProcurementPlanID;
				if (!$column['ProcurementPlanLineID']) {
					$_column = new ProcurementPlanLines();
					if ($_column->load(['ProcurementPlanLines' => $column]) && $_column->save()) {
						$activities = ProcurementActivities::find()->all();
						foreach ($activities as $key => $activity) {
							$lines = new ProcurementActivityLines();
							$lines->ProcurementPlanLineID = $_column->ProcurementPlanLineID;
							$lines->ProcurementActivityID = $activity->ProcurementActivityID;
							$lines->CreatedBy = Yii::$app->user->identity->UserID;
							$lines->save();
						}						
					} else {
					}
				} else {
					$_column = ProcurementPlanLines::findOne($column['ProcurementPlanLineID']);
					if ($_column->load(['ProcurementPlanLines' => $column]) && $_column->save()) {
					}
				}
			}
		}
	}
}
