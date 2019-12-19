<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BankTypes */

$this->title = 'Create Bank Types';
$this->params['breadcrumbs'][] = ['label' => 'Bank Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>
