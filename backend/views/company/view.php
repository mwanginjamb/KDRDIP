<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Company */

$this->title = 'View Company: '.$model->CompanyName;
$this->params['breadcrumbs'][] = $this->title;

$Rights = Yii::$app->params['rights'];
$FormID = 16;
?>
<section class="page-default">
	<div class="container">

   
	<?= ($Rights[$FormID]['Edit']) ? Html::a('Edit', ['update', 'id' => $model->CompanyID], ['class' => 'bigbtn btn-primary']) : ''; ?>
	<?= ($Rights[$FormID]['Delete']) ? Html::a('Delete', ['delete', 'id' => $model->CompanyID], [
		'class' => 'bigbtn btn-danger',
		'data' => [
			'confirm' => 'Are you sure you want to delete this item?',
			'method' => 'post',
		],
	]) : ''; ?>
	<?= Html::a('Close', ['index'], ['class' => 'bigbtn btn-cancel place-right']) ?>
    </p>
	
	<?= DetailView::widget([
        'model' => $model,
		'condensed'=>true,
		'hover'=>true,
		'options' => ['class' => 'table-bordered-min'],
		'mode'=>DetailView::MODE_VIEW,
		'attributes'=>[
			['columns' => [
				['attribute'=>'CompanyID',	'valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
				['attribute'=>'CompanyName','valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
			],],
			['columns' => [
				['attribute'=>'PostalAddress', 'valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
				['attribute'=>'PostalCode', 'valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
			],],
			['columns' => [
				['attribute'=>'Town', 'valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
				['attribute'=>'CountryID', 'value'=>isset($model->country) ? $model->country->CountryName : '', 'valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
			],],
			['columns' => [
				['attribute'=>'Telephone', 'valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
				['attribute'=>'Mobile', 'valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
			],],			
			['columns' => [
				['attribute'=>'Email', 'valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
				['attribute'=>'Fax', 'valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
			],],
			['columns' => [
				['attribute'=>'PIN', 'valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
				['attribute'=>'VATNo', 'valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
			],],
			['columns' => [
				['attribute'=>'VATRate', 'valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
				['attribute'=>'Deleted', 'valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
			],],
			['columns' => [
				['attribute'=>'CreatedBy', 'value'=>isset($model->users) ? $model->users->Full_Name : '' ,'valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
				['attribute'=>'CreatedDate', 'valueColOptions'=>['style'=>'width:30%; padding: 4px 4px 4px 4px !important;']],
			],],
		]
    ]) ?>

	</div>
</section>
