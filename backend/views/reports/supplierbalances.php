<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Supplier Balances';
$Total = 0;
if (!empty($dataProvider->getModels())) 
{
	foreach ($dataProvider->getModels() as $key => $val) 
	{
		//print_r($val);
		$Total += $val['Amount'];
    }
}
$Total = number_format($Total,2);
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
			[
				'label'=>'No.',
				'headerOptions' => ['width' => '10%', 'style'=>'color:black; text-align:center'],
				'contentOptions' => ['style' => 'text-align:center'],
				'format'=>'text',
				'value' => 'SupplierID',
				'contentOptions' => ['style' => 'text-align:center'],
			],
			[
				'label'=>'Supplier Name',
				'headerOptions' => ['style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'SupplierName',
				'footer' => 'Total',
				'contentOptions' => ['style' => 'text-align:left'],
				'footerOptions' => ['style' => 'font-weight:bold'],
			],	
			[
				'label'=>'Amount',
				'headerOptions' => ['width' => '17%', 'style'=>'color:black; text-align:right'],
				'format'=>['Decimal',2],
				'value' => 'Amount',
				'contentOptions' => ['style' => 'text-align:right'],
				'footer' => $Total,
				'footerOptions' => ['style' => 'text-align:right; font-weight:bold'],
			],			
        ],
    ]); ?>
