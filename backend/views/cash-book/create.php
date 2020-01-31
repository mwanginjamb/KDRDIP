<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CashBook */

$this->title = 'New Cash Transfer';
$this->params['breadcrumbs'][] = ['label' => 'Cash Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'bankAccounts' => $bankAccounts,
		'rights' => $rights,
	]) ?>

</section>