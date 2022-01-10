<?php

namespace backend\controllers;

use Yii;
use app\models\Users;
use app\models\UsersSearch;
use app\models\UserGroups;
use app\models\UserStatus;
use app\models\UserTypes;
use app\models\Facilities;
use app\models\Wards;
use app\models\Constituency;
use app\models\Counties;
use app\models\SubCounties;
use app\models\UserProgrammes;
use common\models\User;
use common\models\ChangePassword;
use common\models\ResetPassword;
use app\models\Dhis;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		Yii::$app->params['PageID'] = 5;
		Yii::$app->params['page'] = 'security';

		$Rights = Yii::$app->params['rights'];
		$Rights = $Rights[Yii::$app->params['PageID']];

		$allowed[] = 'profile';
		if ($Rights['View']) {
			$allowed[] = 'index';
			$allowed[] = 'view';
		}
		if ($Rights['Create']) {
			$allowed[] = 'create';
			$allowed[] = 'usertype';
			$allowed[] = 'constituency';
			$allowed[] = 'wards';
			$allowed[] = 'subcounties';
			$allowed[] = 'facilities';
		}
		if ($Rights['Update']) {
			$allowed[] = 'update'; $allowed[] = 'constituency';
			$allowed[] = 'wards'; $allowed[] = 'subcounties';
			$allowed[] = 'facilities';
		}
		if ($Rights['Delete']) {
			$allowed[] = 'delete';
		}

		return [
			'access' => [
					'class' => AccessControl::className(),
					'rules' => [
						[
							'actions' => $allowed,
							'allow' => true,
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
		$searchModel = new UsersSearch();
		$query = Users::find()->joinWith('counties')->joinWith('usergroups')->joinwith('subcounties');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);	

		if ($searchModel->load(Yii::$app->request->post()) && $searchModel->validate()) {
			$SearchFor = Yii::$app->request->post()['UsersSearch']['SearchFor'];
			// Apply Filter
			$query->andFilterWhere(['like', 'FirstName', $SearchFor])
					->orFilterWhere(['like', 'LastName', $SearchFor])
					->orFilterWhere(['like', 'Mobile', $SearchFor])
					->orFilterWhere(['like', 'subcounties.SubCountyName', $SearchFor])
					->orFilterWhere(['like', 'counties.CountyName', $SearchFor])
					->orFilterWhere(['like', 'usergroups.UserGroupName', $SearchFor]);
		}

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
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
		$resetpassword = new ResetPassword();
		$dhisModel = new Dhis();
		$dhisModel->UserID = $id;
		$resetpassword->Email = Yii::$app->user->identity->Email;
		$message = '';
		$error = '';
		$error1 = '';
		$hide1 = true;
		$hide2 = true;
		if (Yii::$app->request->post()) {
			if (isset(Yii::$app->request->post()['ResetPassword'])) {
				$hide1 = false;
				$params = Yii::$app->request->post()['ResetPassword'];
				if ($params['newpassword'] != $params['confirmpassword']) {
					$error = 'The New and Confirm Passwords do not match';
					$resetpassword->load(Yii::$app->request->post());
				} else {
					$users = $this->findModel($id);
					$users->PasswordHash = Yii::$app->security->generatePasswordHash($params['newpassword']);
					if ($users->save()) {
						$message = 'Password changed Successfully';
						Yii::$app->session->setFlash('success', 'Password Changed Successfully');
						return $this->redirect(['view', 'id' => $id]);
					} else {
						$error = 'Failed to change password';
						$resetpassword->load(Yii::$app->request->post());
					}
				}
			} elseif (isset(Yii::$app->request->post()['Dhis'])) {
				$hide2 = false;
				if ($dhisModel->load(Yii::$app->request->post())) {
					$params = Yii::$app->request->post()['Dhis'];

					if (!$this->validateDhisCredentials($params['DhisUserName'], $params['DhisPassword'])) {
						$dhisModel->addError('DhisPassword', 'Invalid DHIS Credentials');
						$error1 = 'Invalid DHIS Credentials';
					} else {
						$model = Users::findOne($id);
						if ($model) {
							$key = Yii::$app->params['key'];
							$encryptedPassword = Yii::$app->security->encryptByPassword($params['DhisPassword'], $key);
							$model->DhisUserName = $params['DhisUserName'];
							$model->DhisPassword = utf8_encode($encryptedPassword);
							if ($model->save()) {
								$message = 'DHIS Credentials Saved Successfully';
							} else {
								print_r($model->getErrors()); exit;
								$error1 = 'Failed to save Credentials';
							}
						} else {
							$error1 = 'User not Found';
						}
					}
				}
			}
		}
		$sql =	"SELECT userprogrammes.*, programmes.ProgrammeID as PID, ProgrammeName FROM userprogrammes
					RIGHT JOIN programmes ON programmes.ProgrammeID = userprogrammes.ProgrammeID
					AND UserID = $id";

		$userProgrammes = UserProgrammes::findBySql($sql)->asArray()->all();

		return $this->render('view', [
			'model' => $this->findModel($id),
			'message' => $message,
			'error' => $error,
			'error1' => $error1,
			'resetpassword' => $resetpassword,
			'userProgrammes' => $userProgrammes,
			'dhisModel' => $dhisModel,
			'hide1' => $hide1,
			'hide2' => $hide2
		]);
	}

	private static function validateDhisCredentials($username, $password)
	{
		$url = Yii::$app->params['DHIS_URL'];
		// Submit Data to DHIS
		 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		// curl_setopt( $ch, CURLOPT_HTTPHEADER, array("Content-Type:application/csv, Authorization: $auth"));
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// curl_setopt($ch, CURLOPT_POSTFIELDS, []);
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if ($httpcode == 200) {
			return true;
		} else {
			return false;
		}
	}

	public function actionUsertype()
	{
		if (Yii::$app->user->identity->UserTypeID == 1) {
			$model = new Users();
			$usertypes = ArrayHelper::map(Usertypes::find()->all(), 'UserTypeID', 'UserTypeName');
			return $this->render('_usertype', [
				'model' => $model, 'usertypes' => $usertypes,
			]);
		} else {
			return $this->redirect(['create', 'UserTypeID' => Yii::$app->user->identity->UserTypeID]);
		}
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
		$model->UserStatusID = 1;
		$model->CountryID = 1;

		if (Yii::$app->request->post() && isset(Yii::$app->request->post()['usertype'])) {
			$model->UserTypeID = Yii::$app->request->post()['Users']['UserTypeID'];
		} else {
			$model->UserTypeID = Yii::$app->user->identity->UserTypeID;
			if (Yii::$app->user->identity->UserTypeID == 2 || Yii::$app->user->identity->UserTypeID == 3) {
				$model->FacilityID = Yii::$app->user->identity->FacilityID;
			}
		}

		if (Yii::$app->request->post() && !isset(Yii::$app->request->post()['usertype'])) {
			$params = Yii::$app->request->post();
			$password = $params['Users']['password'];
			$model->AuthKey = \Yii::$app->security->generateRandomString();
			$model->PasswordHash = \Yii::$app->security->generatePasswordHash($password);
		}

		if (Yii::$app->request->post() && !isset(Yii::$app->request->post()['usertype'])) {
			$params = Yii::$app->request->post();
			if (isset($params['UserTypeID'])) {

			} else {
				$params['UserTypeID'] = Yii::$app->user->identity->UserTypeID;
				$UserTypeID = Yii::$app->user->identity->UserTypeID;

				if ($UserTypeID == 2 || $UserTypeID == 3) {
					$model->UserTypeID = $UserTypeID;
					if ($UserTypeID == 2) {
						$params['FacilityID'] = Yii::$app->user->identity->FacilityID;
					}
				}
			}
			$UserTypeID = Yii::$app->request->post()['Users']['UserTypeID'];
			$params = Yii::$app->request->post();
			
			if ($UserTypeID == 2 || $UserTypeID == 3 || $UserTypeID == 4) {
				$params['Users']['UserGroupID'] = 0;
			}
			if ($model->load($params) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->UserID]);
			}else{
			    print '<pre>';
			    print_r($model->errors);
			    exit;
            }
		}
		$facilities = [];
		if ($model->UserTypeID == 2) {
			$facilities = [];
		}
			
		$userstatus = ArrayHelper::map(UserStatus::find()->all(), 'UserStatusID', 'UserStatusName');
		$usergroup = ArrayHelper::map(UserGroups::find()
								->where(['UserTypeID'=> $model->UserTypeID])->all(), 'UserGroupID', 'UserGroupName');
		$usertypes = ArrayHelper::map(Usertypes::find()->all(), 'UserTypeID', 'UserTypeName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$subcounties = [];
		$userID = isset($model->UserID) ? $model->UserID : 0;

		$sql =	"SELECT userprogrammes.*, programmes.ProgrammeID as PID, ProgrammeName FROM userprogrammes
					RIGHT JOIN programmes ON programmes.ProgrammeID = userprogrammes.ProgrammeID
					AND UserID = $userID";

		$_userProgrammes = UserProgrammes::findBySql($sql)->asArray()->all();

		foreach ($_userProgrammes as $x => $programme) {
			$userProgrammes[$x] = new UserProgrammes();
			$userProgrammes[$x]->UserProgrammeID = $programme['UserProgrammeID'];
			$userProgrammes[$x]->ProgrammeID		= $programme['ProgrammeID'];
			$userProgrammes[$x]->UserID			= $programme['UserID'];
			$userProgrammes[$x]->Active			= $programme['Active'];
			$userProgrammes[$x]->ProgrammeName 	= $programme['ProgrammeName'];
			$userProgrammes[$x]->PID 				= $programme['PID'];
		}

		return $this->render('create', [
			'model' => $model, 'facilities' => $facilities,
			'userstatus' => $userstatus, 'isprofile' => false,
			'usergroup' => $usergroup, 'usertypes' => $usertypes,
			'counties' => $counties, 'subcounties' => $subcounties,
			'userProgrammes' => $userProgrammes,
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

			$params = Yii::$app->request->post();
			$lines = $params['UserProgrammes'];
			// print_r($lines); exit;
			foreach ($lines as $key => $line) {
				if ($line['UserProgrammeID'] == '') {
					$_line = new UserProgrammes();
				} else {
					$_line = UserProgrammes::findOne($line['UserProgrammeID']);
				}
				$_line->ProgrammeID = $line['PID'];
				$_line->Active = $line['Active'];
				$_line->UserID = $id;
				$_line->save();
			}
			return $this->redirect(['view', 'id' => $model->UserID]);
		}
		$facilities = [];
		if ($model->UserTypeID == 2) {
			// $facilities = ArrayHelper::map(Facilities::find()->all(), 'FacilityID', 'FacilityName');
			$facilities = ArrayHelper::map(Facilities::find()->where(['SubCountyID' => $model->SubCountyID])->all(), 'FacilityID', 'FacilityName');
		}

		$userstatus = ArrayHelper::map(UserStatus::find()->all(), 'UserStatusID', 'UserStatusName');
		$usergroup = ArrayHelper::map(UserGroups::find()->where(['UserTypeID'=> $model->UserTypeID])->all(), 'UserGroupID', 'UserGroupName');
		$usertypes = ArrayHelper::map(Usertypes::find()->all(), 'UserTypeID', 'UserTypeName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$subcounties = ArrayHelper::map(SubCounties::find()->where(['CountyID' => $model->CountyID])->all(), 'SubCountyID', 'SubCountyName');

		$userID = $model->UserID;

		$sql =	"SELECT userprogrammes.*, programmes.ProgrammeID as PID, ProgrammeName FROM userprogrammes
					RIGHT JOIN programmes ON programmes.ProgrammeID = userprogrammes.ProgrammeID
					AND UserID = $userID";

		$_userProgrammes = UserProgrammes::findBySql($sql)->asArray()->all();

		foreach ($_userProgrammes as $x => $programme) {
			$userProgrammes[$x] = new UserProgrammes();
			$userProgrammes[$x]->UserProgrammeID = $programme['UserProgrammeID'];
         $userProgrammes[$x]->ProgrammeID		= $programme['ProgrammeID'];
         $userProgrammes[$x]->UserID			= $programme['UserID'];
			$userProgrammes[$x]->Active			= $programme['Active'];
			$userProgrammes[$x]->ProgrammeName 	= $programme['ProgrammeName'];
			$userProgrammes[$x]->PID 				= $programme['PID'];
		}

		return $this->render('update', [
			'model' => $model, 'facilities' => $facilities,
			'userstatus' => $userstatus, 'isprofile' => false,
			'usergroup' => $usergroup, 'usertypes' => $usertypes,
			'counties' => $counties, 'subcounties' => $subcounties,
			'userProgrammes' => $userProgrammes,
		]);
		/* return $this->render('update', [
			'model' => $model,
		]); */
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
	
	public static function displayGroup($DisplayGroup = [], $Rights)
	{
		$display = false;
		foreach ($DisplayGroup as $key => $value) {
			if ($Rights[$value]['View']) {
				return true;
			}
		}
		return $display;
	}

	public function actionProfile()
	{
		$id = Yii::$app->user->identity->UserID;
		$changepassword = new ChangePassword();
		$changepassword->username = Yii::$app->user->identity->Email;
		$message = '';
		$error = '';
		if (Yii::$app->request->post()) {
			$params = Yii::$app->request->post()['ChangePassword'];
			if ($params['newpassword'] != $params['confirmpassword']) {
				$error = 'The New and Confirm Passwords do not match';
				$changepassword->load(Yii::$app->request->post());
			} else {
				$user = User::findByUsername(Yii::$app->user->identity->Email);
				if (!$user || !$user->validatePassword($params['oldpassword'])) {
					$error = 'Invalid Password';
					$changepassword->load(Yii::$app->request->post());
				} else {
					$users = $this->findModel($id);
					$users->PasswordHash = Yii::$app->security->generatePasswordHash($params['newpassword']);
					if ($users->save()) {
						$message = 'Password changed Successfully';
						Yii::$app->session->setFlash('success', 'Password Changed Successfully');
						return $this->redirect(['profile']);
					} else {
						$error = 'Failed to change password';
						$changepassword->load(Yii::$app->request->post());
					}
				}
			}
		}
		$model = Users::find()->joinWith('facilities')
									->joinWith('userstatus')
									->joinWith('usergroups')
									->joinWith('usertypes')
									->where(['UserID' => $id])
									->one();
	
		return $this->render('profile', [
													'model' => $model,
													'changepassword' => $changepassword,
													'message' => $message, 'error' => $error
												]);
	}

	public function actionSubcounties($SubCountyID)
	{
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$CountyID = $parents[0];
				$out = SubCounties::find()->select('SubCountyID as id, SubCountyName as name')
												->where(['CountyID' => $CountyID])->asArray()->all();
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}

	public function actionFacilities($FacilityID)
	{
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$SubCountyID = $parents[0];
				$out = Facilities::find()->select('FacilityID as id, FacilityName as name')
												->where(['SubCountyID' => $SubCountyID])
												->orderBy('FacilityName')
												->asArray()->all();
				return Json::encode(['output'=>$out, 'selected'=>'']);
				// return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}

	public function actionConstituency($ConstituencyID) 
	{
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$CountyID = $parents[0];
				$out = Constituency::find()->select('ConstituencyID as id, ConstituencyName as name')->where(['CountyID' => $CountyID])->asArray()->all(); 
				//print_r($out); exit;
				//$out = [['1'=>'Name1', '2' => 'Name 2']];
				// the getSubCatList function will query the database based on the
				// cat_id and return an array like below:
				// [
				//    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
				//    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
				// ]
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}
	
	public function actionWards($WardID)
	{
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$ids = $_POST['depdrop_parents'];
			//print_r( $ids); exit;
			$CountyID = empty($ids[0]) ? null : $ids[0];
			$ConstituencyID = empty($ids[1]) ? null : $ids[1];
			if (($ConstituencyID!='Loading ...') && ($ConstituencyID != null)) {
				$data = Wards::find()->select('WardID as id, WardName as name')->where(['ConstituencyID' => $ConstituencyID])->asArray()->all(); 
				
				$data = ['out' => $data, 'selected' => $WardID];
				/**
				 * the getProdList function will query the database based on the
				 * cat_id and sub_cat_id and return an array like below:
				 *  [
				 *      'out'=>[
				 *          ['id'=>'<prod-id-1>', 'name'=>'<prod-name1>'],
				 *          ['id'=>'<prod_id_2>', 'name'=>'<prod-name2>']
				 *       ],
				 *       'selected'=>'<prod-id-1>'
				 *  ]
				 */
			   
				echo Json::encode(['output'=>$data['out'], 'selected'=>$data['selected']]);
			   return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}

	public function actionGetField($UserTypeID)
	{
		echo $form->field($model, 'TransporterID')->dropDownList($transporters,['prompt'=>'Select...', 'disabled' => $isprofile]);
	}
}
