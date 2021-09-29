<?php

namespace backend\controllers;

use Yii;
use app\models\Organizations;
use app\models\Counties;
use app\models\Countries;
use app\models\LivelihoodActivities;
use app\models\SubCounties;
use app\models\Wards;
use app\models\SubLocations;
use app\models\OrganizationActivities;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * OrganizationsController implements the CRUD actions for Organizations model.
 */
class OrganizationsController extends Controller
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
			array_push($rightsArray, 'index', 'view', 'update', 'approval', 'approvallist', 'submit');
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
			'only' => ['index', 'view', 'create', 'update', 'delete', 'approval', 'approvallist', 'submit'],
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
     * Lists all Organizations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Organizations::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>  [
                'pageSize' => $countQuery->count()
            ],
            'totalCount' => $countQuery->count(),
            'sort' => [
                'defaultOrder' => [
                    'OrganizationID' => SORT_DESC,
                    'OrganizationName' => SORT_ASC,
                ],
            ],


        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'rights' => $this->rights,

        ]);
    }

    /**
     * Displays a single Organizations model.
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
     * Creates a new Organizations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Organizations();
        $model->CreatedBy = Yii::$app->user->identity->UserID;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->OrganizationID]);
        }

        $livelihoodActivities = ArrayHelper::map(LivelihoodActivities::find()->orderBy('LivelihoodActivityID')->all(), 'LivelihoodActivityID', 'LivelihoodActivityName');
        $countries = ArrayHelper::map(Countries::find()->orderBy('CountryName')->all(), 'CountryID', 'CountryName');
        $counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
        $subCounties = ArrayHelper::map(SubCounties::find()->where(['CountyID' => $model->CountyID ])->all(), 'SubCountyID', 'SubCountyName');
		$wards = ArrayHelper::map(Wards::find()->where(['SubCountyID' => $model->SubCountyID ])->all(), 'WardID', 'WardName');
        $subLocations = ArrayHelper::map(SubLocations::find()->where(['LocationID' => $model->WardID ])->all(), 'SubLocationID', 'SubLocationName');
		
        return $this->render('create', [
            'model' => $model,
            'countries' => $countries,
            'counties' => $counties,
            'subCounties' => $subCounties,
            'wards' => $wards,
            'subLocations' => $subLocations,
            'rights' => $this->rights,
            'livelihoodActivities' => $livelihoodActivities,
        ]);
    }

    /**
     * Updates an existing Organizations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->OrganizationID]);
        }

        $livelihoodActivities = ArrayHelper::map(LivelihoodActivities::find()->orderBy('LivelihoodActivityID')->all(), 'LivelihoodActivityID', 'LivelihoodActivityName');
        $countries = ArrayHelper::map(Countries::find()->orderBy('CountryName')->all(), 'CountryID', 'CountryName');
        $counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
        $subCounties = ArrayHelper::map(SubCounties::find()->where(['CountyID' => $model->CountyID ])->all(), 'SubCountyID', 'SubCountyName');
		$wards = ArrayHelper::map(Wards::find()->where(['SubCountyID' => $model->SubCountyID ])->all(), 'WardID', 'WardName');
        $subLocations = ArrayHelper::map(SubLocations::find()->where(['LocationID' => $model->WardID ])->all(), 'SubLocationID', 'SubLocationName');

        return $this->render('update', [
            'model' => $model,
            'countries' => $countries,
            'counties' => $counties,
            'subCounties' => $subCounties,
            'wards' => $wards,
            'subLocations' => $subLocations,
            'rights' => $this->rights,
            'livelihoodActivities' => $livelihoodActivities,
        ]);
    }

    /**
     * Deletes an existing Organizations model.
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
     * Finds the Organizations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Organizations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Organizations::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSubCounties($id)
	{
		$model = SubCounties::find()->orderBy('SubCountyName')->where(['CountyID' => $id])->all();
			
		if (!empty($model)) {
			echo '<option value="0">Select...</option>';
			foreach ($model as $item) {
				echo "<option value='" . $item->SubCountyID . "'>" . $item->SubCountyName . "</option>";
			}
		} else {
			echo '<option value="0">Select...</option>';
		}
	}

	public function actionWards($id)
	{
		$model = Wards::find()->orderBy('WardName')->where(['SubCountyID' => $id])->all();
			
		if (!empty($model)) {
			echo '<option value="0">Select...</option>';
			foreach ($model as $item) {
				echo "<option value='" . $item->WardID . "'>" . $item->WardName . "</option>";
			}
		} else {
			echo '<option value="0">Select...</option>';
		}
	}

	public function actionSubLocations($id)
	{
		$model = SubLocations::find()->where(['LocationID' => $id])->all();
			
		if (!empty($model)) {
			echo '<option value="0">Select...</option>';
			foreach ($model as $item) {
				echo "<option value='" . $item->SubLocationID . "'>" . $item->SubLocationName . "</option>";
			}
		} else {
			echo '<option value="0">Select...</option>';
		}
	}
}
