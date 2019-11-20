<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Purchase Summary Report';
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
				'label'=>'ID',
				'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
				'contentOptions' => ['style' => 'text-align:center'],
				'format'=>'text',
				'value' => 'ProductID',
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
				'label'=>'Product Category',
				'headerOptions' => ['width' => '25%', 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'ProductCategoryName',
				'contentOptions' => ['style' => 'text-align:left'],
				 //'group'=>true,
			],	
						[
				'label'=>'Usage Unit',
				'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'UsageUnitName',
				'contentOptions' => ['style' => 'text-align:left'],
			],	
			[
				'label'=>'Quantity',
				'headerOptions' => ['width' => '12%', 'style'=>'color:black; text-align:right'],
				'format'=>['decimal',2],
				'value' => 'Quantity',
				'contentOptions' => ['style' => 'text-align:right'],
			],	
			[
				'label'=>'Unit Price',
				'headerOptions' => ['width' => '12%', 'style'=>'color:black; text-align:right'],
				'format'=>['decimal',2],
				'value' => 'UnitPrice',
				'contentOptions' => ['style' => 'text-align:right'],
			],	
			[
				'label'=>'Total',
				'headerOptions' => ['width' => '12%', 'style'=>'color:black; text-align:right'],
				'format'=>['decimal',2],
				'value' => 'Total',
				'contentOptions' => ['style' => 'text-align:right'],
			],			
        ],
    ]); ?>
