<?php

namespace backend\controllers;

use Yii;
use app\models\Users;
use app\models\UserGroups;
use app\models\UserStatus;
use app\models\UserTypes;
use app\models\Communities;
use app\models\Counties;
use app\models\MessageTemplates;
use app\models\UserGroupRights;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(60);

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
	 * Lists all Users models.
	 * @return mixed
	 */
	public function actionIndex()
	{

		$dataProvider = new ActiveDataProvider([
			'query' => $dataProvider = Users::find()->joinWith('userstatus')->joinWith('usergroups'),
		]);
		
		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Users model.
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
	 * Creates a new Users model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Users();
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		
		if (Yii::$app->request->post())
		{
			// $params = Yii::$app->request->post();
			$password =  Yii::$app->request->post()['Users']['Password'];
			$model->AuthKey = \Yii::$app->security->generateRandomString();
			$model->PasswordHash = \Yii::$app->security->generatePasswordHash($password);
		}

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			// return $this->redirect(['view', 'id' => $model->UserID]);
			return $this->redirect(['index']);
		}

		$usergroups = ArrayHelper::map(UserGroups::find()->all(), 'UserGroupID', 'UserGroupName');
		$userstatus = ArrayHelper::map(UserStatus::find()->all(), 'UserStatusID', 'UserStatusName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$communities = ArrayHelper::map(Communities::find()->all(), 'CommunityID', 'CommunityName');
		$userTypes = ArrayHelper::map(UserTypes::find()->all(), 'UserTypeID', 'UserTypeName');

		return $this->render('create', [
			'model' => $model,
			'usergroups' => $usergroups,
			'userstatus' => $userstatus,
			'counties' => $counties,
			'communities' => $communities,
			'userTypes' => $userTypes,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing Users model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			// return $this->redirect(['view', 'id' => $model->UserID]);
			return $this->redirect(['index']);
		}

		$usergroups = ArrayHelper::map(UserGroups::find()->all(), 'UserGroupID', 'UserGroupName');
		$userstatus = ArrayHelper::map(UserStatus::find()->all(), 'UserStatusID', 'UserStatusName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$communities = ArrayHelper::map(Communities::find()->all(), 'CommunityID', 'CommunityName');
		$userTypes = ArrayHelper::map(UserTypes::find()->all(), 'UserTypeID', 'UserTypeName');

		return $this->render('update', [
			'model' => $model,
			'usergroups' => $usergroups,
			'userstatus' => $userstatus,
			'counties' => $counties,
			'communities' => $communities,
			'userTypes' => $userTypes,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing Users model.
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
	 * Finds the Users model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Users the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Users::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public static function sendEmailNotification($FormID)
	{
		$Code = '';
		
		switch ($FormID) {
			case 26: // Quotations Approval
				$Code = '001';
				break;
			case 13: // Purchases Approval
				$Code = '002';
				break;
			case 12: // Requisition Approval
				$Code = '003';
				break;
			case 14: // Stock Take Approval
				$Code = '004';
				break;
			case 29: // Quotation Review
				$Code = '005';
				break;
			case 28: // Purchase Review
				$Code = '006';
				break;
			case 27: // Requisition Review
				$Code = '007';
				break;
			case 30: // Stock Take Review
				$Code = '008';
				break;
		}
		
		$template = MessageTemplates::findone(['Code' => $Code]);
		
		$sql = "SELECT users.UserID, users.FirstName, users.LastName, users.Email FROM usergrouprights 
				JOIN users ON users.UserGroupID = usergrouprights.UserGroupID
				WHERE FormID = $FormID AND Edit=1";
		
		$users = UserGroupRights::findBySql($sql)->asArray()->all();
		$EmailArray = [];
		foreach ($users as $key => $user) {
			$EmailArray[] = ['Email' => $user['Email'], 'Name'=> $user['FirstName'] . ' ' . $user['LastName']];
		}
		//print_r($EmailArray);
		if (!empty($template))
		{
			$subject = $template->Subject;
			$message = $template->Message;
			
			//echo $message; exit;
		}
		if (count($EmailArray)!=0)
		{
			$sent = SendMail($EmailArray, $subject ,$message, null);			
			if ($sent==1)
			{
				return "Saved Details Successfully";
			} else
			{
				return "Failed to send Mail";
			}
		} else
		{
			return "No Email address";
		}		
	}
	
	public function actionTestemail()
	{
		$sent = SendMail('ngugi.joseph@gmail.com','Test Email' ,'Test Email', null);			
		if ($sent==1)
		{
			return "Saved Details Successfully";
		} else
		{
			return "Failed to send Mail";
		}
	}
}
