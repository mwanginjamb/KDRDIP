<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchases';
$this->params['breadcrumbs'][] = $this->title;
$Rights = Yii::$app->params['rights'];
$FormID = 5;
?>
<section class="page-default">
	<div class="container">
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'columns' => [
				/* [
					'label'=>'ID',
					'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
					'contentOptions' => ['style' => 'text-align:center'],
					'format'=>'text',
					'value' => 'PurchaseID',
					'contentOptions' => ['style' => 'text-align:left'],
				], */
				[
					'class' => 'yii\grid\SerialColumn',
					'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
				],
				[
					'label'=>'Date',
					'headerOptions' => ['width' => '10%', 'style'=>'color:black; text-align:left'],
					'contentOptions' => ['style' => 'text-align:center'],
					'format'=>'date',
					'value' => 'CreatedDate',
					'contentOptions' => ['style' => 'text-align:left'],
				],				
				[
					'label'=>'Supplier Name',
					'headerOptions' => ['style'=>'color:black; text-align:left'],
					'format'=>'text',
					'value' => 'suppliers.SupplierName',
					'contentOptions' => ['style' => 'text-align:left'],
				],
				[
					'label'=>'Approval Status',
					'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:left'],
					'format'=>'text',
					'value' => 'approvalstatus.ApprovalStatusName',
					'contentOptions' => ['style' => 'text-align:left'],
				],		
				[
					'label'=>'Posting Date',
					'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:left'],
					'format'=>'date',
					'value' => 'PostingDate',
					'contentOptions' => ['style' => 'text-align:left'],
				],
				[
					'class' => 'yii\grid\ActionColumn', 
					'headerOptions' => ['width' => '7%', 'style'=>'color:black; text-align:center'],
					'template' => '{view}',
					'buttons' => [

						'view' => function ($url, $model) use ($Rights, $FormID){
							$baseUrl = Yii::$app->request->baseUrl;
							return ($Rights[$FormID]['View']) ? Html::a('<span class="fa fa-eye"></span> View', $baseUrl.'/purchases/viewapproved?id='.$model->PurchaseID, [
										'title' => Yii::t('app', 'View'),
										'class'=>'gridbtn btn-primary btn-xs',                                  
										]) : '';
						},							
					],
				],	
			],
		]); ?>
	</div>
</section>
