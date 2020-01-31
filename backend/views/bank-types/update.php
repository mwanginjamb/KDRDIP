<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BankTypes */

$this->title = 'Update Bank Types: ' . $model->BankTypeName;
$this->params['breadcrumbs'][] = ['label' => 'Bank Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->BankTypeID, 'url' => ['view', 'id' => $model->BankTypeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
