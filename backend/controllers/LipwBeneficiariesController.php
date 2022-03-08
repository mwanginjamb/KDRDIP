<?php

namespace backend\controllers;

use Yii;
use app\models\LipwBeneficiaries;
use app\models\BankBranches;
use app\models\LipwBeneficiaryTypes;
use app\models\Banks;
use app\models\ImportBeneficiaries;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\web\UploadedFile;

/**
 * LipwBeneficiariesController implements the CRUD actions for LipwBeneficiaries model.
 */
class LipwBeneficiariesController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(98);

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
	 * Lists all LipwBeneficiaries models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$hId = isset(Yii::$app->request->get()['hId']) ? Yii::$app->request->get()['hId'] : 0;

		$dataProvider = new ActiveDataProvider([
			'query' => LipwBeneficiaries::find()->andWhere(['HouseholdID' => $hId]),
		]);

		return $this->renderPartial('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'hId' => $hId,
		]);
	}

	/**
	 * Displays a single LipwBeneficiaries model.
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
	 * Creates a new LipwBeneficiaries model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$hId = isset(Yii::$app->request->get()['hId']) ? Yii::$app->request->get()['hId'] : 0;

		$model = new LipwBeneficiaries();
		$model->HouseholdID = $hId;

		if ($model->load(Yii::$app->request->post())) {

			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			if($model->save())
			{
				Yii::$app->session->setFlash('success', 'Record Saved Successfully.', true);
				return ['success' => 'Record Saved Successfully'];
			}else{
				if(count($model->errors))
				{
					//Yii::$app->session->setFlash('error', $model->FirstError, true);
					return ['errors' => $model->getErrorSummary(true)];
					
				}
			}
			//return $this->redirect(['index', 'hId' => $model->HouseholdID]);
		}

		$banks = ArrayHelper::map(Banks::find()->all(), 'BankID', 'BankName');
		$bankBranches = ArrayHelper::map(BankBranches::find()->andWhere(['BankID' => $model->BankID])->all(), 'BankBranchID', 'BankBranchName');
		$beneficiaries = ArrayHelper::map(LipwBeneficiaries::find()->andWhere(['BeneficiaryTypeID' => 1])->all(), 'BeneficiaryID', 'BeneficiaryName');
		$beneficiaryTypes = ArrayHelper::map(LipwBeneficiaryTypes::find()->all(), 'BeneficiaryTypeID', 'BeneficiaryTypeName');
		
		$gender = ['M' => 'Male', 'F' => 'Female'];

		return $this->renderPartial('create', [
			'model' => $model,
			'rights' => $this->rights,
			'hId' => $hId,
			'banks' => $banks,
			'bankBranches' => $bankBranches,
			'beneficiaries' => $beneficiaries,
			'gender' => $gender,
			'beneficiaryTypes' => $beneficiaryTypes
		]);
	}

	/**
	 * Updates an existing LipwBeneficiaries model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		// echo $id; exit;
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) ) {

			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			if($model->save()){
				//return $this->redirect(['index', 'hId' => $model->HouseholdID]);
				Yii::$app->session->setFlash('success', 'Record Saved Successfully.', true);
				return ['success' => 'Record Saved Successfully'];

			}else{
				
				if(count($model->errors))
				{
					//Yii::$app->session->setFlash('error', $model->FirstError, true);
					return ['errors' => $model->getErrorSummary(true)];
					
				}
				
			}
		}

		$banks = ArrayHelper::map(Banks::find()->all(), 'BankID', 'BankName');
		$bankBranches = ArrayHelper::map(BankBranches::find()->andWhere(['BankID' => $model->BankID])->all(), 'BankBranchID', 'BankBranchName');
		$beneficiaries = ArrayHelper::map(LipwBeneficiaries::find()->andWhere(['BeneficiaryTypeID' => 1])->andWhere("BeneficiaryID <> $id")->all(), 'BeneficiaryID', 'BeneficiaryName');
		$beneficiaryTypes = ArrayHelper::map(LipwBeneficiaryTypes::find()->all(), 'BeneficiaryTypeID', 'BeneficiaryTypeName');
		$gender = ['M' => 'Male', 'F' => 'Female'];

		return $this->renderPartial('update', [
			'model' => $model,
			'rights' => $this->rights,
			'banks' => $banks,
			'bankBranches' => $bankBranches,
			'beneficiaries' => $beneficiaries,
			'gender' => $gender,
			'beneficiaryTypes' => $beneficiaryTypes,
		]);
	}

	/**
	 * Deletes an existing LipwBeneficiaries model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		//$this->findModel($id)->delete();
		$model = 	LipwBeneficiaries::findOne(['BeneficiaryID' => $id]);
		if($model->delete())
		{
			Yii::$app->session->setFlash('success', 'Record Deleted Successfully.');
		}else{
			Yii::$app->session->setFlash('error', 'Error deleting record.');
		}

		return $this->redirect(['index']);
	}

	/**
	 * Finds the LipwBeneficiaries model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return LipwBeneficiaries the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = LipwBeneficiaries::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}


	public function actionExcelImport()
    {
        $model = new  ImportBeneficiaries();
        return $this->render('excelImport',['model' => $model]);
    }

    public function actionImport()
    {
        $model = new ImportBeneficiaries();
        if($model->load(Yii::$app->request->post()))
        {
            $excelUpload = UploadedFile::getInstance($model, 'excel_doc');
            $model->excel_doc = $excelUpload;
            if($uploadedFile = $model->upload())
            {
                // Extract data from  uploaded file
                $sheetData = $this->extractData($uploadedFile);
                // save the data
                $this->saveData($sheetData);
            }else{
                $this->redirect(['excel-import']);
            }

        }else{
            $this->redirect(['excel-import']);
        }
    }

    private function extractData($file)
    {
        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        return $sheetData;
    }

    private function saveData($sheetData)
    {

        /*print '<pre>';
         print_r($sheetData);
         exit;*/
        $today = date('Y-m-d');
        foreach($sheetData as $key => $data)
        {


            // Read from 2nd row
            if($key >= 2)
            {


					$BeneficiaryType = $Principle = $Gender = 0;
					if(trim($data['E']) == 'Eligible')
					{
						$BeneficiaryType = 1;
					}elseif(trim($data['E']) == 'Dependant') {
						$BeneficiaryType = 2;
					}

					if(trim($data['F']) == 'Yes')
					{
						$Principle = 1;
					}elseif(trim($data['F']) == 'No') {
						$Principle = 2;
					}

					if(trim($data['G']) == 'Male')
					{
						$Gender = 'M';
					}elseif(trim($data['G']) == 'Female') {
						$Gender = 'F';
					}

                if(trim($data['A']) !== '')
                {
                    $model = new LipwBeneficiaries();
                    $model->FirstName = trim($data['A']);
                    $model->MiddleName = trim($data['B']);
					$model->LastName = trim($data['C']);
					$model->DateOfBirth = date('Y-m-d', strtotime(trim($data['D'])));
					$model->BeneficiaryTypeID = $BeneficiaryType;
                    $model->Principal = $Principle ;
                    $model->Gender = $Gender ; // @todo - write fxn to get subcounty id
                    $model->IDNumber = (trim($data['H']) !== '')? $data['H']: '' ;
                    $model->Mobile = (trim($data['I']) !== '' )? $data['I']: 1 ;
                    $model->AlternativeID = (trim($data['J']) !== '' && $this->getAlternate($data['J']))? $this->getAlternate($data['J']): 0 ; //@todo - write a fxn to get sublocID/ Village
                    $model->BankAccountNumber = (trim($data['K']) !== '' )? $data['K']: '' ; 
                    $model->BankAccountName = (trim($data['L']) !== '' )? $data['L']: '' ; 
                    $model->BankID = (trim($data['M']) !== '' && $this->getBankID($data['M']))? $this->getBankID($data['M']): 1 ; //@todo - write a fxn to get sublocID/ Village
                    $model->BankBranchID = (trim($data['N']) !== '' && $this->getBranchID($this->getBankID($data['M']),$data['N']))? $this->getBranchID($this->getBankID($data['M']),$data['N']): '' ; //@todo - write a fxn to get sublocID/ Village
					




                    $model->CreatedBy = Yii::$app->user->identity->UserID;
                    $model->CreatedDate = $today;


                    if(!$model->save())
                    {

                        foreach($model->errors as $k => $v)
                        {
                            Yii::$app->session->setFlash('error',$v[0].' Got value: '.$model->$k.' On Row: '.$key);

                        }

                    }else {
                        Yii::$app->session->setFlash('success','Congratulations, all valid records are completely imported into MIS.');
                    }

                }
            }
        }

        return $this->redirect(['./lipw-households/index']);
    }

	// gET Alternate Beneficiary ID

	private function getAlternate($FirstName)
    {
        $model = LipwBeneficiaries::find()->where(['like',  'FirstName',$FirstName])->one();                                                                                                                                                                                                              ;
        if($model)
        {
            return $model->BeneficiaryID;
        }else{
            return 0; // county not found
        }

    }

	public function getBankID($name)
    {
        $name = trim($name);
        $result = Banks::find()->where(['like',  'BankName',$name])->one();

        if(is_object($result))
        {
            return $result->BankID;
        }

        return false;

    }

	public function getBranchID($BankID, $BranchName)
    {
		
        $result = BankBranches::findOne(['BankBranchName' => $BranchName,'BankID' => $BankID]);
        if(is_object($result))
        {
            return $result->BankBranchID;
        }

        return false;
    }

}
