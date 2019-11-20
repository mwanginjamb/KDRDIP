<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RiskLikelihood */

$this->title = 'Create Risk Likelihood';
$this->params['breadcrumbs'][] = ['label' => 'Risk Likelihoods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>
