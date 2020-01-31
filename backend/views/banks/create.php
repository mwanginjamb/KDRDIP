<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Banks */

$this->title = 'Create Bank';
$this->params['breadcrumbs'][] = ['label' => 'Banks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'bankBranches' => $bankBranches,
		'rights' => $rights,
	]) ?>

</section>
