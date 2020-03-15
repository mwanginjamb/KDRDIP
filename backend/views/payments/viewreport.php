<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page-default">
	<div class="container">
		<p>
			<?= Html::a('<i class="ft-x"></i> Close', ['view', 'id' => $model->PaymentID], ['class' => 'btn btn-warning mr-1']) ?>
		</p>
		<iframe src="data:application/pdf;base64,<?= $content; ?>" height="700px" width="100%"></iframe>
	</div>	
</section>