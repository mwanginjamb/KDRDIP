<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Price List';
$baseUrl = Yii::$app->request->baseUrl;
$url = $baseUrl.'/suppliers/uploadpricelist?id='.$supplier->SupplierID;
$url2 = $baseUrl.'/suppliers/pricelist?id='.$supplier->SupplierID;

$Rights = Yii::$app->params['rights'];
$FormID = 21;
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
					'value' => 'SupplierCode',
					'contentOptions' => ['style' => 'text-align:left'],
				],				
				[
					'label'=>'Product Name',
					'headerOptions' => ['style'=>'color:black; text-align:left'],
					'format'=>'text',
					'value' => 'ProductName',
					'contentOptions' => ['style' => 'text-align:left'],
				],
				[
					'label'=>'Unit of Measure',
					'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:left'],
					'format'=>'text',
					'value' => 'UnitofMeasure',
					'contentOptions' => ['style' => 'text-align:left'],
				],		
				[
					'label'=>'Price',
					'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:right'],
					'format'=>'decimal',
					'value' => 'Price',
					'contentOptions' => ['style' => 'text-align:right'],
				],	
			],
		]); ?>
	</div>
</section>
