<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Categories';
$baseUrl = Yii::$app->request->baseUrl;

$Rights = Yii::$app->params['rights'];
$FormID = 23;
?>
	<p>
	<div id="msg" style="color:red"></div></p>
	<div class="row">
        <div class="col-lg-6">
			<p><?= $this->title; ?></p>
		</div>
	</div>	
	
	<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'columns' => [
				[
					'label'=>'Code',
					'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
					'contentOptions' => ['style' => 'text-align:center'],
					'format'=>'text',
					'value' => 'ProductCategoryID',
					'contentOptions' => ['style' => 'text-align:left'],
				],				
				[
					'label'=>'Category',
					'headerOptions' => ['style'=>'color:black; text-align:left'],
					'format'=>'text',
					'value' => 'productcategory.ProductCategoryName',
					'contentOptions' => ['style' => 'text-align:left'],
				],
			],
		]); ?>
	</div>
</section>
