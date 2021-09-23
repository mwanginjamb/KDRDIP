<?php

namespace backend\controllers;

use Yii;
use app\models\Counties;
use app\models\Projects;
use app\models\Organizations;
use app\models\BankAccounts;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * CountiesController implements the CRUD actions for Counties model.
 */
class CountiesController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(15);

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
	 * Lists all Counties models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Counties::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Counties model.
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
	 * Creates a new Counties model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Counties();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->CountyID]);
		}

		return $this->render('create', [
			'model' => $model,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing Counties model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->CountyID]);
		}

		return $this->render('update', [
			'model' => $model,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing Counties model.
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
	 * Finds the Counties model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Counties the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Counties::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public function actionProjects($id)
	{
		$model = Projects::find()->orderBy('ProjectName')->andWhere(['CountyID' => $id])->all();
		
		echo '<option value="">Select...</option>';
		foreach ($model as $item) {
			echo "<option value='" . $item->ProjectID . "'>" . $item->ProjectName . "</option>";
		}
	}

    public function actionOrganizations($id)
	{
		$model = Organizations::find()->orderBy('OrganizationName')->andWhere(['CountyID' => $id])->all();
		
		echo '<option value="">Select...</option>';
		foreach ($model as $item) {
			echo "<option value='" . $item->OrganizationID . "'>" . $item->OrganizationName . "</option>";
		}
	}

    public function actionBankAccounts($countyId, $disbursementTypeId, $categoryId)
	{
        // Categories 1 for source bank account and 2 for destination bank account
        if ($categoryId == 1) {
            if ($disbursementTypeId == 3) {
                $bankTypeId = 1;
            } elseif ($disbursementTypeId == 2)  {
                $bankTypeId = 2;
            } elseif ($disbursementTypeId == 1)  {
                $bankTypeId = 2;
            }        
        } else {
            if ($disbursementTypeId == 3) {
                $bankTypeId = 2;
            } elseif ($disbursementTypeId == 2)  {
                $bankTypeId = 3;
            } elseif ($disbursementTypeId == 1)  {
                $bankTypeId = 4;
            }    
        }

		if ($bankTypeId == 1) {
            $model = BankAccounts::find()->orderBy('AccountName')->andWhere(['BankTypeID' => $bankTypeId])->all();
        } else {
		    $model = BankAccounts::find()->orderBy('AccountName')->andWhere(['CountyID' => $countyId, 'BankTypeID' => $bankTypeId])->all();
        }
		
		echo '<option value="">Select...</option>';
		foreach ($model as $item) {
			echo "<option value='" . $item->BankAccountID . "'>" . $item->AccountName . "</option>";
		}
	}
}
