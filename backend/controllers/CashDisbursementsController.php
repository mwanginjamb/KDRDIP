<?php

namespace backend\controllers;

use Yii;
use app\models\CashDisbursements;
use app\models\CashBook;
use app\models\Documents;
use app\models\ApprovalNotes;
use app\models\BankAccounts;
use app\models\Counties;
use app\models\Projects;
use app\models\ProjectDisbursement;
use app\models\Communities;
use app\models\Organizations;
use app\models\DisbursementTypes;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use backend\controllers\RightsController;
use yii\web\UploadedFile;

/**
 * CashDisbursementsController implements the CRUD actions for CashDisbursements model.
 */
class CashDisbursementsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(132);

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
	 * Lists all CashDisbursements models.
	 * @return mixed
	 */
	public function actionIndex()
	{

        $query = CashDisbursements::find();
        $countQuery = clone $query;
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
            'pagination' =>  [
                'pageSize' => $countQuery->count()
            ],
            'totalCount' => $countQuery->count(),
            'sort' => [
                'defaultOrder' => [
                    'CashDisbursementID' => SORT_DESC
                ],
            ],
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,

		]);
	}

	/**
	 * Displays a single CashDisbursements model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
	    $model = CashDisbursements::find()->where(['CashDisbursementID' => $id])->one();
		$approvalNotesProvider = new ActiveDataProvider([
			'query' => ApprovalNotes::find()->where(['ApprovalID'=> $id, 'ApprovalTypeID' => 10]),
		]);

		$documentsProvider = new ActiveDataProvider([
			'query' => Documents::find()->andWhere(['RefNumber' => $id, 'DocumentCategoryID' => 7]),
		]);

		return $this->render('view', [
			'model' => $model,
			'rights' => $this->rights,
			'approvalNotesProvider' => $approvalNotesProvider,
			'documentsProvider' => $documentsProvider,
            'document' => $model->read()
		]);
	}

	/**
	 * Creates a new CashDisbursements model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new CashDisbursements();
		$model->DisbursementDate = date('Y-m-d');
		$model->CreatedBy = Yii::$app->user->identity->UserID;
        $model->DisbursementTypeID = 1;

		if ($model->load(Yii::$app->request->post()) ) {
            
			$model->imageFile = UploadedFile::getInstanceByName('attachment');
			$model->upload();
			if ($model->save()) {
				if ($model->imageFile) {
					$document = new Documents();
					$document->Description = 'Disbursement';
					$document->DocumentTypeID = 5;
					$document->DocumentCategoryID = 7;
					$document->RefNumber = $model->CashDisbursementID;
					//$document->Image = $model->formatImage();
					//$document->imageFile = $model->imageFile;
					$document->CreatedBy = Yii::$app->user->identity->UserID;
					if (!$document->save()) {
						// print_r($document->getErrors()); exit;
					}
				}
				return $this->redirect(['view', 'id' => $model->CashDisbursementID]);
			}
		}

        if (Yii::$app->request->post()) {
            // print('<pre>');
            // print_r($model); exit;
        }

        if ($model->DisbursementTypeID == 3) {
            $sourceBankTypeId = 1;
            $destinationBankTypeId = 2;
        } elseif ($model->DisbursementTypeID == 2)  {
            $sourceBankTypeId = 2;
            $destinationBankTypeId = 3;
        } elseif ($model->DisbursementTypeID == 1)  {
            $sourceBankTypeId = 2;
            $destinationBankTypeId = 4;
        }        

		$sourceAccounts = self::getBankAccounts($model->CountyID, $sourceBankTypeId);
		$destinationAccounts = self::getBankAccounts($model->CountyID, $destinationBankTypeId);

/*         if (Yii::$app->request->post()) {
            print('<pre>');
            print_r($sourceAccounts); exit;
        } */

		$projects = ArrayHelper::map(Projects::find()->andWhere(['CountyID' => $model->CountyID])->all(), 'ProjectID', 'ProjectName');
        $organizations = ArrayHelper::map(Organizations::find()->andWhere(['CountyID' => $model->CountyID])->all(), 'OrganizationID', 'OrganizationName');
		$communities = ArrayHelper::map(Communities::find()->andWhere(['CountyID' => $model->CountyID])->all(), 'CommunityID', 'CommunityName');
		$counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
		$disbursementTypes = ArrayHelper::map(DisbursementTypes::find()->all(), 'DisbursementTypeID', 'DisbursementTypeName');        
		$projectDisbursements = ArrayHelper::map(ProjectDisbursement::find()->andWhere(['ProjectID' => $model->ProjectID])->all(), 'ProjectDisbursementID', 'Year');;

		$documentsProvider = new ActiveDataProvider([
			'query' => Documents::find()->andWhere(['RefNumber' => 0, 'DocumentCategoryID' => 7]),
		]);

		return $this->render('create', [
			'model' => $model,
			'sourceAccounts' => $sourceAccounts,
            'destinationAccounts' => $destinationAccounts,
			'projects' => $projects,
			'counties' => $counties,
			'communities' => $communities,
			'rights' => $this->rights,
			'projectDisbursements' => $projectDisbursements,
			'documentsProvider' => $documentsProvider,
            'organizations' => $organizations,
            'disbursementTypes' => $disbursementTypes,
		]);
	}

	/**
	 * Updates an existing CashDisbursements model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) ) {
			$model->imageFile = UploadedFile::getInstanceByName( 'attachment');
			$model->upload();
			if ($model->save()) {
				if ($model->imageFile) {
					$document = new Documents();
					$document->Description = 'Disbursement';
					$document->DocumentTypeID = 5;
					$document->DocumentCategoryID = 7;
					$document->RefNumber = $model->CashDisbursementID;
					$document->Image = $model->formatImage();
					$document->imageFile = $model->imageFile;
					$document->CreatedBy = Yii::$app->user->identity->UserID;
					if (!$document->save()) {
						// print_r($document->getErrors()); exit;
					}
				}
				return $this->redirect(['view', 'id' => $model->CashDisbursementID]);
			}
		}

        
        if ($model->DisbursementTypeID == 3) {
            $sourceBankTypeId = 1;
            $destinationBankTypeId = 2;
        } elseif ($model->DisbursementTypeID == 2)  {
            $sourceBankTypeId = 2;
            $destinationBankTypeId = 3;
        } elseif ($model->DisbursementTypeID == 1)  {
            $sourceBankTypeId = 2;
            $destinationBankTypeId = 4;
        }        

		$sourceAccounts = self::getBankAccounts($model->CountyID, $sourceBankTypeId);
		$destinationAccounts = self::getBankAccounts($model->CountyID, $destinationBankTypeId);
		$projects = ArrayHelper::map(Projects::find()->andWhere(['CountyID' => $model->CountyID])->all(), 'ProjectID', 'ProjectName');
		$organizations = ArrayHelper::map(Organizations::find()->andWhere(['CountyID' => $model->CountyID])->all(), 'OrganizationID', 'OrganizationName');      

		$communities = ArrayHelper::map(Communities::find()->andWhere(['CountyID' => $model->CountyID])->all(), 'CommunityID', 'CommunityName');
		$counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
        $disbursementTypes = ArrayHelper::map(DisbursementTypes::find()->all(), 'DisbursementTypeID', 'DisbursementTypeName');        
		$projectDisbursements = ArrayHelper::map(ProjectDisbursement::find()->andWhere(['ProjectID' => $model->ProjectID])->all(), 'ProjectDisbursementID', 'Year');;

		$documentsProvider = new ActiveDataProvider([
			'query' => Documents::find()->andWhere(['RefNumber' => $id, 'DocumentCategoryID' => 7]),
		]);

		return $this->render('update', [
			'model' => $model,
			'sourceAccounts' => $sourceAccounts,
            'destinationAccounts' => $destinationAccounts,
			'projects' => $projects,
			'counties' => $counties,
			'communities' => $communities,
			'rights' => $this->rights,
			'projectDisbursements' => $projectDisbursements,
			'documentsProvider' => $documentsProvider,
            'organizations' => $organizations,
            'disbursementTypes' => $disbursementTypes,
		]);
	}

    public static function getBankAccounts($countyId, $bankTypeId) {
        if ($bankTypeId == 1) {
            return ArrayHelper::map(BankAccounts::find()->orderBy('AccountName')->andWhere(['BankTypeID' => $bankTypeId])->all(), 'BankAccountID', 'AccountName');
        } else {
		    return ArrayHelper::map(BankAccounts::find()->orderBy('AccountName')->andWhere(['CountyID' => $countyId, 'BankTypeID' => $bankTypeId])->all(), 'BankAccountID', 'AccountName');
        }
    }

	/**
	 * Deletes an existing CashDisbursements model.
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

	public function actionSubmit($id)
	{
		//$model = $this->findModel($id);
        $model = CashDisbursements::find()->where(['CashDisbursementID' => $id])->one();
		$model->ApprovalStatusID = 1;
		if ($model->save(false)) {
            Yii::$app->session->setFlash('success','Document sent for approval successfully.');
			// $result = UsersController::sendEmailNotification(29);
			return $this->redirect(['view', 'id' => $model->CashDisbursementID]);
		} else {
			//print_r($model->getErrors()); exit;
            Yii::$app->session->setFlash('error','Could not send this document for approval. ');
            return $this->redirect(['index']);
		}
	}

	/**
	 * Finds the CashDisbursements model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CashDisbursements the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = CashDisbursements::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}


	//Data Dependent Drop Down Functions

    public function actionProjects($countyID= '')
    {
        if(!empty($countyID))
        {
            $data = Projects::find()->where(['CountyID' => $countyID])->orderBy(['ProjectName' => SORT_ASC])->all();
        }else
        {
            $data = Projects::find()->orderBy(['ProjectName' => SORT_ASC])->all();
        }

        if(count($data))
        {
            foreach($data  as $k  => $record )
            {
                if(empty($record['ProjectID']) || empty($record['ProjectName'])){
                    continue;
                }
                ob_start();
                echo "<option value=".$record['ProjectID'].">".$record['ProjectName']."</option>";
                $listData = ob_get_contents();

            }
            ob_end_clean();
            echo $listData;
        }else{
            echo "<option value=''>No data Available</option>";
        }
        return true;


    }


    public function actionDestinationAccounts($DisbursementType = '', $CountyID='')
    {
        if(!empty($DisbursementType) && !empty($CountyID))
        {
            $data = BankAccounts::find()->where(['BankTypeID' => $DisbursementType, 'CountyID' => $CountyID])->orderBy(['AccountName' => SORT_ASC])->all();
        }else
        {
            $data = BankAccounts::find()->orderBy(['AccountName' => SORT_ASC])->all();
        }

        if(count($data))
        {
            foreach($data  as $k  => $record )
            {
                if(empty($record['BankAccountID']) || empty($record['AccountName'])){
                    continue;
                }
                ob_start();
                echo "<option value=".$record['BankAccountID'].">".$record['AccountName']."</option>";
                $listData = ob_get_contents();
            }
            ob_end_clean();
            echo $listData;
        }else{
            echo "<option value=''>No data Available</option>";
        }
        return true;


    }

    public function actionOrganizations($CountyID)
    {
        if(!empty($CountyID) )
        {
            $data = Organizations::find()->where(['CountyID' => $CountyID])->orderBy(['OrganizationName' => SORT_ASC])->all();
        }else
        {
            $data = Organizations::find()->orderBy(['OrganizationName' => SORT_ASC])->all();
        }

        if(count($data))
        {
            foreach($data  as $k  => $record )
            {
                if(empty($record['OrganizationID']) || empty($record['OrganizationName'])){
                    continue;
                }
                ob_start();
                echo "<option value=".$record['OrganizationID'].">".$record['OrganizationName']."</option>";
                $listData = ob_get_contents();

            }
            ob_end_clean();
            echo $listData;
        }else{
            echo "<option value=''>No data Available</option>";
        }
        return true;
    }

    /*Should only be NPIU OR CPIU accounts -  lET THE USER SEARCH THIS*/
    public function actionSourceAccounts($CountyID='')
    {
        if(!empty($CountyID))
        {
            $data = BankAccounts::find()->where(['in',['BankTypeID'],[1,2]])->andWhere(['CountyID' => $CountyID])->orderBy(['AccountName' => SORT_ASC])->all();
        }else
        {
            $data = BankAccounts::find()->where(['in',['BankTypeID'],[1,2]])->orderBy(['AccountName' => SORT_ASC])->all();
        }

        if(count($data))
        {
            foreach($data  as $k  => $record )
            {
                if(empty($record['BankAccountID']) || empty($record['AccountName'])){
                    continue;
                }
                ob_start();
                echo "<option value=".$record['BankAccountID'].">".$record['AccountName']."</option>";
                $listData = ob_get_contents();

            }
            ob_end_clean();
            echo $listData;
        }else{
            echo "<option value=''>No data Available</option>";
        }
        return true;
    }


}
