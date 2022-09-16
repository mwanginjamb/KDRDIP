<?php

namespace backend\controllers;

use app\models\ImportOrganizations;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use app\models\Organizations;
use app\models\Counties;
use app\models\Countries;
use app\models\LivelihoodActivities;
use app\models\SubCounties;
use app\models\Wards;
use app\models\SubLocations;
use app\models\OrganizationActivities;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;
use yii\web\UploadedFile;

/**
 * OrganizationsController implements the CRUD actions for Organizations model.
 */
class OrganizationsController extends Controller
{
    public $rights;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $this->rights = RightsController::Permissions(139);

        $rightsArray = [];
        if (isset($this->rights->View)) {
            array_push($rightsArray, 'index', 'view');
        }
        if (isset($this->rights->Create)) {
            array_push($rightsArray, 'view', 'create');
        }
        if (isset($this->rights->Edit)) {
            array_push($rightsArray, 'index', 'view', 'update', 'approval', 'approvallist', 'submit');
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
                'only' => ['index', 'view', 'create', 'update', 'delete', 'approval', 'approvallist', 'submit'],
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
     * Lists all Organizations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Organizations::find();

        $countQuery = clone $query;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>  [
                'pageSize' => $countQuery->count()
            ],
            'totalCount' => $countQuery->count(),
            'sort' => [
                'defaultOrder' => [
                    'OrganizationID' => SORT_DESC,
                    'OrganizationName' => SORT_ASC,
                ],
            ],


        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'rights' => $this->rights,

        ]);
    }



    /**
     * Displays a single Organizations model.
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
     * Creates a new Organizations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Organizations();
        $model->CreatedBy = Yii::$app->user->identity->UserID;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->OrganizationID]);
        }

        $livelihoodActivities = ArrayHelper::map(LivelihoodActivities::find()->orderBy('LivelihoodActivityID')->all(), 'LivelihoodActivityID', 'LivelihoodActivityName');
        $countries = ArrayHelper::map(Countries::find()->orderBy('CountryName')->all(), 'CountryID', 'CountryName');
        $counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
        $subCounties = ArrayHelper::map(SubCounties::find()->where(['CountyID' => $model->CountyID])->all(), 'SubCountyID', 'SubCountyName');
        $wards = ArrayHelper::map(Wards::find()->where(['SubCountyID' => $model->SubCountyID])->all(), 'WardID', 'WardName');
        $subLocations = ArrayHelper::map(SubLocations::find()->where(['LocationID' => $model->WardID])->all(), 'SubLocationID', 'SubLocationName');

        return $this->render('create', [
            'model' => $model,
            'countries' => $countries,
            'counties' => $counties,
            'subCounties' => $subCounties,
            'wards' => $wards,
            'subLocations' => $subLocations,
            'rights' => $this->rights,
            'livelihoodActivities' => $livelihoodActivities,
        ]);
    }

    /**
     * Updates an existing Organizations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {

                return $this->redirect(['view', 'id' => $model->OrganizationID]);
            }
        }

        $livelihoodActivities = ArrayHelper::map(LivelihoodActivities::find()->orderBy('LivelihoodActivityID')->all(), 'LivelihoodActivityID', 'LivelihoodActivityName');
        $countries = ArrayHelper::map(Countries::find()->orderBy('CountryName')->all(), 'CountryID', 'CountryName');
        $counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
        $subCounties = ArrayHelper::map(SubCounties::find()->where(['CountyID' => $model->CountyID])->all(), 'SubCountyID', 'SubCountyName');
        $wards = ArrayHelper::map(Wards::find()->where(['SubCountyID' => $model->SubCountyID])->all(), 'WardID', 'WardName');
        $subLocations = ArrayHelper::map(SubLocations::find()->where(['LocationID' => $model->WardID])->all(), 'SubLocationID', 'SubLocationName');

        return $this->render('update', [
            'model' => $model,
            'countries' => $countries,
            'counties' => $counties,
            'subCounties' => $subCounties,
            'wards' => $wards,
            'subLocations' => $subLocations,
            'rights' => $this->rights,
            'livelihoodActivities' => $livelihoodActivities,
        ]);
    }

    /**
     * Deletes an existing Organizations model.
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
     * Finds the Organizations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Organizations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Organizations::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionExcelImport()
    {
        $model = new  ImportOrganizations();
        return $this->render('excelImport', ['model' => $model]);
    }

    public function actionImport()
    {
        $model = new ImportOrganizations();
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
        $today = date('Y-m-d');
        foreach ($sheetData as $key => $data) {
            // Read from 4th row
            if ($key >= 4) {
                if (trim($data['B']) !== '') {
                    $model = new Organizations();
                    $model->OrganizationName = $data['B'];
                    $model->TradingName = $data['C'];
                    $model->RegistrationDate =  date('Y-m-d', strtotime($data['D']));
                    $model->LivelihoodActivityID = $this->getLivelihoodActivityID($data['E']);
                    $model->MaleMembers = (trim($data['F']) !== '') ? $data['F'] : 0;
                    $model->FemaleMembers = (trim($data['G']) !== '') ? $data['G'] : 0;
                    $model->PWDMembers = (trim($data['H']) !== '') ? $data['H'] : 0;
                    $model->TotalAmountRequired = (trim($data['I']) !== '') ? $data['I'] : 0;
                    $model->CommunityContribution = (trim($data['J']) !== '') ? $data['J'] : 0;
                    $model->CountyContribution = (trim($data['K']) !== '') ? $data['K'] : 0;
                    $model->BalanceRequired = (trim($data['L']) !== '') ? $data['L'] : 0;
                    $model->PostalAddress = (trim($data['M']) !== '') ? $data['M'] : 'Not Set';
                    $model->PostalCode = (trim($data['N']) !== '') ? $data['N'] : 'Not Set';
                    $model->Town = (trim($data['O']) !== '') ? $data['O'] : 'Not Set';
                    $model->CountryID = (trim($data['P']) !== '') ? $this->getCountry($data['P']) : 1; // "todo - write fxn to get countryid"
                    $model->PhysicalLocation = (trim($data['Q']) !== '') ? $data['Q'] : 'Not Set';
                    $model->Telephone = (trim($data['R']) !== '') ? $data['R'] : 'Not Set';
                    $model->Mobile = (trim($data['S']) !== '') ? $data['S'] : 'Not Set';
                    $model->Email = (trim($data['T']) !== '') ? $data['T'] : 'Not Set';
                    $model->Url = (trim($data['U']) !== '') ? $data['U'] : 'Not Set';
                    $model->CountyID = (trim($data['V']) !== '') ? $this->getCounty($data['V']) : 0;
                    $model->SubCountyID = (trim($data['W']) !== '') ? $this->getSubCounty($data['W']) : 0; // @todo - write fxn to get subcounty id
                    $model->WardID = (trim($data['X']) !== '' && $this->getWard($data['X'])) ? $this->getWard($data['X']) : 1; // @todo - write a fxn to get wardID
                    $model->SubLocationID = (trim($data['Y']) !== '' && $this->getSublocation($data['Y'])) ? $this->getSublocation($data['Y']) : 1; //@todo - write a fxn to get sublocID/ Village




                    $model->CreatedBy = Yii::$app->user->identity->UserID;
                    $model->CreatedDate = $today;


                    if (!$model->save()) {

                        foreach ($model->errors as $k => $v) {
                            Yii::$app->session->setFlash('error', $v[0] . ' Got value: ' . $model->$k . ' On Group: ' . $data['B']);
                        }
                    } else {
                        Yii::$app->session->setFlash('success', 'Congratulations, all valid records are completely imported into MIS.');
                    }
                }
            }
        }

        return $this->redirect('index');
    }


    // get Livelihood activity
    private function getLivelihoodActivityID($name)
    {
        if (empty($name)) {
            return 0; // county not found
        }
        // 'LivelihoodActivityID', 'LivelihoodActivityName'
        $model = LivelihoodActivities::findOne(['LivelihoodActivityName' => $name]);
        if ($model) {
            return $model->LivelihoodActivityID;
        } else {
            return 0; // Activity not found
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

    private function getCountry($name)
    {
        if (empty($name)) {
            return 0; // county not found
        }
        $model = Countries::findOne(['CountryName' => $name]);
        if ($model) {
            return $model->CountryID;
        } else {
            return 0; // country not found
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

    public function actionSubCounties($id)
    {
        $model = SubCounties::find()->orderBy('SubCountyName')->where(['CountyID' => $id])->all();

        if (!empty($model)) {
            echo '<option value="0">Select...</option>';
            foreach ($model as $item) {
                echo "<option value='" . $item->SubCountyID . "'>" . $item->SubCountyName . "</option>";
            }
        } else {
            echo '<option value="0">Select...</option>';
        }
    }

    public function actionWards($id)
    {
        $model = Wards::find()->orderBy('WardName')->where(['SubCountyID' => $id])->all();

        if (!empty($model)) {
            echo '<option value="0">Select...</option>';
            foreach ($model as $item) {
                echo "<option value='" . $item->WardID . "'>" . $item->WardName . "</option>";
            }
        } else {
            echo '<option value="0">Select...</option>';
        }
    }

    public function actionSubLocations($id)
    {
        $model = SubLocations::find()->where(['LocationID' => $id])->all();

        if (!empty($model)) {
            echo '<option value="0">Select...</option>';
            foreach ($model as $item) {
                echo "<option value='" . $item->SubLocationID . "'>" . $item->SubLocationName . "</option>";
            }
        } else {
            echo '<option value="0">Select...</option>';
        }
    }
}
