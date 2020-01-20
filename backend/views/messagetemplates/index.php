<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Message Templates';
$this->params['breadcrumbs'][] = $this->title;
$Rights = Yii::$app->params['rights'];
$FormID = 41;
?>
<section class="page-default">
	<div class="container">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
			/* [
				'label'=>'ID',
				'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'MessageTemplateID',
				'contentOptions' => ['style' => 'text-align:left'],
			], */
			[
				'class' => 'yii\grid\SerialColumn',
				'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
			],
			[
				'label'=>'Code',
				'headerOptions' => [ 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'Code',
				'contentOptions' => ['style' => 'text-align:left'],
			],
			[
				'label'=>'Description',
				'headerOptions' => [ 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'Description',
				'contentOptions' => ['style' => 'text-align:left'],
			],			
			[
				'label'=>'Created Date',
				'headerOptions' => [ 'width' => '17%', 'style'=>'color:black; text-align:left'],
				'format'=>'datetime',
				'value' => 'CreatedDate',
				'contentOptions' => ['style' => 'text-align:left'],
			],
			[
				'label'=>'Created By',
				'headerOptions' => [ 'width' => '15%', 'style'=>'color:black; text-align:left'],
				'format'=>'text',
				'value' => 'users.Full_Name',
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
						return ($Rights[$FormID]['View']) ? Html::a('<span class="fa fa-eye"></span> View', $baseUrl.'/messagetemplates/view?id='.$model->MessageTemplateID, [
									'title' => Yii::t('app', 'View'),
									'class'=>'gridbtn btn-primary btn-xs',                                  
									]) : '';
					},
					'update' => function ($url, $model) use ($Rights, $FormID){
						$baseUrl = Yii::$app->request->baseUrl;
						return ($Rights[$FormID]['Edit']) ? Html::a('<span class="fa fa-edit"></span> Edit', $baseUrl.'/messagetemplates/update?id='.$model->MessageTemplateID, [
									'title' => Yii::t('app', 'Edit'),
									'class'=>'gridbtn btn-primary btn-xs',                                  
									]) : '';
					},
					'delete' => function($url, $model) use ($Rights, $FormID){
						$baseUrl = Yii::$app->request->baseUrl;
							return ($Rights[$FormID]['Delete']) ? Html::a('<span class="fa fa-trash"></span> Delete', ['/messagetemplates/delete', 'id' => $model->MessageTemplateID], [
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
