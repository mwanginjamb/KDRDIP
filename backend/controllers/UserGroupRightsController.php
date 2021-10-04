<?php

namespace backend\controllers;

use app\models\Pages;
use app\models\UserGroups;
use Yii;
use app\models\UserGroupRights;
use app\models\UserGroupRightsSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserGroupRightsController implements the CRUD actions for UserGroupRights model.
 */
class UserGroupRightsController extends Controller
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
     * Lists all UserGroupRights models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserGroupRightsSearch();
       //  $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $query = UserGroupRights::find();

        //$Pages = Pages::findAll(['PageID' => 59]);

        //print '<pre>';
        //print_r($query[0]->page); exit;



        $countQuery = clone $query;
        $modelCount = $countQuery->count();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $modelCount
            ],
            'sort' => [
                'defaultOrder' => [
                    'UserGroupRightID' => SORT_DESC,

                ],
            ],

        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single UserGroupRights model.
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
     * Creates a new UserGroupRights model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserGroupRights();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->UserGroupRightID]);
        }

        return $this->render('create', [
            'model' => $model,
            'userGroups' => ArrayHelper::map(UserGroups::find()->asArray()->all(),'UserGroupID','UserGroupName'),
            'pages' => ArrayHelper::map(Pages::find()->asArray()->all(),'PageID','PageName'),
        ]);
    }

    /**
     * Updates an existing UserGroupRights model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->UserGroupRightID]);
        }

        return $this->render('update', [
            'model' => $model,
            'userGroups' => ArrayHelper::map(UserGroups::find()->asArray()->all(),'UserGroupID','UserGroupName'),
            'pages' => ArrayHelper::map(Pages::find()->asArray()->all(),'PageID','PageName'),
        ]);
    }

    /**
     * Deletes an existing UserGroupRights model.
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
     * Finds the UserGroupRights model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserGroupRights the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserGroupRights::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
