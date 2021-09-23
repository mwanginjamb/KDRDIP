<?php

namespace backend\controllers;

use Yii;
use app\models\OrganizationTrainings;
use app\models\TrainingTypes;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * OrganizationTrainingsController implements the CRUD actions for OrganizationTrainings model.
 */
class OrganizationTrainingsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(139);

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
     * Lists all OrganizationTrainings models.
     * @return mixed
     */
    public function actionIndex($oId)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => OrganizationTrainings::find(),
        ]);

        return $this->renderPartial('index', [
            'dataProvider' => $dataProvider,
            'rights' => $this->rights,
			'oId' => $oId,
        ]);
    }

    /**
     * Displays a single OrganizationTrainings model.
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
     * Creates a new OrganizationTrainings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($oId)
    {
        $model = new OrganizationTrainings();
        $model->OrganizationID = $oId;
        $model->CreatedBy = Yii::$app->user->identity->UserID;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'oId' => $model->OrganizationID]);
        }

        $trainingTypes = ArrayHelper::map(TrainingTypes::find()->orderBy('TrainingTypeName')->all(), 'TrainingTypeId', 'TrainingTypeName');

        return $this->renderPartial('create', [
            'model' => $model,
            'trainingTypes' => $trainingTypes,
            'rights' => $this->rights,
        ]);
    }

    /**
     * Updates an existing OrganizationTrainings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'oId' => $model->OrganizationID]);
        }

        $trainingTypes = ArrayHelper::map(TrainingTypes::find()->orderBy('TrainingTypeName')->all(), 'TrainingTypeId', 'TrainingTypeName');

        return $this->renderPartial('update', [
            'model' => $model,
            'trainingTypes' => $trainingTypes,
            'rights' => $this->rights,
        ]);
    }

    /**
     * Deletes an existing OrganizationTrainings model.
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
     * Finds the OrganizationTrainings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrganizationTrainings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrganizationTrainings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}