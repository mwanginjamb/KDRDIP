<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;

$Rights = Yii::$app->params['rights'];
$FormID = 1;
?>
<section class="page-default">
	<div class="container">

    <?= ($Rights[$FormID]['Insert']) ? Html::a('<span class="fa fa-plus"></span> New', ['create'], ['class' => 'bigbtn btn-success']) : ''?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
			/* [
				'label'=>'ID',
				'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
				'contentOptions' => ['style' => 'text-align:center'],
				'format'=>'text',
				'value' => 'ProductID',
				'contentOptions' => ['style' => 'text-align:left'],
			], */
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
				'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'productcategory.ProductCategoryName',
				'contentOptions' => ['style' => 'text-align:left'],
			],	
			[
				'label'=>'Unit Price',
				'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:right'],
				'format'=>['decimal',2],
				'value' => 'UnitPrice',
				'contentOptions' => ['style' => 'text-align:right'],
			],	
			[
				'label'=>'Usage Unit',
				'headerOptions' => ['width' => '10%', 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'usageunit.UsageUnitName',
				'contentOptions' => ['style' => 'text-align:left'],
			],			
			[
				'label'=>'Active',
				'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'Product_Active',
				'contentOptions' => ['style' => 'text-align:left'],
			],
            [
				'class' => 'yii\grid\ActionColumn', 
				'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
				'template' => '{view} {delete}',
				'buttons' => [

					'view' => function ($url, $model) use ($Rights, $FormID){
						$baseUrl = Yii::$app->request->baseUrl;
						return ($Rights[$FormID]['View']) ? Html::a('<span class="fa fa-eye"></span> View', $baseUrl.'/product/view?id='.$model->ProductID, [
									'title' => Yii::t('app', 'View'),
									'class'=>'gridbtn btn-primary btn-xs',                                  
									]) : '';
					},
					'update' => function ($url, $model) use ($Rights, $FormID){
						$baseUrl = Yii::$app->request->baseUrl;
						return ($Rights[$FormID]['Delete']) ? Html::a('<span class="fa fa-edit"></span> Edit', $baseUrl.'/product/update?id='.$model->ProductID, [
									'title' => Yii::t('app', 'Edit'),
									'class'=>'gridbtn btn-primary btn-xs',                                  
									]) : '';
					},
					'delete' => function($url, $model) use ($Rights, $FormID){
						$baseUrl = Yii::$app->request->baseUrl;
							return ($Rights[$FormID]['Delete']) ? Html::a('<span class="fa fa-trash"></span> Delete', ['/product/delete', 'id' => $model->ProductID], [
								'class' => 'gridbtn btn-danger btn-xs',
								'data' => [
									'confirm' => 'Are you absolutely sure ? You will lose all the information with this action.',
									'method' => 'post',
								],
							]) : '';
					},							
				],
			],	
        ],
    ]); ?>
	</div>
</section>
