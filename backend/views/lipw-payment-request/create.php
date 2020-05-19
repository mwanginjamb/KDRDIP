<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwPaymentRequest */

$this->title = 'Create Lipw Payment Request';
$this->params['breadcrumbs'][] = ['label' => 'Lipw Payment Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'masterRoll' => $masterRoll,
	]) ?>

</section>
