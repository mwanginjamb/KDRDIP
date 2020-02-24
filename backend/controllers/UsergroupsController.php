<?php

namespace backend\controllers;

use Yii;
use app\models\UserGroups;
use app\models\UserGroupRights;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * UsergroupsController implements the CRUD actions for UserGroups model.
 */
class UsergroupsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(59);

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
	 * Lists all UserGroups models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => UserGroups::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single UserGroups model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => UserGroupRights::find()->where(['UserGroupID'=> $id]),
			'pagination' => false,
	  	]);

		return $this->render('view', [
			'model' => $this->findModel($id),
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Creates a new UserGroups model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new UserGroups();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {			
			$params = Yii::$app->request->post();
			$lines = $params['UserGroupRights'];
			
			foreach ($lines as $key => $line)
			{
				$_line = new UserGroupRights();
				$_line->UserGroupID = $model->UserGroupID;
				$_line->PageID = $line['PageID'];
				$_line->View = $line['View'];
				$_line->Edit = $line['Edit'];
				$_line->Create = $line['Create'];
				$_line->Delete = $line['Delete'];
				$_line->save();
			}
			return $this->redirect(['view', 'id' => $model->UserGroupID]);
		}

		$sql = 'SELECT usergrouprights.*, PageName, pages.PageID FROM usergrouprights 
					RIGHT JOIN pages ON pages.PageID = usergrouprights.PageID
					AND UserGroupID = 0';
		$data = UserGroupRights::findBySql($sql)->asArray()->all();

		for ($x = 0; $x < count($data); $x++)
		{ 
			$_line = new UserGroupRights();
			$_line->PageID = $data[$x]['PageID'];
			$_line->PageName = $data[$x]['PageName'];
			$_line->View = $data[$x]['View'];
			$_line->Create = $data[$x]['Create'];
			$_line->Edit = $data[$x]['Edit'];
			$_line->Delete = $data[$x]['Delete'];
			$_line->UserGroupRightID = $data[$x]['UserGroupRightID'];
			$lines[$x] = $_line;
		}

		return $this->render('create', [
			'model' => $model, 
			'lines' => $lines,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing UserGroups model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			$lines = $params['UserGroupRights'];
			
			foreach ($lines as $key => $line)
			{
				//print_r($lines);exit;
				 
				if ($line['UserGroupRightID'] == '')
				{				
					$_line = new UserGroupRights();
					$_line->UserGroupID = $id;
					$_line->PageID = $line['PageID'];
					$_line->View = $line['View'];
					$_line->Edit = $line['Edit'];
					$_line->Create = $line['Create'];
					$_line->Delete = $line['Delete'];
					$_line->save();
				} else
				{
					$_line = UserGroupRights::findOne($line['UserGroupRightID']);
					$_line->View = $line['View'];
					$_line->Edit = $line['Edit'];
					$_line->Create = $line['Create'];
					$_line->Delete = $line['Delete'];
					if (!$_line->save()) {
						// print_r($_line->getErrors()); exit;
					}
				}
			}
			return $this->redirect(['view', 'id' => $model->UserGroupID]);
		}
		$sql = "SELECT usergrouprights.*, PageName, pages.PageID FROM usergrouprights 
					RIGHT JOIN pages ON pages.PageID = usergrouprights.PageID
					AND UserGroupID = $id";
		// echo $sql; exit;

		$data = UserGroupRights::findBySql($sql)->asArray()->all();
		/* print('<pre>');
		print_r($data); exit; */
		for ($x = 0; $x < count($data); $x++)
		{ 
			$_line = new UserGroupRights();
			$_line->PageID = $data[$x]['PageID'];
			$_line->PageName = $data[$x]['PageName'];
			$_line->View = $data[$x]['View'];
			$_line->Create = $data[$x]['Create'];
			$_line->Edit = $data[$x]['Edit'];
			$_line->Delete = $data[$x]['Delete'];
			$_line->UserGroupRightID = $data[$x]['UserGroupRightID'];
			$lines[$x] = $_line;
		}
		// print_r($lines); exit;

		return $this->render('update', [
			'model' => $model,
			'lines' => $lines,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing UserGroups model.
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
	 * Finds the UserGroups model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return UserGroups the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = UserGroups::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
