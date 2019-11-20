<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Supplier Statement';
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
	
	<p><?= isset($supplier) ? $supplier->SupplierName : ''; ?></p>
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
				'label'=>'Date',
				'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:center'],
				'contentOptions' => ['style' => 'text-align:center'],
				'format'=>'Date',
				'value' => 'CreatedDate',
				'contentOptions' => ['style' => 'text-align:center'],
			],
			[
				'label'=>'Description',
				'headerOptions' => ['style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'Description',
				'footer' => 'Balance',
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
