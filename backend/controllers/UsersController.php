<?php

namespace backend\controllers;

use app\models\AuthAssignment;
use app\models\AuthItem;
use Yii;
use app\models\Users;
use app\models\UserGroups;
use app\models\UserStatus;
use app\models\UserTypes;
use app\models\Communities;
use app\models\Counties;
use app\models\MessageTemplates;
use app\models\UserGroupRights;
use app\models\PermissionForm;
use app\models\UserGroupMembers;
use app\models\ChangePassword;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

include_once 'includes/mailsender.php';

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
            'pagination' => false,
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
		$permissionForm = new PermissionForm();
		$permissionForm->UserID = $id;
		$activeTab = 1;

		if (Yii::$app->request->post()) {
			$activeTab = 2;
		}

		if ($permissionForm->load(Yii::$app->request->post()) && $permissionForm->validate()) {
			$params = Yii::$app->request->post();
			$userGroupID = $params['PermissionForm']['UserGroupID'];
			$permission = UserGroupMembers::findOne(['UserGroupID' => $userGroupID, 'UserID' => $id]);

			if (!$permission) {
				$perm = new UserGroupMembers();
				$perm->UserGroupID = $userGroupID;
				$perm->UserID = $id;
				$perm->CreatedBy = Yii::$app->user->identity->UserID;
				$perm->save();
			}
			$activeTab = 2;
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $dataProvider = UserGroupMembers::find()->where(['UserID' => $id]),
		]);
		
		$userGroups = ArrayHelper::map(UserGroups::find()->all(), 'UserGroupID', 'UserGroupName');

		return $this->render('view', [
			'model' => $this->findModel($id),
			'dataProvider' => $dataProvider,
			'permissionForm' => $permissionForm,
			'userGroups' => $userGroups,
			'activeTab' => $activeTab,
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
		
		if (Yii::$app->request->post()) {
			// $params = Yii::$app->request->post();
			$password =  Yii::$app->request->post()['Users']['Password'];
			$model->AuthKey = \Yii::$app->security->generateRandomString();
			$model->PasswordHash = \Yii::$app->security->generatePasswordHash($password);
		}

		if ($model->load(Yii::$app->request->post()) ) {
			// return $this->redirect(['view', 'id' => $model->UserID]);
            if($model->save()) {
                if($model->userRole)
                {
                    $roleModel = new AuthAssignment();
                    $roleModel->user_id = $model->UserID;
                    $roleModel->item_name = $model->userRole;
                    $roleModel->save();
                }
            }
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
            'roles' => ArrayHelper::map(AuthItem::findAll(['type' => 1]),'name' , 'name')
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

		if ($model->load(Yii::$app->request->post()) ) {
			// return $this->redirect(['view', 'id' => $model->UserID]);


            if($model->save()) {
                if($model->userRole)
                {
                    $roleModel = new AuthAssignment();
                    //Check if user already has a role and update
                    $Role = AuthAssignment::findOne(['user_id' => $model->UserID]);
                    if($Role){
                        $Role->user_id = $model->UserID;
                        $Role->item_name = $model->userRole;
                        $Role->save();
                    }else{
                        $roleModel->user_id = $model->UserID;
                        $roleModel->item_name = $model->userRole;
                        if(!$roleModel->save()){
                            VarDumper::dumpAsString($roleModel->error); exit;
                        }
                    }

                }
            }

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
            'roles' =>  ArrayHelper::map(AuthItem::findAll(['type' => 1]),'name' , 'name')
		]);
	}

	public function actionChangePassword($id)
	{
		$user = Users::findOne($id);
		$model = new ChangePassword();
		$model->UserID = $id;
		$model->FullName = $user->FirstName . ' ' . $user->LastName;

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$profile = Users::findOne($id);
			$profile->PasswordHash = Yii::$app->security->generatePasswordHash($model->Password);
			$profile->AuthKey = Yii::$app->security->generateRandomString();
			$profile->Password = '0';
			$profile->Password = $model->Password;
			$profile->ConfirmPassword = $model->ConfirmPassword;
			if ($profile->save()) {
				Yii::$app->session->setFlash('success', 'Password changed successfully.');
				return $this->redirect(['index']);
			} else {
				// print_r($profile->getErrors()); exit;
				Yii::$app->session->setFlash('error', 'Failed to change password.');
			}
		}

		return $this->render('change-password', [
			'model' => $model,
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

	public static function sendEmailNotification($code, $userId=0)
	{
		$template = MessageTemplates::findone(['Code' => $code]);
		if (!$template) {
			return 'template not found';
		}
		
		$user = Users::findOne($userId);
		if (!$user) {
			return 'User not found';
		}

		$EmailArray = [];
		if ($user) {
			$EmailArray[] = ['Email' => $user['Email'], 'Name'=> $user['FirstName'] . ' ' . $user['LastName']];
		}

		if (!empty($template)) {
			$subject = $template->Subject;
			$message = $template->Message;
		}
		
		if (count($EmailArray)!=0) {
			$sent = SendMail($EmailArray, $subject, $message, null);
			if ($sent==1) {
				Yii::$app->session->setFlash('success', 'Saved Details Successfully');
				return 'Saved Details Successfully';
			} else {
				Yii::$app->session->setFlash('error', 'Failed to send Mail');
				return 'Failed to send Mail';
			}
		} else {
			Yii::$app->session->setFlash('error', 'Failed to send Mail - No Email address');
			return 'No Email address';
		}
	}
	
	public function actionTestemail()
	{
		$EmailArray[] = ['Email' => 'ngugi.joseph@gmail.com', 'Name'=> 'Joseph Ngugi'];
		$sent = SendMail($EmailArray, 'Test Email', 'Test Email', null);
		if ($sent==1) {
			return 'Saved Details Successfully';
		} else {
			return 'Failed to send Mail';
		}
	}
}
