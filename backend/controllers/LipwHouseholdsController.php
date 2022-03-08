<?php

namespace backend\controllers;

use Yii;
use app\models\LipwHouseholds;
use app\models\Counties;
use app\models\ImportHouseHolds;
use app\models\SubCounties;
use app\models\Locations;
use app\models\SubLocations;
use app\models\Wards;
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
 * LipwHouseholdsController implements the CRUD actions for LipwHouseholds model.
 */
class LipwHouseholdsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		// $this->rights = RightsController::Permissions(97);
		
		
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
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all LipwHouseholds models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => LipwHouseholds::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single LipwHouseholds model.
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
	 * Creates a new LipwHouseholds model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new LipwHouseholds();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->HouseholdID]);
		}

		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->orderBy('SubCountyName')->all(), 'SubCountyID', 'SubCountyName');
		$locations = ArrayHelper::map(Locations::find()->orderBy('LocationName')->all(), 'LocationID', 'LocationName');
		$subLocations = [];

		return $this->render('create', [
			'model' => $model,
			'rights' => $this->rights,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'locations' => $locations,
			'subLocations' => $subLocations,
		]);
	}

	/**
	 * Updates an existing LipwHouseholds model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$subLocation = SubLocations::find()->joinWith('locations')
														->joinWith('locations.subCounties')
														->joinWith('locations.subCounties.counties')
														->where($model->SubLocationID)->one();
		$model->CountyID = $subLocation->locations->subCounties->CountyID;
		$model->SubCountyID = $subLocation->locations->SubCountyID;
		$model->LocationID = $subLocation->locations->LocationID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->HouseholdID]);
		}

		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->where(['CountyID' => $model->CountyID ])->all(), 'SubCountyID', 'SubCountyName');
		$locations = ArrayHelper::map(Locations::find()->where(['LocationID' => $model->SubCountyID ])->all(), 'LocationID', 'LocationName');
		$subLocations = ArrayHelper::map(SubLocations::find()->where(['LocationID' => $model->LocationID ])->all(), 'SubLocationID', 'SubLocationName');

		return $this->render('update', [
			'model' => $model,
			'rights' => $this->rights,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'locations' => $locations,
			'subLocations' => $subLocations,
		]);
	}

	/**
	 * Deletes an existing LipwHouseholds model.
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
	 * Finds the LipwHouseholds model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return LipwHouseholds the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = LipwHouseholds::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public function actionExcelImport()
    {
        $model = new  ImportHouseHolds();
        return $this->render('excelImport',['model' => $model]);
    }

    public function actionImport()
    {
        $model = new ImportHouseHolds();
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
                if(trim($data['A']) !== '')
                {
                    $model = new LipwHouseholds();
                    $model->HouseholdName = trim($data['A']);
                    $model->TotalBeneficiaries = trim($data['F']);
					$model->Notes = trim($data['G']);
					$model->mpesa_account_no = trim($data['H']);
                    $model->CountyID = (trim($data['B']) !== '')? $this->getCounty($data['B']): 0 ;
                    $model->SubCountyID = (trim($data['C']) !== '')? $this->getSubCounty($data['C']): 0 ; // @todo - write fxn to get subcounty id
                    $model->LocationID = (trim($data['D']) !== '' && $this->getWard($data['D']))? $this->getWard($data['D']): 1 ; // @todo - write a fxn to get wardID
                    $model->SubLocationID = (trim($data['E']) !== '' && $this->getSublocation($data['E']))? $this->getSublocation($data['E']): 1 ; //@todo - write a fxn to get sublocID/ Village




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

        return $this->redirect('index');
    }

	private function getCounty($countyName)
    {
        if(empty($countyName)) {
            return 0; // county not found
        }
        $model = Counties::findOne(['CountyName' => $countyName]);
        if($model)
        {
            return $model->CountyID;
        }else{
            return 0; // county not found
        }

    }

	private function getSubCounty($name)
    {
        if(empty($name)) {
            return 0; // county not found
        }
        $model = SubCounties::findOne(['SubCountyName' => $name]);
        if($model)
        {
            return $model->SubCountyID;
        }else{
            return 0; // SubCounty not found
        }
    }

    private function getWard($name)
    {
        if(empty($name)) {
            return 0; // county not found
        }
        $model = Wards::findOne(['WardName' => $name]);
        if($model)
        {
            return $model->WardID;
        }else{
            return 0; // ward not found
        }
    }

    private function  getSublocation($name)
    {
        if(empty($name)) {
            return 0; // county not found
        }
        $model = SubLocations::findOne(['SubLocationName' => $name]);
        if($model)
        {
            return $model->SubLocationID;
        }else{
            return 0; // sublocation not found
        }
    }


	
}
