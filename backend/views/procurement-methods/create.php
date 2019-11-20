<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementMethods */

$this->title = 'Create Procurement Methods';
$this->params['breadcrumbs'][] = ['label' => 'Procurement Methods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>
