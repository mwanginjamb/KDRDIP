<?php

namespace backend\controllers;

use app\models\AuthItemType;
use Yii;
use app\models\AuthItem;
use app\models\AuthItemSearch;
use app\models\ProjectChallenges;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\httpClient\Client;

/**
 * AuthItemController implements the CRUD actions for AuthItem model.
 */
class ChallengesBridgeController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'challenges'],
                'rules' => [
                    // Guest Users
                    [
                        'allow' => true,
                        'actions' => ['none', 'index', 'challenges'],
                        'roles' => ['?'],
                    ],
                    // Authenticated Users
                    [
                        'allow' => true,
                        'actions' => ['view', 'create', 'update', 'delete'],
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
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {

        print '<pre>';
        $challenges = [];
        $apiPayLoad = $this->actionChallenges();

        foreach ($apiPayLoad as $k => $challenge) {


            $challenges[] = [
                'ProjectID' => $challenge->{'projectsite_info/site_id'} ?? '',
                'challenge' => $challenge->{'projectsite_info/site_issues'} ?? '',
                'description' => $challenge->{'projectsite_info/issue_description'} ?? ''
            ];
        }


        // Update or Create Challenges Model
        foreach ($challenges as $shida) {
            $model = ProjectChallenges::find()->where(['ProjectID' => $shida['ProjectID']])->one();
            if ($model) {
                $model->Challenge = $shida['challenge'] ?? 'Other'; // @todo get the dictionary of codes from docs
                $model->challenge_description = $shida['description'] ?? '';
                $model->save(false);
            } else {
                $model = new ProjectChallenges();
                $model->ProjectID = $shida['ProjectID'];
                $model->Challenge = $shida['challenge'] ?? 'Other';
                $model->challenge_description = $shida['description'] ?? '';
                $model->save(false);
            }

            sleep(5);
        }



        //print_r($challenges);
        //exit;
    }

    // Get Project Chalenges

    public function actionChallenges($type = 'fund_delay')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://kf.kobotoolbox.org/assets/audTTKEyjEYkUVbYuGsVBL/submissions/?format=json&query=%7B%22projectsite_info/site_issues%22:%22' . $type . '%22%7D%20',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false, // DON'T VERIFY SSL CERTIFICATE
            CURLOPT_SSL_VERIFYHOST => 0, // DON'T VERIFY HOST NAME
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer {{' . env('KOBOKEY') . '}}'
            ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            echo $error_msg;
        }

        curl_close($curl);
        //echo $response;
        return json_decode($response);
    }

    /**
     * Displays a single AuthItem model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
