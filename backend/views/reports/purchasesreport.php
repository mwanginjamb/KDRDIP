<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Purchases Report';
$Total = 0;
$TotalAmount = 0;
if (!empty($dataProvider->getModels())) 
{
	foreach ($dataProvider->getModels() as $key => $val) 
	{
		//print_r($val);
		$Total += $val['Quantity'];
		$TotalAmount += $val['LineAmount'];
    }
}
$Total = number_format($Total,2);
$TotalAmount = number_format($TotalAmount,2);
?>
	<p><?= $this->title; ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'showFooter' => true,
		'summary'=>'',
        'columns' => [
			[
				'class' => 'yii\grid\SerialColumn',
				'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
			],
/* 			[
				'label'=>'ID',
				'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
				'contentOptions' => ['style' => 'text-align:center'],
				'format'=>'text',
				'value' => 'ProductID',
				'contentOptions' => ['style' => 'text-align:left'],
			], */
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
				'label'=>'Unit',
				'headerOptions' => ['width' => '10%', 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'UsageUnitName',
				'contentOptions' => ['style' => 'text-align:left'],
				'footer' => 'Total',
				'footerOptions' => ['style' => 'font-weight:bold'],
			],	
			[
				'label'=>'Quantity',
				'headerOptions' => ['width' => '17%', 'style'=>'color:black; text-align:right'],
				'format'=>['Decimal',2],
				'value' => 'Quantity',
				'contentOptions' => ['style' => 'text-align:right'],
				'footer' => $Total,
				'footerOptions' => ['style' => 'text-align:right; font-weight:bold'],
			],		
			[
				'label'=>'Amount',
				'headerOptions' => ['width' => '17%', 'style'=>'color:black; text-align:right'],
				'format'=>['Decimal',2],
				'value' => 'LineAmount',
				'contentOptions' => ['style' => 'text-align:right'],
				'footer' => $TotalAmount,
				'footerOptions' => ['style' => 'text-align:right; font-weight:bold'],
			],			
        ],
    ]); ?>
