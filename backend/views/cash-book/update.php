<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CashBook */

$this->title = 'Update Cash Transfer: ' . $model->CashBookID;
$this->params['breadcrumbs'][] = ['label' => 'Cash Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CashBookID, 'url' => ['view', 'id' => $model->CashBookID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'bankAccounts' => $bankAccounts
	]) ?>

</section>
