<?php

namespace backend\controllers;

use app\models\Components;
use app\models\Counties;
use Yii;
use app\models\FinanceWorkplan;
use app\models\FinanceWorkplanLines;
use app\models\FinanceWorkplanSearch;
use app\models\FinancialYear;
use app\models\ImportWorkplan;
use app\models\ProjectSectorInterventions;
use app\models\SubComponents;
use app\models\SubCounties;
use app\models\SubLocations;
use app\models\Wards;
use Mpdf\Tag\Sub;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FinanceWorkplanController implements the CRUD actions for FinanceWorkplan model.
 */
class FinanceWorkplanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all FinanceWorkplan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinanceWorkplanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FinanceWorkplan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        // Lines Dataprovider
        $query = FinanceWorkplanLines::find()->where(['workplan_id' => $id]);
        $countQuery = clone $query;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>  [
                'pageSize' => $countQuery->count()
            ],
            'totalCount' => $countQuery->count(),
            'sort' => [
                'defaultOrder' => [
                    //'OrganizationID' => SORT_DESC,
                    //'OrganizationName' => SORT_ASC,
                ],
            ],

        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new FinanceWorkplan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FinanceWorkplan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FinanceWorkplan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing FinanceWorkplan model.
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
     * Finds the FinanceWorkplan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FinanceWorkplan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FinanceWorkplan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionExcelImport($id)
    {
        $model = new  ImportWorkplan();
        $model->workplanID = $id;
        return $this->render('excelImport', ['model' => $model]);
    }

    public function actionImport()
    {

        $model = new ImportWorkplan();
        // Set session for current workplan id
        Yii::$app->session->set('workplanID', Yii::$app->request->post()['ImportWorkplan']['workplanID']);
        if ($model->load(Yii::$app->request->post())) {
            $excelUpload = UploadedFile::getInstance($model, 'excel_doc');
            $model->excel_doc = $excelUpload;
            if ($uploadedFile = $model->upload()) {
                // Extract data from  uploaded file
                $sheetData = $this->extractData($uploadedFile);
                // save the data
                $this->saveData($sheetData);
            } else {
                $this->redirect(['excel-import']);
            }
        } else {
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

        foreach ($sheetData as $key => $data) {

            // Read from 2nd row
            if ($key > 3) {
                if (trim($data['B']) !== '') {
                    $model = new FinanceWorkplanLines();
                    $model->workplan_id = Yii::$app->session->get('workplanID');
                    $model->subproject = $this->truncateText(trim($data['B']), 150);
                    $model->financial_year = trim($data['C']);
                    $model->period =  trim($data['D']);
                    $model->sector = trim($data['E']);
                    $model->component = trim($data['F']);
                    $model->county = trim($data['H']);
                    $model->subcounty = trim($data['I']);
                    $model->ward = trim($data['J']);
                    $model->village = trim($data['K']);
                    $model->site = trim($data['L']);
                    $model->{'Ha-No'} = trim($data['M']);
                    $model->project_cost = (float)str_replace(',', '', trim($data['N']));
                    $model->remark = trim($data['O']);

                    if (!$model->save()) {

                        foreach ($model->errors as $k => $v) {
                            Yii::$app->session->setFlash('error', $v[0] . ' Got value: ' . $model->$k . ' Sub Project: ' . $data['B']);
                        }
                    } else {
                        Yii::$app->session->setFlash('success', 'Congratulations, all valid records are completely imported into MIS.');
                    }
                }
            }
        }



        return $this->redirect('index');
    }

    // Helper Functions

    private function truncateText($text, $length)
    {
        $string = $text;
        if (strlen($string) > $length) {
            $string = wordwrap($text, $length);
            $string = substr($string, 0, strpos($string, "\n"));
        }
        return $string;
    }

    public function getFinancialYear($name)
    {
        if (empty($name)) {
            return 0; // county not found
        }
        $model = FinancialYear::findOne(['year' => $name]);
        if ($model) {
            return $model->id;
        } else {
            return 0; // year not found
        }
    }

    // Get Component

    private function getComponent($name)
    {
        if (empty($name)) {
            return 0; // record cant be found
        }
        $model = Components::find()->where(['like',  'ShortName', $name])->one();;
        if ($model) {
            return $model->ComponentID;
        } else {
            return 0; // sector not found
        }
    }

    // get Sub component

    private function getSubComponent($name)
    {
        if (empty($name)) {
            return 0;
        }
        $model = SubComponents::find()->where(['like',  'SubComponentName', $name])->one();;
        if ($model) {
            return $model->SubComponentID;
        } else {
            return 0;
        }
    }

    // Get Sector Intervention

    private function getProjectSectorIntervention($name)
    {
        if (empty($name)) {
            return 0; // sector not found
        }
        $model = ProjectSectorInterventions::find()->where(['like',  'SectorInterventionName', $name])->one();;
        if ($model) {
            return $model->SectorInterventionID;
        } else {
            return 0; // sector not found
        }
    }


    private function getCounty($countyName)
    {
        if (empty($countyName)) {
            return 0; // county not found
        }
        $model = Counties::findOne(['CountyName' => $countyName]);
        if ($model) {
            return $model->CountyID;
        } else {
            return 0; // county not found
        }
    }

    private function getSubCounty($name)
    {
        if (empty($name)) {
            return 0; // county not found
        }
        $model = SubCounties::findOne(['SubCountyName' => $name]);
        if ($model) {
            return $model->SubCountyID;
        } else {
            return 0; // SubCounty not found
        }
    }

    private function getWard($name)
    {
        if (empty($name)) {
            return 0; // county not found
        }
        $model = Wards::findOne(['WardName' => $name]);
        if ($model) {
            return $model->WardID;
        } else {
            return 0; // ward not found
        }
    }



    // same as villages
    private function  getSublocation($name)
    {
        if (empty($name)) {
            return 0; // county not found
        }
        $model = SubLocations::findOne(['SubLocationName' => $name]);
        if ($model) {
            return $model->SubLocationID;
        } else {
            return 0; // sublocation not found
        }
    }
}
