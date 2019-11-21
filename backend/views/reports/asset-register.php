<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Asset Register';
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
			'label'=>'AssetNo',
			'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:center'],
			'contentOptions' => ['style' => 'text-align:center'],
			'format'=>'text',
			'value' => 'AssetNo',
			'contentOptions' => ['style' => 'text-align:center'],
		],
		[
			'label'=>'Description',
			'headerOptions' => ['style'=>'color:black; text-align:left'],
			'format'=>'text',
			'value' => 'Description',
			'contentOptions' => ['style' => 'text-align:left'],
		],
		[
			'label'=>'Project',
			'headerOptions' => ['width' => '17%', 'style'=>'color:black; text-align:left'],
			'format'=> 'text',
			'value' => 'projects.ProjectName',
			'contentOptions' => ['style' => 'text-align:left'],
		],
		[
			'label'=>'Location',
			'headerOptions' => ['width' => '17%', 'style'=>'color:black; text-align:left'],
			'format'=> 'text',
			'value' => 'Location',
			'contentOptions' => ['style' => 'text-align:left'],
		],
		[
			'label'=>'Value',
			'headerOptions' => ['width' => '17%', 'style'=>'color:black; text-align:right'],
			'format'=>['Decimal',2],
			'value' => 'Value',
			'contentOptions' => ['style' => 'text-align:right'],
		],	
	],
]); ?>
