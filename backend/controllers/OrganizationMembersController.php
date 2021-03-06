<?php

namespace backend\controllers;

use Yii;
use app\models\OrganizationMembers;
use app\models\AgeGroups;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * OrganizationMembersController implements the CRUD actions for OrganizationMembers model.
 */
class OrganizationMembersController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		/*
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
		}*/
		
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
						'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
     * Lists all OrganizationMembers models.
     * @return mixed
     */
    public function actionIndex($oId)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => OrganizationMembers::find()->where(['OrganizationID' => $oId]),
        ]);

        return $this->renderPartial('index', [
            'dataProvider' => $dataProvider,
            'rights' => $this->rights,
			'oId' => $oId,
        ]);
    }

    /**
     * Displays a single OrganizationMembers model.
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
     * Creates a new OrganizationMembers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($oId)
    {
        $model = new OrganizationMembers();
        $model->OrganizationID = $oId;
        $model->CreatedBy = Yii::$app->user->identity->UserID;

        if ($model->load(Yii::$app->request->post()) ) {

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if( $model->save())
            {
                Yii::$app->session->setFlash('success', 'Record Saved Successfully.', true);
				return ['success' => 'Record Saved Successfully'];
            }else{
                return ['errors' => $model->getErrorSummary(true)];
            }
            //return $this->redirect(['index', 'oId' => $model->OrganizationID]);
        }

        $gender = ['M' => 'Male', 'F' => 'Female'];
        $ageGroups = ArrayHelper::map(AgeGroups::find()->orderBy('AgeGroupName')->all(), 'AgeGroupID', 'AgeGroupName');

        return $this->renderPartial('create', [
            'model' => $model,
            'gender' => $gender,
            'ageGroups' => $ageGroups,
            'rights' => $this->rights,
        ]);
    }

    /**
     * Updates an existing OrganizationMembers model.
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

        $gender = ['M' => 'Male', 'F' => 'Female'];
        $ageGroups = ArrayHelper::map(AgeGroups::find()->orderBy('AgeGroupName')->all(), 'AgeGroupID', 'AgeGroupName');
        return $this->renderPartial('update', [
            'model' => $model,
            'gender' => $gender,
            'ageGroups' => $ageGroups,
            'rights' => $this->rights,
        ]);
    }

    /**
     * Deletes an existing OrganizationMembers model.
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
     * Finds the OrganizationMembers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrganizationMembers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrganizationMembers::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
