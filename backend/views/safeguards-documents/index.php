<?php

use yii\helpers\Html;
use yii\grid\GridView;
$baseUrl = Yii::$app->request->baseUrl;

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
	<?= (isset($rights->Create)) ? Html::a('<i class="ft-plus"></i> New Document', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('safeguards-documents/create?pId=' . $pId) . '", \'tab2\')']) : '' ?>	
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
			'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
		],
		[
			'label'=>'Description',
			'headerOptions' => ['style'=>'color:black; text-align:left'],
			'format'=>'text',
			'value' => 'Description',
			'contentOptions' => ['style' => 'text-align:left'],
		],
		[
			'label' => 'Document Category',
			'attribute' => 'documentSubCategories.DocumentSubCategoryName',
			'headerOptions' => ['width' => '25%'],
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
			'label' => 'Status',
			'attribute' => 'approvalstatus.ApprovalStatusName',
			'headerOptions' => ['width' => '10%'],
		],		
		[
			'class' => 'yii\grid\ActionColumn',
			'headerOptions' => ['width' => '8%', 'style'=>'color:black; text-align:center'],
			'template' => '{photo} {delete}',
			'buttons' => [

				'photo' => function($url, $model) use ($baseUrl) {
					if ($model->Image != '') {
						return '<a href="#pdf-viewer" data-toggle="modal" data-image="' . $model->Image . '" data-title="document"><img src="' . $baseUrl . '\images\pdf-icon.png" height="30" width="auto"></a>';
					}
				},
				'delete' => function ($url, $model) use ($rights) {
					return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', null, [
						'class' => 'btn-sm btn-danger btn-xs',
						'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('safeguards-documents/delete?id=' . $model->DocumentID) . '", \'tab2\')',
					]) : '';
				},
			],
		],
	],
]); ?>
