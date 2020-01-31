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
						
					'view' => function ($url, $model) use ($rights) {
						return (isset($rights->View)) ? Html::a('<i class="ft-eye"></i> View', ['view', 'id' => $model->MessageTemplateID], ['class' => 'btn-sm btn-primary']) : '';
					},
					'delete' => function ($url, $model) use ($rights) {
						return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->MessageTemplateID], [
							'class' => 'btn-sm btn-danger btn-xs',
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
