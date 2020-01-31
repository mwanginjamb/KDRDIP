<?php

namespace backend\controllers;

use Yii;
use app\models\UserGroupRights;
use app\models\UserGroupMembers;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class RightsController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
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
						'actions' => ['permissions'],
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
	 * Displays a single Company model.
	 * @param integer $id
	 * @return mixed
	 */
	public static function Permissions($id=0)
	{

		if (!Yii::$app->user->isGuest) {
			$UserID = Yii::$app->user->identity->UserID;
			if ($id == 0) {
				$where = "UserID = $UserID";
			} else {
				$where = "UserID = $UserID  AND PageID = $id";
			}
			
			$sql = "SELECT DISTINCT PageID, `Create`, `Edit`, `View`, `Delete` FROM usergrouprights
						JOIN usergroupmembers ON usergroupmembers.UserGroupID = usergrouprights.UserGroupID
						WHERE $where";
			// echo $sql; exit;
			if ($id == 0) {
				$rights =  UserGroupRights::findBySql($sql)->asArray()->all();
				// print_r($rights); exit;
			} else {
				$rights =  UserGroupRights::findBySql($sql)->asArray()->one();
				if (!empty($rights)) {
					foreach($rights as $key => $right) {
						if ($right != 1) {
							unset($rights[$key]);
						}
					}
				}
			}			 
		} else {
			$rights = [];
		}
		// print_r($rights); exit;
		return (object) $rights;
	}

	public static function AllPermissions()
	{

	}
}
