<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Banks */

$this->title = 'Update Banks: ' . $model->BankName;
$this->params['breadcrumbs'][] = ['label' => 'Banks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->BankID, 'url' => ['view', 'id' => $model->BankID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'bankBranches' => $bankBranches,
		'rights' => $rights,
	]) ?>

</section>
