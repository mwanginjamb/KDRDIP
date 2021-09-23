<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Galleries';
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
	<?= (isset($rights->Create)) ? Html::a('<i class="ft-plus"></i> New Image', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('project-gallery/create?pId=' . $pId) . '", \'tab14\')']) : '' ?>	
</p>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'showFooter' =>false,
	'layout' => '{items}',
	'tableOptions' => [
		'class' => 'custom-table table-striped table-bordered',
	],
	'columns' => [
		[
			'class' => 'yii\grid\SerialColumn',
			'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
		],
		[
			'attribute' => 'Image',
			'label' => 'Image',
			'format' => 'raw', //['image', ['height' => '60', 'width' => 'auto']],
			'value' => function ($data) {
				return '<a href="#image-gallery" data-toggle="modal" data-image="' . $data['Image'] . '" data-title="' . $data['Caption'] . '"><img src="' . $data['Image'] . '" height="60" width="auto"></a>';
			},
		],
		[
			'label'=>'Caption',
			'headerOptions' => ['style'=>'color:black; text-align:left'],
			'format'=>'text',
			'value' => 'Caption',
			'contentOptions' => ['style' => 'text-align:left'],
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
			'headerOptions' => ['width' => '7%', 'style'=>'color:black; text-align:center'],
			'template' => '{delete}',
			'buttons' => [

				'delete' => function ($url, $model) use ($rights) {
					return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', null, [
						'class' => 'btn-sm btn-danger btn-xs delete',
						'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('project-gallery/delete?id=' . $model->ProjectGalleryID) . '", \'tab14\')',
					]) : '';
				},
			],
		],
	],
]); ?>
</div>



