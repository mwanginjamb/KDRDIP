<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Purchases */

$this->title = 'View Purchase :'.$model->PurchaseID;
$this->params['breadcrumbs'][] = $this->title;

$Rights = Yii::$app->params['rights'];
$FormID = 5;

$Total = 0;
if (!empty($dataProvider->getModels())) 
{
	foreach ($dataProvider->getModels() as $key => $val) 
	{
		$Total += $val->Unit_Total;
    }
}
$Total = number_format($Total,2);
?>
<section>
	<div class="container">

		<?= Html::a('Pur. Order', ['purchaseorder', 'id' => $model->PurchaseID, 'returnlink' => 'viewapproved'], ['class' => 'bigbtn btn-primary', 'style' => 'margin-bottom:10px']) ?>
		<?= Html::a('Close', ['approved'], ['class' => 'bigbtn btn-cancel place-right', 'style' => 'margin-bottom:10px']) ?>	

		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'PurchaseID',
				'suppliers.SupplierName',				
				'CreatedDate',
				[
					'label'=>'Requested By',
					'attribute' => 'users.Full_Name',
				] ,
				'Notes:ntext',
				'Postedstring',
				'PostingDate',
				'approvalstatus.ApprovalStatusName',
			],
		]) ?>
		
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'showFooter' =>true,
			'columns' => [
				[
					'label'=>'ID',
					'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
					'contentOptions' => ['style' => 'text-align:center'],
					'format'=>'text',
					'value' => 'PurchaseLineID',
					'contentOptions' => ['style' => 'text-align:left'],
				],		
				[
					'label'=>'Supplier Code',
					'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:left'],
					'format'=>'text',
					'value' => 'SupplierCode',
					'contentOptions' => ['style' => 'text-align:left'],
				],				
				[
					'label'=>'Product Name',
					'headerOptions' => ['style'=>'color:black; text-align:left'],
					'format'=>'text',
					'value' => 'product.ProductName',
					'contentOptions' => ['style' => 'text-align:left'],
					'footer' => 'Total',
					'footerOptions' => ['style' => 'font-weight:bold'],
				],
				[
					'label'=>'Quantity',
					'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:right'],
					'format'=>['decimal',2],
					'value' => 'Quantity',
					'contentOptions' => ['style' => 'text-align:right'],
				],	
				[
					'label'=>'Usage Unit',
					'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:left'],
					'format'=>'text',
					'value' => 'usageunit.UsageUnitName',
					'contentOptions' => ['style' => 'text-align:left'],
				],				
				[
					'label'=>'Unit Price',
					'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:right'],
					'format'=>['decimal',2],
					'value' => 'UnitPrice',
					'contentOptions' => ['style' => 'text-align:right'],
				],	
				[
					'label'=>'Total',
					'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:right'],
					'format'=>['decimal',2],
					'value' => 'Unit_Total',
					'contentOptions' => ['style' => 'text-align:right'],
					'footer' => $Total,
					'footerOptions' => ['style' => 'text-align:right; font-weight:bold'],
				],			
			],
		]); ?>
		<h4>Notes</h4>
		<?= GridView::widget([
			'dataProvider' => $notes,
			'showFooter' =>false,
			'columns' => [
				[
					'class' => 'yii\grid\SerialColumn',
					'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
					'contentOptions' => ['style' => 'text-align:center'],
				],		
				[
					'label'=>'Note',
					'headerOptions' => ['style'=>'color:black; text-align:left'],
					'format'=>'text',
					'value' => 'Note',
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
			],
		]); ?>	

	</div>
</section>
