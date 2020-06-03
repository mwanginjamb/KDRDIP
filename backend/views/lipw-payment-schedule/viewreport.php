<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;

	//print_r($dataProvider); exit;
	$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page-default">
	<div class="container">
		<?= Html::a('<i class="ft-arrow-left"></i> Back', ['lipw-payment-schedule/view', 'id' => $pId], ['class' => 'btn btn-secondary mr-1']); ?>
		<p></p>
		<iframe src="data:application/pdf;base64,<?= $content; ?>" height="700px" width="100%"></iframe>
	</div>	
</section>