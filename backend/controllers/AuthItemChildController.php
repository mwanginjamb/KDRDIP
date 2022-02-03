<?php

namespace backend\controllers;

use app\models\AuthItem;
use Yii;
use app\models\AuthItemChild;
use app\models\AuthItemChildSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthItemChildController implements the CRUD actions for AuthItemChild model.
 */
class AuthItemChildController extends Controller
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
     * Lists all AuthItemChild models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemChildSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItemChild model.
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
     * Creates a new AuthItemChild model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItemChild();

        // By Default Assign all roles, let admin remove unwanted ones

        $model->permissions = ArrayHelper::map(AuthItem::find()->where(['type' => 2])->all(),'name', 'name');


        if ($model->load(Yii::$app->request->post())  ) {

            foreach($model->permissions as $key => $v)
            {
                $m = new AuthItemChild();
                $m->parent = $model->parent;
                $m->child = $v;
                $m->save();
            }


            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'authItems' => ArrayHelper::map(AuthItem::find()->where(['type' => 2])->all(),'name', 'name'),
            'parents' => ArrayHelper::map(AuthItem::find()->where(['type' => 1])->all(),'name', 'name')
        ]);
    }

    /**
     * Updates an existing AuthItemChild model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

         // Get Assigned permissions
         $assigned = AuthItemChild::find()->where(['parent' => $model->parent])->asArray()->all();
         $model->permissions = ArrayHelper::map($assigned,'child','child');



        if ($model->load(Yii::$app->request->post()) ) {

            /*print '<pre>';
            print_r($model->permissions);
            exit;*/
            // save permissions
            foreach($model->permissions as $key => $v)
            {
                
                $m = new AuthItemChild();
                $m->parent = $model->parent;
                $m->child = $v;
                $m->save();
                
                
            }
            
            

           // return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'authItems' => ArrayHelper::map(AuthItem::find()->where(['type' => 2])->all(),'name', 'name'),
            'parents' => ArrayHelper::map(AuthItem::find()->where(['type' => 1])->all(),'name', 'name'),
        ]);
    }

    /**
     * Deletes an existing AuthItemChild model.
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
     * Finds the AuthItemChild model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AuthItemChild the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItemChild::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
