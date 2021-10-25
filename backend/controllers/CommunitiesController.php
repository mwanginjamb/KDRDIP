<?php

namespace backend\controllers;

use app\models\CpmcUpload;
use Yii;
use app\models\Communities;
use app\models\Counties;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\web\UploadedFile;


/**
 * CommunitiesController implements the CRUD actions for Communities model.
 */
class CommunitiesController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(12);

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
			'only' => ['index', 'view', 'create', 'update', 'delete','download'],
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
                [
                    'allow' => true,
                    'actions' => ['download'],
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
	 * Lists all Communities models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Communities::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Communities model.
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
	 * Creates a new Communities model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Communities();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->CommunityID]);
		}

		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		return $this->render('create', [
			'model' => $model,
			'counties' => $counties,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing Communities model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->CommunityID]);
		}
		
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		return $this->render('update', [
			'model' => $model,
			'counties' => $counties,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing Communities model.
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
	 * Finds the Communities model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Communities the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Communities::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public function actionExcelImport()
    {
        $model = new  CpmcUpload();
        return $this->render('excelImport',['model' => $model]);
    }

	public function actionImport()
    {
        $model = new CpmcUpload();
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

       /* print '<pre>';
        print_r($sheetData);
        exit;*/

       foreach($sheetData as $key => $data)
       {
           // Read from 3rd row
           if($key >= 3)
           {
               if(trim($data['A']) !== '')
               {
                   $model = new Communities();
                   $model->CommunityName = $data['A'];
                   $model->CountyID = $this->getCounty($data['B']);

                   $model->save();

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

    public function downloadFile($fullpath){
        if(!empty($fullpath)){
            header("Content-type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"); //for excel file
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($fullpath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fullpath));
            flush(); // Flush system output buffer

            Yii::$app->end();
        }
    }

    public function actionDownload()
    {
        $path = Url::home(true)."templates/cpmc_template.xlsx";
       $this->downloadFile($path);
    }
}
