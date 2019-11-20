<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Stock Variance Report';
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
			],	
						[
				'label'=>'Usage Unit',
				'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'UsageUnitName',
				'contentOptions' => ['style' => 'text-align:left'],
			],	
			[
				'label'=>'System Quantity',
				'headerOptions' => ['width' => '12%', 'style'=>'color:black; text-align:right'],
				'format'=>['decimal',2],
				'value' => 'CurrentStock',
				'contentOptions' => ['style' => 'text-align:right'],
			],	
			[
				'label'=>'Physical Quantity',
				'headerOptions' => ['width' => '12%', 'style'=>'color:black; text-align:right'],
				'format'=>['decimal',2],
				'value' => 'PhysicalStock',
				'contentOptions' => ['style' => 'text-align:right'],
			],	
			[
				'label'=>'Variance',
				'headerOptions' => ['width' => '12%', 'style'=>'color:black; text-align:right'],
				'format'=>['decimal',2],
				'value' => 'Variance',
				'contentOptions' => ['style' => 'text-align:right'],
			],			
        ],
    ]); ?>
