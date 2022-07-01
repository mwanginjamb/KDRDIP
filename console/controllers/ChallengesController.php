<?php

namespace console\controllers;

use Yii;
use console\models\ProjectChallenges;
use yii\console\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\Console;

/**
 * AuthItemController implements the CRUD actions for AuthItem model.
 */
class ChallengesController extends Controller
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
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex($type = 'fund_delay')
    {

        $challenges = [];
        $apiPayLoad = $this->actionChallenges($type);



        foreach ($apiPayLoad as $k => $challenge) {


            $challenges[] = [
                'ProjectID' => $challenge->{'projectsite_info/site_id'} ?? '',
                'challenge' => $challenge->{'projectsite_info/site_issues'} ?? '',
                'description' => $challenge->{'projectsite_info/issue_description'} ?? ''
            ];
        }

        Console::output(print_r($challenges));
        // Update or Create Challenges Model
        foreach ($challenges as $shida) {
            if (!$shida['ProjectID']) {
                continue;
            }
            $model = ProjectChallenges::find()->where(['ProjectID' => $shida['ProjectID']])->one();
            if ($model) {
                $model->Challenge = Yii::$app->params['challengeDictionary'][$shida['challenge']] ?? 'Other';
                $model->challenge_description = $shida['description'] ?? '';
                if ($model->save()) {
                    Console::output('Challenge Updated Successfully. \r\n');
                    Console::output('Challenge of type: ' . $type);
                    Console::output(print_r($model));
                    $this->log('Just Updated .......');
                    $this->log($model);
                } else {
                    $this->log('Updating Error ...');
                    $this->log($model->errors);
                    Console::errorSummary('Error: ' . $model->errors);
                }
            } else {
                $this->log('Attempting to save .......');
                $this->log($shida);
                $model = new ProjectChallenges();
                $model->ProjectID = $shida['ProjectID'];
                $model->Challenge = Yii::$app->params['challengeDictionary'][$shida['challenge']] ?? 'Other';
                $model->challenge_description = $shida['description'] ?? '';
                if ($model->save()) {
                    Console::output('Challenge Saved Successfully.');
                    Console::output(print_r($model));
                    $this->log('Just saved .......');
                    $this->log($model);
                } else {
                    $this->log('Saving Error ...');
                    $this->log($model->errors);
                    Console::errorSummary('Error: ' . $model->errors);
                }
            }

            sleep(5);
        }
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

    public function log($message)
    {
        $message = print_r($message, true);

        $filename = Yii::getAlias('@console') . '/log/challenge.log';

        $req_dump = print_r($message, TRUE);
        $fp = fopen($filename, 'a');
        fwrite($fp, $req_dump);
        fclose($fp);
    }
}
