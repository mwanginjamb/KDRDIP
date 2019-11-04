<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	//print_r($dataProvider); exit;
	$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page-default">
	<div class="container">
		<?= Html::a('<i class="ft-x"></i> Close', [$returnlink, 'id' => $model->PurchaseID], ['class' => 'btn btn-warning mr-1', 'style' => 'margin-bottom:10px']) ?>
		<iframe src="data:application/pdf;base64,<?= $content; ?>" height="700px" width="100%"></iframe>
	</div>	
</section>