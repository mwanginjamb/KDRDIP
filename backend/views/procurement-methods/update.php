<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementMethods */

$this->title = 'Update Procurement Methods: ' . $model->ProcurementMethodName;
$this->params['breadcrumbs'][] = ['label' => 'Procurement Methods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProcurementMethodID, 'url' => ['view', 'id' => $model->ProcurementMethodID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
