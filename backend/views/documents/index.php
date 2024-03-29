<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	.btn-primary {
		border-color: #512E90 !important;
		background-color: #6BA342 !important;
		color: #FFFFFF !important;
	}

	.btn-danger {
		color: #FFFFFF !important;
	}
</style>
<h4 class="form-section"><?= $this->title; ?></h4>
<p>
	<?= ($pId) ? Html::a('<i class="ft-plus"></i> New Document', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('documents/create?pId=' . $pId) . '", \'tab15\')']) : '' ?>
	<?= ($oId & $type == 'Minutes') ? Html::a('<i class="ft-plus"></i> New Minutes Document', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('documents/create?oId=' . $oId . '&type=' . $type) . '", \'tab6\')']) : '' ?>
	<?= ($oId & $type == 'Registration Certificate') ? Html::a('<i class="ft-plus"></i> New Registration Document', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('documents/create?oId=' . $oId . '&type=' . $type) . '", \'tab7\')']) : '' ?>
</p>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'layout' => '{items}',
	'tableOptions' => [
		'class' => 'custom-table table-striped table-bordered zero-configuration',
	],
	'columns' => [
		[
			'class' => 'yii\grid\SerialColumn',
			'headerOptions' => ['width' => '5%', 'style' => 'color:black; text-align:left'],
		],
		[
			'label' => 'Description',
			'headerOptions' => ['style' => 'color:black; text-align:left'],
			'format' => 'text',
			'value' => 'Description',
			'contentOptions' => ['style' => 'text-align:left'],
		],
		[
			'label' => 'Document Type',
			'attribute' => 'documentTypes.DocumentTypeName',
			'headerOptions' => ['width' => '15%'],
		],
		[
			'attribute' => 'CreatedDate',
			'format' => ['date', 'php:d/m/Y h:i a'],
			'headerOptions' => ['width' => '15%'],
		],
		[
			'label' => 'Created By',
			'attribute' => 'users.fullName',
			'headerOptions' => ['width' => '15%'],
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'headerOptions' => ['width' => '13%', 'style' => 'color:black; text-align:center'],
			'template' => '{view} {delete}',
			'buttons' => [

				'view' => function ($url, $model) use ($document) {
					if ($document->oId && $document->type == 'Minutes')
						return Html::a('<i class="ft-eye"></i> View', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('documents/view?id=' . $model->DocumentID) . '", \'tab6\')']);
					else if ($document->oId && $document->type == 'Registration Certificate') {
						return Html::a('<i class="ft-eye"></i> View', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('documents/view?id=' . $model->DocumentID) . '", \'tab7\')']);
					} else if ($document->pId) {
						return Html::a('<i class="ft-eye"></i> View', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('documents/view?id=' . $model->DocumentID) . '", \'tab15\')']);
					}
				},
				'delete' => function ($url, $model) use ($rights) {
					return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', null, [
						'class' => 'btn-sm btn-danger btn-xs',
						'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('documents/delete?id=' . $model->DocumentID) . '", \'tab15\')',
					]) : '';
				},
			],
		],
	],
]); ?>