<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Documents */
$baseUrl = Yii::$app->request->baseUrl;

$this->title = $model->Description;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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

.btn-warning {
	color: #FFFFFF !important;
}
</style>

<h4 class="form-section"><?= $this->title; ?></h4>
	<p>
		<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn-sm btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('documents/index?pId=' . $model->RefNumber) . '", \'tab15\')']) ?>
		<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('documents/update?id=' . $model->DocumentID) . '", \'tab15\')']) : '' ?>
		<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->DocumentID], [
				'class' => 'btn-sm btn-danger',
				'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('documents/delete?id=' . $model->DocumentID) . '", \'tab15\')',
		]) : '' ?>
	</p>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'DocumentID',
			'Description',
			[
				'attribute' => 'CreatedDate',
				'format' => ['date', 'php:d/m/Y h:i a'],
			],
			[
				'label' => 'Created By',
				'attribute' => 'users.fullName',
			],
		],
	]) ?>

	<iframe src="<?= $baseUrl . '/uploads/' . $model->FileName; ?>" height="700px" width="100%"></iframe>
</div>
