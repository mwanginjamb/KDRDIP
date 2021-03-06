<?php

namespace backend\controllers;

use Yii;
use app\models\Product;
use app\models\UsageUnit;
use app\models\ProductCategory;
use app\models\ProductSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

use kartik\mpdf\Pdf;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(33);

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
	 * Lists all Product models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchfor = array (1=> 'ID', 2 => 'Item Name', 3 => 'Item Category');
			$search = new ProductSearch();
		$params = Yii::$app->request->post();
		if (!empty($params))
		{
			
			$where = '';
			if ($params['ProductSearch']['searchfor'] == 1)
			{
				$searchstring = $params['ProductSearch']['searchstring']; 
				$where = "ProductID = '$searchstring'";
			} else if ($params['ProductSearch']['searchfor'] == 2)
			{
				$searchstring = $params['ProductSearch']['searchstring']; 
				$where = "ProductName like '%$searchstring%'";
			} else if ($params['ProductSearch']['searchfor'] == 3)
			{
				$searchstring = $params['ProductSearch']['searchstring']; 
				$where = "ProductCategoryName like '%$searchstring%'";
			}
			$products = Product::find()->joinWith('productcategory')
											->joinWith('usageunit')
											->where($where);
			$search->searchfor = $params['ProductSearch']['searchfor'];
			$search->searchstring = $params['ProductSearch']['searchstring'];
		} else
		{
			$products = Product::find()->joinWith('productcategory')->joinWith('usageunit');
		}
		
		$dataProvider = new ActiveDataProvider([
			'query' => $products,
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider, 'search' => $search, 'searchfor' => $searchfor,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Product model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => Product::find()->where(['ProductID'=>$id])->joinWith('productcategory')->joinWith('usageunit')->one(),
			'rights' => $this->rights,
		]);
	}

	/**
	 * Creates a new Product model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$identity = Yii::$app->user->identity;
		$UserID = $identity->UserID;
	
		$model = new Product();
		$model->CreatedBy = $UserID;
	
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->ProductID]);
		} else 
		{
			$usageunit = ArrayHelper::map(UsageUnit::find()->all(), 'UsageUnitID', 'UsageUnitName');
			
			$productcategory = ArrayHelper::map(ProductCategory::find()->all(), 'ProductCategoryID', 'ProductCategoryName');
			return $this->render('create', [
				'model' => $model, 'usageunit' => $usageunit, 'productcategory' => $productcategory,
				'rights' => $this->rights,
			]);
		}
	}

	/**
	 * Updates an existing Product model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->ProductID]);
		} 

		$usageunit = ArrayHelper::map(UsageUnit::find()->all(), 'UsageUnitID', 'UsageUnitName');
		$productcategory = ArrayHelper::map(ProductCategory::find()->all(), 'ProductCategoryID', 'ProductCategoryName');

		return $this->render('update', [
			'model' => $model, 'usageunit' => $usageunit, 'productcategory' => $productcategory,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing Product model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Product model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Product the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Product::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

public function actionReport() 
{
	$id = 2;
	// get your HTML raw content without any layouts or scripts
	$content = $this->renderPartial('report', ['model' => Product::find()->where(['ProductID'=>$id])->joinWith('productcategory')->joinWith('usageunit')->one()]);
	
	// setup kartik\mpdf\Pdf component
	$pdf = new Pdf([
		// set to use core fonts only
		'mode' => Pdf::MODE_CORE, 
		// A4 paper format
		'format' => Pdf::FORMAT_A4, 
		// portrait orientation
		'orientation' => Pdf::ORIENT_PORTRAIT, 
		// stream to browser inline
		'destination' => Pdf::DEST_STRING, 
		// your html content input
		'content' => $content,  
		// format content from your own css file if needed or use the
		// enhanced bootstrap css built by Krajee for mPDF formatting 
		'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
		// any css to be embedded if required
		'cssInline' => '.kv-heading-1{font-size:18px}', 
			// set mPDF properties on the fly
		'options' => ['title' => 'Krajee Report Title'],
			// call mPDF methods on the fly
		'methods' => [ 
			'SetHeader'=>['Krajee Report Header'], 
			'SetFooter'=>['{PAGENO}'],
		]
	]);
	
	// return the pdf output as per the destination setting
	//return $pdf->render(); 
	$content = $pdf->render('', 'S'); 
	$content = chunk_split(base64_encode($content));
	
	//$pdf->Output('test.pdf', 'F');
	return $this->render('viewreport', [
			'content' => $content,
		]);
}	
}
