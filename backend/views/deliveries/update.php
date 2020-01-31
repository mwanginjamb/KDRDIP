<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Deliveries */

$this->title = 'Update Deliveries: ' . $model->DeliveryID;
$this->params['breadcrumbs'][] = ['label' => 'Deliveries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DeliveryID, 'url' => ['view', 'id' => $model->DeliveryID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model, 'purchases' => $purchases, 'lines' => $lines, 'data' => $data, 'delivered' => $delivered,
		'rights' => $rights,	
	]) ?>

</section>
