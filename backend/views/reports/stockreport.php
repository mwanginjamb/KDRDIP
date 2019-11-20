<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Stock Report';
$Total = 0;
if (!empty($dataProvider->getModels())) 
{
	foreach ($dataProvider->getModels() as $key => $val) 
	{
		//print_r($val);
		//$Total += $val['Quantity'];
    }
}
$Total = number_format($Total,2);
?>
	<p><?= $this->title; ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'showFooter' => false,
		'summary'=>'',
        'columns' => [
			[
				'class' => 'yii\grid\SerialColumn',
				'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
			],
			[
				'label'=>'Product Name',
				'headerOptions' => ['style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'ProductName',
				'contentOptions' => ['style' => 'text-align:left'],
			],
			[
				'label'=>'Product Category',
				'headerOptions' => ['width' => '25%', 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'ProductCategoryName',
				'contentOptions' => ['style' => 'text-align:left'],
			],	
			[
				'label'=>'Ordered',
				'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:right'],
				'format'=>['Decimal',0],
				'value' => 'Ordered',
				'contentOptions' => ['style' => 'text-align:right'],
			],	
			[
				'label'=>'Issued',
				'headerOptions' => ['width' => '17%', 'style'=>'color:black; text-align:right'],
				'format'=>['Decimal',0],
				'value' => 'Issued',
				'contentOptions' => ['style' => 'text-align:right'],
			],	
			[
				'label'=>'Balance',
				'headerOptions' => ['width' => '17%', 'style'=>'color:black; text-align:right'],
				'format'=>['Decimal',0],
				'value' => 'Balance',
				'contentOptions' => ['style' => 'text-align:right'],
			],			
        ],
    ]); ?>
