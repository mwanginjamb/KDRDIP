<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Disbursement */

$this->title = 'Update Disbursement: ' . $model->DisbursementID;
$this->params['breadcrumbs'][] = ['label' => 'Disbursements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DisbursementID, 'url' => ['view', 'id' => $model->DisbursementID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		// 'eTypeId' => $eTypeId,
	]) ?>

</section>

