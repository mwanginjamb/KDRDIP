<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Stock Taking Sheet';
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
				'label'=>'Quantity',
				'headerOptions' => ['width' => '17%', 'style'=>'color:black; text-align:right'],
				'format'=>'text',
				'value' => 'Qty',
				'contentOptions' => ['style' => 'text-align:right'],
			],			
        ],
    ]); ?>
