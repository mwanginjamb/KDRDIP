<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Company';
$this->params['breadcrumbs'][] = $this->title;

$Rights = Yii::$app->params['rights'];
$FormID = 16;
?>
<section class="page-default">
	<div class="container">
	
    <?= ($Rights[$FormID]['Insert']) ? Html::a('<span class="fa fa-plus"></span> New', ['create'], ['class' => 'bigbtn btn-success']) : ''; ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
				'label'=>'ID',
				'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'CompanyID',
				'contentOptions' => ['style' => 'text-align:left'],
			],
			[
				'label'=>'Company Name',
				'headerOptions' => [ 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'CompanyName',
				'contentOptions' => ['style' => 'text-align:left'],
			],
			[
				'label'=>'Mobile',
				'headerOptions' => [ 'width' => '10%', 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'Mobile',
				'contentOptions' => ['style' => 'text-align:left'],
			],
			[
				'label'=>'Email',
				'headerOptions' => [ 'width' => '20%', 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'Email',
				'contentOptions' => ['style' => 'text-align:left'],
			],
            [
				'class' => 'yii\grid\ActionColumn', 
				'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
				'contentOptions' => ['style' => 'text-align:center'],
				'template' => '{view} {delete}',
				'buttons' => [

					'view' => function ($url, $model) use ($Rights, $FormID){
						$baseUrl = Yii::$app->request->baseUrl;
						return ($Rights[$FormID]['View']) ? Html::a('<span class="fa fa-eye"></span> View', $baseUrl.'/company/view?id='.$model->CompanyID, [
									'title' => Yii::t('app', 'View'),
									'class'=>'gridbtn btn-primary btn-xs',                                  
									]) : '';
					},
					'update' => function ($url, $model) use ($Rights, $FormID){
						$baseUrl = Yii::$app->request->baseUrl;
						return ($Rights[$FormID]['Edit']) ? Html::a('<span class="fa fa-eye"></span> View', $baseUrl.'/company/view?id='.$model->CompanyID, [
									'title' => Yii::t('app', 'View'),
									'class'=>'gridbtn btn-primary btn-xs',                                  
									]) : '';
					},
					'delete' => function($url, $model) use ($Rights, $FormID){
						$baseUrl = Yii::$app->request->baseUrl;
						return ($Rights[$FormID]['Delete']) ? Html::a('<span class="fa fa-trash"></span> Delete', ['/company/delete', 'id' => $model->CompanyID], [
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
